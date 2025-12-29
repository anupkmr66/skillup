<?php
/**
 * Home Controller
 * Handles public website pages
 */
class HomeController extends Controller
{

    /**
     * Homepage
     */
    public function index()
    {
        $this->view('public/home', [], null);
    }

    /**
     * About page
     */
    public function about()
    {
        $this->view('public/about', [], null);
    }

    /**
     * Courses page
     */
    public function courses()
    {
        $courseModel = new Course();
        $courses = $courseModel->where('status', STATUS_ACTIVE, 'course_name ASC');

        $this->view('public/courses', [
            'courses' => $courses
        ], null);
    }

    /**
     * Course Details Page
     */
    public function courseDetails()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('courses');
            return;
        }

        $db = Database::getInstance();
        $course = $db->fetchOne("SELECT * FROM courses WHERE id = ? AND status = 'active'", [$id]);

        if (!$course) {
            $this->redirect('courses');
            return;
        }

        // Fetch related or OTHER courses for sidebar/suggestions
        $otherCourses = $db->fetchAll("SELECT * FROM courses WHERE status = 'active' AND id != ? LIMIT 5", [$id]);

        $this->view('public/course_details', [
            'course' => $course,
            'otherCourses' => $otherCourses
        ], null);
    }

    /**
     * Contact page
     */
    public function contact()
    {
        $this->view('public/contact', [], null);
    }

    /**
     * Submit contact form
     */
    public function submitContact()
    {
        if ($this->isPost()) {
            CSRF::verify();

            $data = [
                'name' => $this->post('name'),
                'email' => $this->post('email'),
                'phone' => $this->post('phone'),
                'subject' => $this->post('subject'),
                'message' => $this->post('message'),
                'status' => 'new'
            ];

            $validation = $this->validate($data, [
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required'
            ]);

            if ($validation !== true) {
                flashError('Please fill all required fields correctly');
                $this->redirect('contact');
                return;
            }

            try {
                $db = Database::getInstance();
                $db->insert('contact_messages', $data);

                flashSuccess('Thank you for contacting us. We will get back to you soon!');
            } catch (Exception $e) {
                flashError('Failed to submit message. Please try again.');
            }

            $this->redirect('contact');
        }
    }

    /**
     * Certificate verification page
     */
    public function verifyCertificate()
    {
        $this->view('public/verify', [], null);
    }

    /**
     * Check certificate
     */
    public function checkCertificate()
    {
        if ($this->isPost()) {
            $certificateNumber = $this->post('certificate_number');
            error_log("Verifying Certificate: " . $certificateNumber);

            if (empty($certificateNumber)) {
                $this->json(['success' => false, 'message' => 'Please enter certificate number']);
                return;
            }

            // Check for Franchise Certificate (FC-YYYY-XXXX)
            if (strpos($certificateNumber, 'FC-') === 0) {
                $db = Database::getInstance();
                $franchiseCert = $db->fetchOne("
                    SELECT fc.*, f.franchise_name, f.owner_name, f.franchise_code, f.city, f.state
                    FROM franchise_certificates fc
                    JOIN franchises f ON fc.franchise_id = f.id
                    WHERE fc.certificate_number = ?", [$certificateNumber]);

                if ($franchiseCert) {
                    $html = $this->view('public/partials/verify_franchise_result', ['cert' => $franchiseCert], null, true);
                    $this->json(['success' => true, 'html' => $html]);
                    return;
                } else {
                    $this->json(['success' => false, 'message' => 'Franchise Certificate not found or invalid.']);
                    return;
                }
            }

            // Student Certificate Logic (Existing)
            // Parse CERT-ID (e.g., CERT-000123)
            if (preg_match('/^CERT-(\d+)$/i', $certificateNumber, $matches)) {
                $resultId = $matches[1];
            } else {
                $resultId = $certificateNumber; // Fallback if just ID is entered
            }

            try {
                $db = Database::getInstance();
                $sql = "SELECT er.*, s.first_name, s.last_name, c.course_name, i.institute_name, er.result_date, e.total_marks
                        FROM exam_results er
                        JOIN students s ON er.student_id = s.id
                        JOIN exams e ON er.exam_id = e.id
                        JOIN courses c ON e.course_id = c.id
                        JOIN institutes i ON s.institute_id = i.id
                        WHERE er.id = :id AND er.status = 'pass'";

                $details = $db->fetchOne($sql, ['id' => $resultId]);
                error_log("Certificate Query Result for ID $resultId: " . ($details ? 'Found' : 'Not Found'));

                if ($details) {
                    // Calculate percentage/grade if not stored
                    $percentage = ($details['total_marks'] > 0) ? ($details['marks_obtained'] / $details['total_marks']) * 100 : 0;
                    $grade = $details['grade'] ?? ($percentage >= 80 ? 'A+' : ($percentage >= 60 ? 'A' : 'B'));

                    $this->json([
                        'success' => true,
                        'message' => 'Certificate is valid',
                        'data' => [
                            'student_name' => $details['first_name'] . ' ' . $details['last_name'],
                            'course_name' => $details['course_name'],
                            'institute_name' => $details['institute_name'],
                            'issue_date' => formatDate($details['result_date']),
                            'certificate_number' => 'CERT-' . str_pad($details['id'], 6, '0', STR_PAD_LEFT),
                            'grade' => $grade
                        ]
                    ]);
                } else {
                    $this->json(['success' => false, 'message' => 'Invalid Certificate Number or Student did not pass']);
                }
            } catch (Exception $e) {
                $this->json(['success' => false, 'message' => 'Error verifying certificate']);
            }
        }
    }

    /**
     * Franchise inquiry page
     */
    public function franchiseInquiry()
    {
        $this->view('public/franchise-inquiry', [], null);
    }

    /**
     * Submit franchise inquiry
     */
    public function submitFranchiseInquiry()
    {
        if ($this->isPost()) {
            CSRF::verify();

            $data = [
                'name' => $this->post('name'),
                'email' => $this->post('email'),
                'phone' => $this->post('phone'),
                'city' => $this->post('city'),
                'state' => $this->post('state'),
                'message' => $this->post('message'),
                'status' => 'new'
            ];

            $validation = $this->validate($data, [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'city' => 'required'
            ]);

            if ($validation !== true) {
                flashError('Please fill all required fields correctly');
                $this->redirect('franchise-inquiry');
                return;
            }

            try {
                $db = Database::getInstance();
                $db->insert('franchise_inquiries', $data);

                flashSuccess('Thank you for your interest! Our team will contact you soon.');
            } catch (Exception $e) {
                flashError('Failed to submit inquiry. Please try again.');
            }

            $this->redirect('franchise-inquiry');
        }
    }
    public function terms()
    {
        return $this->view('public/terms');
    }

    public function privacy()
    {
        return $this->view('public/privacy');
    }

    public function policy()
    {
        return $this->view('public/policy');
    }
}
