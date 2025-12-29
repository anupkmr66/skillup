<?php
/**
 * Admin Controller
 * Super Admin Dashboard and Management
 */
class AdminController extends Controller
{

    public function __construct()
    {
        // Check if user is super admin
        if (!Session::isAuthenticated() || Session::userRole() != ROLE_SUPER_ADMIN) {
            flashError('Access denied');
            redirect('login');
            exit;
        }
    }

    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        $db = Database::getInstance();

        // Get statistics
        $stats = [
            'total_franchises' => $db->fetchOne("SELECT COUNT(*) as count FROM franchises WHERE status = 'active'")['count'],
            'total_institutes' => $db->fetchOne("SELECT COUNT(*) as count FROM institutes WHERE status = 'active'")['count'],
            'total_students' => $db->fetchOne("SELECT COUNT(*) as count FROM students WHERE status = 'active'")['count'],
            'total_courses' => $db->fetchOne("SELECT COUNT(*) as count FROM courses WHERE status = 'active'")['count'],
            'total_revenue' => $db->fetchOne("SELECT SUM(amount) as total FROM payments")['total'] ?? 0,
            'pending_fees' => $db->fetchOne("SELECT SUM(due_amount) as total FROM fees WHERE status != 'paid'")['total'] ?? 0
        ];

        // Recent students
        $recentStudents = $db->fetchAll("
            SELECT s.*, i.institute_name 
            FROM students s
            LEFT JOIN institutes i ON s.institute_id = i.id
            ORDER BY s.created_at DESC
            LIMIT 10
        ");

        // Recent payments
        $recentPayments = $db->fetchAll("
            SELECT p.*, s.first_name, s.last_name, s.student_id
            FROM payments p
            JOIN students s ON p.student_id = s.id
            ORDER BY p.created_at DESC
            LIMIT 10
        ");

        // Recent franchise inquiries
        $recentInquiries = $db->fetchAll("
            SELECT * FROM franchise_inquiries
            WHERE status = 'new'
            ORDER BY created_at DESC
            LIMIT 5
        ");

        $this->view('admin/dashboard', [
            'stats' => $stats,
            'recentStudents' => $recentStudents,
            'recentPayments' => $recentPayments,
            'recentInquiries' => $recentInquiries
        ], 'layouts/admin');
    }

    /**
     * Manage Franchises
     */
    public function franchises()
    {
        $franchiseModel = new Franchise();
        $franchises = $franchiseModel->all('created_at DESC');

        $db = Database::getInstance();
        $pendingInquiries = $db->fetchAll("SELECT * FROM franchise_inquiries ORDER BY created_at DESC");

        $this->view('admin/franchises', [
            'franchises' => $franchises,
            'pendingInquiries' => $pendingInquiries
        ], 'layouts/admin');
    }

    /**
     * Create Franchise
     */
    public function createFranchise()
    {
        if ($this->isPost()) {
            CSRF::verify();
            $db = Database::getInstance();

            try {
                $db->beginTransaction();

                // 0. Check if Inquiry is already converted
                $inquiryId = $this->post('inquiry_id');
                if (!empty($inquiryId)) {
                    $inquiry = $db->fetchOne("SELECT status FROM franchise_inquiries WHERE id = ?", [$inquiryId]);
                    if ($inquiry && $inquiry['status'] === 'converted') {
                        throw new Exception("This inquiry has already been converted to a franchise.");
                    }
                }

                // 1. Create or Get User for Franchise Admin
                // Check if user already exists
                $existingUser = $db->fetchOne("SELECT id, role_id FROM users WHERE email = ?", [$this->post('email')]);

                if ($existingUser) {
                    // Use existing user
                    $userId = $existingUser['id'];
                    // Optional: Update role if needed, or ensure they are franchise admin
                    if ($existingUser['role_id'] != ROLE_FRANCHISE_ADMIN) {
                        // Decide policy: Do we force role change? For now, let's assume yes if it's a re-creation
                        // $db->update('users', ['role_id' => ROLE_FRANCHISE_ADMIN], "id = $userId");
                    }
                } else {
                    // Create new user
                    // Generate a default username/password or use email
                    $username = strtolower(str_replace(' ', '', $this->post('franchise_name'))) . rand(100, 999);
                    // Default password: Admin@123
                    $passwordHash = password_hash('Admin@123', PASSWORD_DEFAULT);

                    $userId = $db->insert('users', [
                        'role_id' => ROLE_FRANCHISE_ADMIN,
                        'username' => $username,
                        'email' => $this->post('email'),
                        'password_hash' => $passwordHash,
                        'status' => 'active'
                    ]);
                }

                // 2. Generate Franchise Code
                // Format: FR[YEAR][000X]
                $year = date('Y');
                $lastFranchise = $db->fetchOne("SELECT id FROM franchises ORDER BY id DESC LIMIT 1");
                $nextId = ($lastFranchise['id'] ?? 0) + 1;
                $franchiseCode = 'FR' . $year . str_pad($nextId, 4, '0', STR_PAD_LEFT);

                // 3. Create Franchise Record
                $franchiseId = $db->insert('franchises', [
                    'franchise_code' => $franchiseCode,
                    'franchise_name' => $this->post('franchise_name'),
                    'owner_name' => $this->post('contact_person'),
                    'email' => $this->post('email'),
                    'phone' => $this->post('phone'),
                    'address' => $this->post('address'),
                    'city' => $this->post('city'),
                    'state' => $this->post('state'),
                    'pincode' => $this->post('pincode'),
                    'commission_rate' => $this->post('commission_rate') ?: 10.00,
                    'status' => 'active',
                    'user_id' => $userId
                ]);

                // 4. Create Wallet for Franchise
                $db->insert('wallets', [
                    'franchise_id' => $franchiseId,
                    'balance' => 0.00
                ]);

                // 5. Generate Franchise Certificate
                $certNumber = 'FC-' . date('Y') . '-' . str_pad($franchiseId, 4, '0', STR_PAD_LEFT);
                $db->insert('franchise_certificates', [
                    'certificate_number' => $certNumber,
                    'franchise_id' => $franchiseId,
                    'issue_date' => date('Y-m-d')
                ]);

                // 6. Update Inquiry Status if applicable
                $inquiryId = $this->post('inquiry_id');
                if (!empty($inquiryId)) {
                    $db->update('franchise_inquiries', ['status' => 'converted'], "id = $inquiryId");
                }

                $db->commit();
                flashSuccess("Franchise created successfully! Code: $franchiseCode. Login: $username / Admin@123");

            } catch (Exception $e) {
                $db->rollBack();
                flashError('Failed to create franchise: ' . $e->getMessage());
            }

            $this->redirect('admin/franchises');
        }
    }

    /**
     * View Franchise Certificate
     */
    public function viewFranchiseCertificate()
    {
        $franchiseId = $this->get('id');
        if (!$franchiseId) {
            flashError('Invalid franchise ID');
            $this->redirect('admin/franchises');
        }

        $db = Database::getInstance();
        $franchise = $db->fetchOne("SELECT * FROM franchises WHERE id = ?", [$franchiseId]);

        if (!$franchise) {
            flashError('Franchise not found');
            $this->redirect('admin/franchises');
        }

        $certificate = $db->fetchOne("SELECT * FROM franchise_certificates WHERE franchise_id = ?", [$franchiseId]);

        if (!$certificate) {
            // Auto-generate if missing for active franchise
            if ($franchise['status'] === 'active') {
                $certNumber = 'FC-' . date('Y') . '-' . str_pad($franchiseId, 4, '0', STR_PAD_LEFT);
                $db->insert('franchise_certificates', [
                    'certificate_number' => $certNumber,
                    'franchise_id' => $franchiseId,
                    'issue_date' => date('Y-m-d')
                ]);
                $certificate = $db->fetchOne("SELECT * FROM franchise_certificates WHERE franchise_id = ?", [$franchiseId]);
            } else {
                flashError('Certificate not found for this franchise.');
                $this->redirect('admin/franchises');
            }
        }

        $this->view('admin/franchise_certificate', [
            'franchise' => $franchise,
            'certificate' => $certificate
        ], null); // No layout for printable view
    }

    /**
     * Update Franchise
     */
    public function updateFranchise()
    {
        if ($this->isPost()) {
            CSRF::verify();
            $db = Database::getInstance();

            $id = $this->post('id');
            $data = [
                'franchise_name' => $this->post('franchise_name'),
                'contact_person' => $this->post('contact_person'), // Form field
                'owner_name' => $this->post('contact_person'), // DB Column
                'email' => $this->post('email'),
                'phone' => $this->post('phone'),
                'address' => $this->post('address'),
                'city' => $this->post('city'),
                'state' => $this->post('state'),
                'pincode' => $this->post('pincode'),
                'commission_rate' => $this->post('commission_rate')
            ];

            // Remove contact_person from data array before update if it causes issues, 
            // but update() helper might just ignore extra keys if constructed manually.
            // Better to match columns exactly.
            $updateData = [
                'franchise_name' => $data['franchise_name'],
                'owner_name' => $data['owner_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'city' => $data['city'],
                'state' => $data['state'],
                'pincode' => $data['pincode'],
                'commission_rate' => $data['commission_rate']
            ];

            try {
                $db->update('franchises', $updateData, "id = $id");
                flashSuccess('Franchise updated successfully!');
            } catch (Exception $e) {
                flashError('Failed to update franchise: ' . $e->getMessage());
            }

            $this->redirect('admin/franchises');
        }
    }

    /**
     * Delete Franchise
     */
    public function deleteFranchise()
    {
        if ($this->isPost()) {
            CSRF::verify();
            $id = $this->post('id');
            $db = Database::getInstance();

            try {
                $db->beginTransaction();

                // Check if franchise has institutes
                $institutes = $db->fetchOne("SELECT COUNT(*) as count FROM institutes WHERE franchise_id = ?", [$id]);
                if ($institutes['count'] > 0) {
                    $db->rollBack();
                    flashError('Cannot delete franchise with active institutes. Delete institutes first.');
                    $this->redirect('admin/franchises');
                    return;
                }

                // Get franchise email and user_id before deleting
                $franchise = $db->fetchOne("SELECT email, user_id FROM franchises WHERE id = ?", [$id]);

                // 1. Delete Dependencies (Wallets)
                $db->delete('wallets', "franchise_id = $id");

                // 2. Delete Franchise
                $db->delete('franchises', "id = $id");

                // 3. Delete the associated user account to prevent orphans
                if ($franchise && !empty($franchise['user_id'])) {
                    $db->delete('users', "id = {$franchise['user_id']}");
                }

                // 4. Reset inquiry status
                if ($franchise) {
                    $db->update('franchise_inquiries', ['status' => 'new'], "email = '{$franchise['email']}'");
                }

                $db->commit();
                flashSuccess('Franchise deleted and inquiry reactivated successfully!');
            } catch (Exception $e) {
                $db->rollBack();
                flashError('Failed to delete franchise: ' . $e->getMessage());
            }

            $this->redirect('admin/franchises');
        }
    }

    /**
     * Manage Institutes
     */
    public function institutes()
    {
        $db = Database::getInstance();
        $institutes = $db->fetchAll("
            SELECT i.*, f.franchise_name
            FROM institutes i
            LEFT JOIN franchises f ON i.franchise_id = f.id
            ORDER BY i.created_at DESC
        ");

        $this->view('admin/institutes', [
            'institutes' => $institutes
        ], 'layouts/admin');
    }

    /**
     * Create Institute
     */
    public function createInstitute()
    {
        if ($this->isPost()) {
            try {
                CSRF::verify();
                $db = Database::getInstance();
                $db->beginTransaction();

                $email = $this->post('email');
                $password = $this->post('password');

                // 1. Create or Get User for Institute Admin
                $user = $db->fetchOne("SELECT id FROM users WHERE email = ?", [$email]);

                if ($user) {
                    $userId = $user['id'];
                } else {
                    // Create User
                    if (!class_exists('User')) {
                        require_once __DIR__ . '/../Models/User.php';
                    }
                    $userModel = new User();
                    $userId = $userModel->createUser([
                        'username' => $email, // Use email as username
                        'email' => $email,
                        'password' => $password,
                        'role_id' => ROLE_INSTITUTE_ADMIN,
                        'status' => 'active'
                    ]);
                }

                // 2. Generate Institute Code
                $year = date('Y');
                $count = $db->fetchOne("SELECT COUNT(*) as count FROM institutes WHERE YEAR(created_at) = ?", [$year]);
                // Handle potential null count
                $currentCount = $count['count'] ?? 0;
                $sequence = str_pad($currentCount + 1, 4, '0', STR_PAD_LEFT);
                $instituteCode = "INS{$year}{$sequence}";

                // 3. Create Institute
                $data = [
                    'franchise_id' => $this->post('franchise_id'),
                    'institute_code' => $instituteCode,
                    'institute_name' => $this->post('institute_name'),
                    'address' => $this->post('address'),
                    'city' => $this->post('city'),
                    'state' => $this->post('state'),
                    'pincode' => $this->post('pincode'),
                    'contact_person' => $this->post('contact_person'),
                    'phone' => $this->post('phone'),
                    'email' => $email,
                    'user_id' => $userId,
                    'status' => 'active'
                ];

                $db->insert('institutes', $data);

                $db->commit();

                // Send Welcome Email
                $loginUrl = url('login');
                $message = "
                    <h2>Welcome to SkillUp CIMS</h2>
                    <p>Dear {$this->post('contact_person')},</p>
                    <p>Your Institute <strong>{$this->post('institute_name')}</strong> has been successfully registered.</p>
                    <p><strong>Institute Code:</strong> $instituteCode</p>
                    <hr>
                    <h3>Login Credentials:</h3>
                    <p><strong>URL:</strong> <a href='$loginUrl'>$loginUrl</a></p>
                    <p><strong>Username:</strong> $email</p>
                    <p><strong>Password:</strong> $password</p>
                    <hr>
                    <p>Please login and change your password immediately.</p>
                ";

                sendEmail($email, 'Welcome to SkillUp - Institute Registration', $message);

                flashSuccess("Institute created successfully! Code: $instituteCode");

            } catch (Exception $e) {
                $db->rollBack();
                flashError("Failed to create institute: " . $e->getMessage());
            }

            $this->redirect('admin/institutes');
        }
    }

    /**
     * Update Institute
     */
    public function updateInstitute()
    {
        if ($this->isPost()) {
            try {
                CSRF::verify();
                $id = $this->post('id');
                $db = Database::getInstance();

                $data = [
                    'institute_name' => $this->post('institute_name'),
                    'franchise_id' => $this->post('franchise_id'),
                    'contact_person' => $this->post('contact_person'),
                    'phone' => $this->post('phone'),
                    'address' => $this->post('address'),
                    'city' => $this->post('city'),
                    'state' => $this->post('state'),
                    'pincode' => $this->post('pincode'),
                    'status' => $this->post('status')
                ];

                // If password provided, update user password
                $password = $this->post('password');
                if (!empty($password)) {
                    $institute = $db->fetchOne("SELECT user_id FROM institutes WHERE id = ?", [$id]);
                    if ($institute && $institute['user_id']) {
                        if (!class_exists('User')) {
                            require_once __DIR__ . '/../Models/User.php';
                        }
                        $userModel = new User();
                        $userModel->updatePassword($institute['user_id'], $password);
                    }
                }

                $db->update('institutes', $data, "id = $id");
                flashSuccess('Institute updated successfully');

            } catch (Exception $e) {
                flashError('Failed to update institute: ' . $e->getMessage());
            }
            $this->redirect('admin/institutes');
        }
    }

    /**
     * Delete Institute
     */
    public function deleteInstitute()
    {
        if ($this->isPost()) {
            try {
                CSRF::verify();
                $id = $this->post('id');
                $db = Database::getInstance();

                // Check for dependencies (active students, etc)
                // For now, assuming cascade or simple check

                $db->beginTransaction();

                // Get user_id to delete user account
                $institute = $db->fetchOne("SELECT user_id FROM institutes WHERE id = ?", [$id]);

                // Delete Institute
                $db->delete('institutes', "id = $id");

                // Check if user should be deleted
                if ($institute && $institute['user_id']) {
                    $userId = $institute['user_id'];

                    // Check if this user is a Franchise Admin
                    $isFranchiseAdmin = $db->fetchOne("SELECT count(*) as count FROM franchises WHERE user_id = ?", [$userId]);

                    // Check if this user manages other Institutes
                    $isOtherInstituteAdmin = $db->fetchOne("SELECT count(*) as count FROM institutes WHERE user_id = ?", [$userId]);

                    if (($isFranchiseAdmin['count'] == 0) && ($isOtherInstituteAdmin['count'] == 0)) {
                        $db->delete('users', "id = $userId");
                    }
                }

                $db->commit();
                flashSuccess('Institute deleted successfully');

            } catch (Exception $e) {
                $db->rollBack();
                flashError('Failed to delete institute: ' . $e->getMessage());
            }
            $this->redirect('admin/institutes');
        }
    }

    /**
     * Admin Reports
     */
    public function reports()
    {
        $db = Database::getInstance();

        // 1. Student Statistics
        $totalStudents = $db->fetchOne("SELECT COUNT(*) as count FROM students")['count'];
        $activeStudents = $db->fetchOne("SELECT COUNT(*) as count FROM students WHERE status = 'active'")['count'];

        // Enrollment by Status (for Chart)
        $enrollmentStats = $db->fetchAll("SELECT status, COUNT(*) as count FROM students GROUP BY status");
        $enrollmentData = [
            'labels' => [],
            'data' => []
        ];
        foreach ($enrollmentStats as $stat) {
            $enrollmentData['labels'][] = ucfirst($stat['status']);
            $enrollmentData['data'][] = $stat['count'];
        }

        // 2. Financial Statistics
        // Total collected (from payments table)
        $totalCollected = $db->fetchOne("SELECT SUM(amount) as total FROM payments")['total'] ?? 0;

        // Pending fees (sum of due_amount from fees table)
        $totalPending = $db->fetchOne("SELECT SUM(due_amount) as total FROM fees")['total'] ?? 0;

        // 3. Monthly Revenue Trend (Last 12 months)
        $revenueStats = $db->fetchAll("
            SELECT 
                DATE_FORMAT(payment_date, '%Y-%m') as month_year,
                DATE_FORMAT(payment_date, '%b') as month_name,
                SUM(amount) as total
            FROM payments 
            WHERE payment_date >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
            GROUP BY month_year, month_name
            ORDER BY month_year ASC
        ");

        $revenueData = [
            'labels' => [],
            'data' => []
        ];
        foreach ($revenueStats as $stat) {
            $revenueData['labels'][] = $stat['month_name'];
            $revenueData['data'][] = $stat['total'];
        }

        // 4. Monthly Summary (For Table - Last 6 months)
        $monthlySummary = $db->fetchAll("
            SELECT 
                DATE_FORMAT(created_at, '%Y-%m') as month_year,
                DATE_FORMAT(created_at, '%M %Y') as display_month,
                COUNT(*) as new_students
            FROM students
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY month_year, display_month
            ORDER BY month_year DESC
        ");

        // Merge financial data into summary
        foreach ($monthlySummary as &$month) {
            $revenue = $db->fetchOne("
                SELECT SUM(amount) as total 
                FROM payments 
                WHERE DATE_FORMAT(payment_date, '%Y-%m') = ? 
            ", [$month['month_year']]);

            $month['revenue'] = $revenue['total'] ?? 0;

            // Dummy certificate count for now (or query if certificates table exists)
            $month['certificates'] = 0;
        }


        // 5. Counts for Cards
        $totalFranchises = $db->fetchOne("SELECT COUNT(*) as count FROM franchises WHERE status = 'active'")['count'];
        $totalCourses = $db->fetchOne("SELECT COUNT(*) as count FROM courses WHERE status = 'active'")['count'];

        $this->view('admin/reports', [
            'totalStudents' => $totalStudents,
            'totalCollected' => $totalCollected,
            'totalPending' => $totalPending,
            'totalFranchises' => $totalFranchises,
            'totalCourses' => $totalCourses,
            'enrollmentData' => $enrollmentData,
            'revenueData' => $revenueData,
            'monthlySummary' => $monthlySummary
        ], 'layouts/admin');
    }

    /**
     * Manage Students
     */
    public function students()
    {
        $db = Database::getInstance();
        $students = $db->fetchAll("
            SELECT s.*, i.institute_name
            FROM students s
            LEFT JOIN institutes i ON s.institute_id = i.id
            ORDER BY s.created_at DESC
        ");

        // Get institutes for the dropdown
        $institutes = $db->fetchAll("SELECT id, institute_name FROM institutes WHERE status = 'active' ORDER BY institute_name");

        $this->view('admin/students', [
            'students' => $students,
            'institutes' => $institutes
        ], 'layouts/admin');
    }



    /**
     * Settings
     */
    public function settings()
    {
        $db = Database::getInstance();
        $settings = $db->fetchAll("SELECT * FROM settings");

        $this->view('admin/settings', [
            'settings' => $settings
        ], 'layouts/admin');
    }

    /**
     * Update Settings
     */
    public function updateSettings()
    {
        if ($this->isPost()) {
            CSRF::verify();
            $db = Database::getInstance();

            try {
                // Loop through posted data and update settings
                foreach ($_POST as $key => $value) {
                    if ($key === 'csrf_token')
                        continue;

                    // Check if setting exists first
                    $exists = $db->fetchOne("SELECT id FROM settings WHERE setting_key = ?", [$key]);

                    if ($exists) {
                        $db->update('settings', ['setting_value' => $value], "setting_key = '$key'");
                    }
                }

                flashSuccess('Settings updated successfully');
            } catch (Exception $e) {
                flashError('Failed to update settings: ' . $e->getMessage());
            }

            $this->redirect('admin/settings');
        }
    }

    /**
     * Manage Leads
     */
    public function leads()
    {
        $db = Database::getInstance();
        $leads = $db->fetchAll("
            SELECT l.*, c.course_name 
            FROM leads l 
            LEFT JOIN courses c ON l.course_id = c.id 
            ORDER BY l.created_at DESC
        ");

        $this->view('admin/leads', [
            'leads' => $leads
        ], 'layouts/admin');
    }
    /**
     * Manage Courses
     */
    public function courses()
    {
        $db = Database::getInstance();
        $courses = $db->fetchAll("SELECT * FROM courses ORDER BY course_name");

        $this->view('admin/courses', [
            'courses' => $courses
        ], 'layouts/admin');
    }

    /**
     * Create Course
     */
    public function createCourse()
    {
        if ($this->isPost()) {
            try {
                CSRF::verify();
                $db = Database::getInstance();

                $offerPrice = $this->post('offer_price');
                $regularPrice = $this->post('regular_price');

                // offer_price is required, fee column maps to offer_price
                if ($offerPrice === null || $offerPrice === '') {
                    flashError('Offer Price is required');
                    $this->redirect('admin/courses');
                    return;
                }

                $data = [
                    'course_name' => $this->post('course_name'),
                    'course_code' => $this->post('course_code'),
                    'duration' => $this->post('duration'), // in months
                    'fee' => $offerPrice,
                    'regular_price' => $regularPrice ?: 0,
                    'offer_price' => $offerPrice,
                    'description' => $this->post('description'),
                    'category' => $this->post('category'),
                    'status' => 'active'
                ];

                $db->insert('courses', $data);
                flashSuccess('Course created successfully');

            } catch (Exception $e) {
                flashError('Failed to create course: ' . $e->getMessage());
            }
            $this->redirect('admin/courses');
        }
    }

    /**
     * Update Course
     */
    public function updateCourse()
    {
        if ($this->isPost()) {
            try {
                CSRF::verify();
                $db = Database::getInstance();
                $id = $this->post('id');

                $offerPrice = $this->post('offer_price');
                $regularPrice = $this->post('regular_price');

                if ($offerPrice === null || $offerPrice === '') {
                    flashError('Offer Price is required');
                    $this->redirect('admin/courses');
                    return;
                }

                $data = [
                    'course_name' => $this->post('course_name'),
                    'course_code' => $this->post('course_code'),
                    'duration' => $this->post('duration'),
                    'fee' => $offerPrice,
                    'regular_price' => $regularPrice ?: 0,
                    'offer_price' => $offerPrice,
                    'description' => $this->post('description'),
                    'category' => $this->post('category'),
                    'status' => $this->post('status')
                ];

                $db->update('courses', $data, "id = $id");
                flashSuccess('Course updated successfully');

            } catch (Exception $e) {
                flashError('Failed to update course: ' . $e->getMessage());
            }
            $this->redirect('admin/courses');
        }
    }

    /**
     * Delete Course
     */
    public function deleteCourse()
    {
        if ($this->isPost()) {
            try {
                CSRF::verify();
                $db = Database::getInstance();
                $id = $this->post('id');

                if (empty($id)) {
                    flashError('Invalid Course ID');
                    $this->redirect('admin/courses');
                    return;
                }

                // Check for dependencies (active batches/students?)
                $hasStudents = $db->fetchOne("SELECT count(*) as count FROM student_courses WHERE course_id = ?", [$id]);

                if ($hasStudents['count'] > 0) {
                    flashError('Cannot delete course: It has active students enrolled.');
                } else {
                    $db->delete('courses', "id = ?", [$id]);
                    flashSuccess('Course deleted successfully');
                }

            } catch (Exception $e) {
                flashError('Failed to delete course: ' . $e->getMessage());
            }
            $this->redirect('admin/courses');
        }
    }
}
