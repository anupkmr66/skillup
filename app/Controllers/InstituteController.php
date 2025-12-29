<?php
/**
 * Institute Controller
 * Institute Admin Dashboard
 */
class InstituteController extends Controller
{

    public function __construct()
    {
        if (!Session::isAuthenticated() || Session::userRole() != ROLE_INSTITUTE_ADMIN) {
            flashError('Access denied');
            redirect('login');
            exit;
        }
    }

    /**
     * Institute Dashboard
     */
    public function dashboard()
    {
        $db = Database::getInstance();
        $userId = Session::userId();

        // Get institute details
        $institute = $db->fetchOne("
            SELECT i.*, f.franchise_name
            FROM institutes i
            LEFT JOIN franchises f ON i.franchise_id = f.id
            WHERE i.user_id = :user_id
        ", ['user_id' => $userId]);

        if (!$institute) {
            flashError('Institute not found');
            redirect('login');
            return;
        }

        // Get statistics
        $stats = [
            'total_students' => $db->fetchOne("SELECT COUNT(*) as count FROM students WHERE institute_id = :id AND status = 'active'", ['id' => $institute['id']])['count'],
            'total_fees_collected' => $db->fetchOne("
                SELECT COALESCE(SUM(p.amount), 0) as total
                FROM payments p
                JOIN students s ON p.student_id = s.id
                WHERE s.institute_id = :id
            ", ['id' => $institute['id']])['total'],
            'pending_fees' => $db->fetchOne("
                SELECT COALESCE(SUM(f.due_amount), 0) as total
                FROM fees f
                JOIN students s ON f.student_id = s.id
                WHERE s.institute_id = :id AND f.status != 'paid'
            ", ['id' => $institute['id']])['total'],
            'total_batches' => $db->fetchOne("SELECT COUNT(*) as count FROM batches WHERE institute_id = :id AND status = 'active'", ['id' => $institute['id']])['count']
        ];

        // Get Recent Activity
        $activities = $db->fetchAll("
            SELECT * FROM activity_logs 
            WHERE user_id = :user_id 
            ORDER BY created_at DESC 
            LIMIT 5
        ", ['user_id' => $userId]);

        $this->view('institute/dashboard', [
            'institute' => $institute,
            'stats' => $stats,
            'activities' => $activities
        ], 'layouts/institute');
    }

    /**
     * Teachers Management
     */
    public function teachers()
    {
        $userId = Session::userId();
        $db = Database::getInstance();
        $institute = $db->fetchOne("SELECT * FROM institutes WHERE user_id = :user_id", ['user_id' => $userId]);

        $teachers = $db->fetchAll("
            SELECT t.*, u.email, u.username,
                (SELECT COUNT(*) FROM batches b WHERE b.teacher_id = u.id AND b.status = 'active') as active_batches
            FROM teachers t
            JOIN users u ON t.user_id = u.id
            WHERE t.institute_id = :id
            ORDER BY t.first_name ASC
        ", ['id' => $institute['id']]);

        $this->view('institute/teachers', [
            'teachers' => $teachers,
            'institute' => $institute
        ], 'layouts/institute');
    }

    public function students()
    {
        $userId = Session::userId();
        $db = Database::getInstance();

        $institute = $db->fetchOne("SELECT * FROM institutes WHERE user_id = :user_id", ['user_id' => $userId]);

        $students = $db->fetchAll("
            SELECT * FROM students 
            WHERE institute_id = :id 
            ORDER BY created_at DESC
        ", ['id' => $institute['id']]);

        // Get active courses for dropdown
        $courses = $db->fetchAll("
            SELECT * FROM courses 
            WHERE status = 'active'
        ");

        // Get active batches for dropdown
        $batches = $db->fetchAll("
            SELECT * FROM batches 
            WHERE institute_id = :id AND status = 'active'
        ", ['id' => $institute['id']]);

        $this->view('institute/students', [
            'students' => $students,
            'institute' => $institute,
            'courses' => $courses,
            'batches' => $batches
        ], 'layouts/institute');
    }

    /**
     * Fees Management
     */
    public function fees()
    {
        $userId = Session::userId();
        $db = Database::getInstance();

        $institute = $db->fetchOne("SELECT * FROM institutes WHERE user_id = :user_id", ['user_id' => $userId]);

        $fees = $db->fetchAll("
            SELECT f.*, s.first_name, s.last_name, s.student_id, c.course_name
            FROM fees f
            JOIN students s ON f.student_id = s.id
            JOIN courses c ON f.course_id = c.id
            WHERE s.institute_id = :id 
            ORDER BY f.created_at DESC
        ", ['id' => $institute['id']]);

        $this->view('institute/fees', [
            'fees' => $fees
        ], 'layouts/institute');
    }

    /**
     * Batch Management
     */
    public function batches()
    {
        $userId = Session::userId();
        $db = Database::getInstance();

        $institute = $db->fetchOne("SELECT * FROM institutes WHERE user_id = :user_id", ['user_id' => $userId]);

        $batches = $db->fetchAll("
            SELECT b.*, c.course_name, 
                (SELECT COUNT(*) FROM student_courses sc WHERE sc.batch_id = b.id AND sc.status = 'ongoing') as student_count
            FROM batches b
            JOIN courses c ON b.course_id = c.id
            WHERE b.institute_id = :id 
            ORDER BY b.created_at DESC
        ", ['id' => $institute['id']]);

        $courses = $db->fetchAll("SELECT * FROM courses WHERE status = 'active'");

        $teachers = $db->fetchAll("SELECT * FROM teachers WHERE institute_id = :id AND status = 'active'", ['id' => $institute['id']]);

        $this->view('institute/batches', [
            'batches' => $batches,
            'courses' => $courses,
            'teachers' => $teachers,
            'institute' => $institute
        ], 'layouts/institute');
    }

    /**
     * Exams Management
     */
    public function exams()
    {
        $userId = Session::userId();
        $db = Database::getInstance();

        $institute = $db->fetchOne("SELECT * FROM institutes WHERE user_id = :user_id", ['user_id' => $userId]);

        $exams = $db->fetchAll("
            SELECT e.*, c.course_name, b.batch_name
            FROM exams e
            JOIN courses c ON e.course_id = c.id
            LEFT JOIN batches b ON e.batch_id = b.id
            WHERE b.institute_id = :id 
            ORDER BY e.exam_date DESC
        ", ['id' => $institute['id']]);

        // Get active courses for dropdown
        $courses = $db->fetchAll("SELECT * FROM courses WHERE status = 'active'");

        // Get active batches for dropdown
        $batches = $db->fetchAll("SELECT * FROM batches WHERE institute_id = :id AND status = 'active'", ['id' => $institute['id']]);

        $this->view('institute/exams', [
            'exams' => $exams,
            'courses' => $courses,
            'batches' => $batches
        ], 'layouts/institute');
    }

    public function examResults()
    {
        $userId = Session::userId();
        $db = Database::getInstance();
        $institute = $db->fetchOne("SELECT * FROM institutes WHERE user_id = :user_id", ['user_id' => $userId]);

        $examId = $_GET['id'] ?? null;
        if (!$examId) {
            flashError('Exam ID missing');
            redirect('institute/exams');
            return;
        }

        $exam = $db->fetchOne("
            SELECT e.*, c.course_name, b.batch_name 
            FROM exams e
            JOIN courses c ON e.course_id = c.id
            LEFT JOIN batches b ON e.batch_id = b.id
            WHERE e.id = :id
        ", ['id' => $examId]);

        if (!$exam) {
            flashError('Exam not found');
            redirect('institute/exams');
            return;
        }

        $this->view('institute/exam_results', [
            'institute' => $institute,
            'exam' => $exam
        ], 'layouts/institute');
    }

    public function downloadCertificate()
    {
        $userId = Session::userId();
        $db = Database::getInstance();

        $studentId = $_GET['student_id'] ?? null;
        $examId = $_GET['exam_id'] ?? null;

        if (!$studentId || !$examId) {
            die("Invalid Request");
        }

        $institute = $db->fetchOne("SELECT * FROM institutes WHERE user_id = ?", [$userId]);

        $result = $db->fetchOne("
            SELECT er.*, e.exam_name, e.exam_date, e.total_marks,
                   s.first_name, s.last_name, s.student_id,
                   c.course_name, i.institute_name, i.city, i.state, i.logo
            FROM exam_results er
            JOIN exams e ON er.exam_id = e.id
            JOIN students s ON er.student_id = s.id
            JOIN courses c ON e.course_id = c.id
            JOIN institutes i ON s.institute_id = i.id
            WHERE er.student_id = ? AND er.exam_id = ? AND i.id = ?
        ", [$studentId, $examId, $institute['id']]);

        if (!$result || $result['status'] === 'fail' || $result['status'] === 'absent') {
            die("Certificate not available or student failed.");
        }

        // Render certificate view without layout
        extract(['result' => $result]);
        require_once '../views/institute/certificate.php';
    }
    /**
     * Attendance Management
     */
    public function attendance()
    {
        $userId = Session::userId();
        $db = Database::getInstance();
        $institute = $db->fetchOne("SELECT * FROM institutes WHERE user_id = :user_id", ['user_id' => $userId]);

        $batches = $db->fetchAll("
            SELECT * FROM batches 
            WHERE institute_id = :id AND status = 'active'
        ", ['id' => $institute['id']]);

        $this->view('institute/attendance', [
            'institute' => $institute,
            'batches' => $batches
        ], 'layouts/institute');
    }

    public function attendanceReport()
    {
        $userId = Session::userId();
        $db = Database::getInstance();
        $institute = $db->fetchOne("SELECT * FROM institutes WHERE user_id = :user_id", ['user_id' => $userId]);

        $batches = $db->fetchAll("
            SELECT * FROM batches 
            WHERE institute_id = :id AND status = 'active'
        ", ['id' => $institute['id']]);

        $this->view('institute/attendance_report', [
            'institute' => $institute,
            'batches' => $batches
        ], 'layouts/institute');
    }

    /**
     * Profile Management
     */
    public function profile()
    {
        $userId = Session::userId();
        $db = Database::getInstance();

        $institute = $db->fetchOne("
            SELECT i.*, f.franchise_name, u.email as user_email
            FROM institutes i
            LEFT JOIN franchises f ON i.franchise_id = f.id
            JOIN users u ON i.user_id = u.id
            WHERE i.user_id = :user_id
        ", ['user_id' => $userId]);

        $this->view('institute/profile', [
            'institute' => $institute
        ], 'layouts/institute');
    }
    public function printReceipt()
    {
        $paymentId = $_GET['payment_id'] ?? null;
        if (!$paymentId)
            die('Payment ID required');

        $db = Database::getInstance();
        $payment = $db->fetchOne("
            SELECT p.*, f.total_fee, f.discount_amount, f.due_amount, 
                   s.first_name, s.last_name, s.student_id, 
                   c.course_name, i.institute_name, i.address as institute_address, i.phone as institute_phone, i.email as institute_email, i.logo
            FROM payments p
            JOIN fees f ON p.fee_id = f.id
            JOIN students s ON f.student_id = s.id
            JOIN courses c ON f.course_id = c.id
            JOIN institutes i ON s.institute_id = i.id
            WHERE p.id = ?
        ", [$paymentId]);

        if (!$payment)
            die('Payment not found');

        $this->view('institute/receipt', ['payment' => $payment], null);
    }

    public function printStatement()
    {
        $feeId = $_GET['fee_id'] ?? null;
        if (!$feeId)
            die('Fee ID required');

        $db = Database::getInstance();
        $fee = $db->fetchOne("
            SELECT f.*, s.first_name, s.last_name, s.student_id, s.photo,
                   c.course_name, i.institute_name, i.address as institute_address, i.phone as institute_phone, i.email as institute_email, i.logo
            FROM fees f
            JOIN students s ON f.student_id = s.id
            JOIN courses c ON f.course_id = c.id
            JOIN institutes i ON s.institute_id = i.id
            WHERE f.id = ?
        ", [$feeId]);

        if (!$fee)
            die('Fee record not found');

        $payments = $db->fetchAll("SELECT * FROM payments WHERE fee_id = ? ORDER BY payment_date ASC", [$feeId]);

        $this->view('institute/statement', ['fee' => $fee, 'payments' => $payments], null);
    }
}
