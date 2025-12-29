<?php
/**
 * Student Controller
 * Student Dashboard and Portal
 */
class StudentController extends Controller
{

    public function __construct()
    {
        if (!Session::isAuthenticated() || Session::userRole() != ROLE_STUDENT) {
            flashError('Access denied');
            redirect('login');
            exit;
        }
    }

    /**
     * Student Dashboard
     */
    public function dashboard()
    {
        $db = Database::getInstance();
        $userId = Session::userId();

        // Get student details
        $student = $db->fetchOne("
            SELECT s.*, i.institute_name, f.franchise_name
            FROM students s
            JOIN institutes i ON s.institute_id = i.id
            JOIN franchises f ON i.franchise_id = f.id
            WHERE s.user_id = :user_id
        ", ['user_id' => $userId]);

        if (!$student) {
            flashError('Student not found');
            redirect('login');
            return;
        }

        // Get enrolled courses
        $courses = $db->fetchAll("
            SELECT sc.*, c.course_name, c.duration, b.batch_name
            FROM student_courses sc
            JOIN courses c ON sc.course_id = c.id
            LEFT JOIN batches b ON sc.batch_id = b.id
            WHERE sc.student_id = :student_id
        ", ['student_id' => $student['id']]);

        // Get fee status
        $feeStatus = $db->fetchOne("
            SELECT SUM(total_fee) as total_fee,
                   SUM(paid_amount) as paid_amount,
                   SUM(due_amount) as due_amount
            FROM fees
            WHERE student_id = :student_id
        ", ['student_id' => $student['id']]);

        $this->view('student/dashboard', [
            'student' => $student,
            'courses' => $courses,
            'feeStatus' => $feeStatus
        ], 'layouts/student');
    }

    /**
     * Student Profile
     */
    public function profile()
    {
        $db = Database::getInstance();
        $userId = Session::userId();

        $student = $db->fetchOne("
            SELECT s.*, i.institute_name
            FROM students s
            JOIN institutes i ON s.institute_id = i.id
            WHERE s.user_id = :user_id
        ", ['user_id' => $userId]);

        $this->view('student/profile', [
            'student' => $student
        ], 'layouts/student');
    }

    /**
     * Fee Details
     */
    public function fees()
    {
        $db = Database::getInstance();
        $userId = Session::userId();

        $student = $db->fetchOne("SELECT * FROM students WHERE user_id = :user_id", ['user_id' => $userId]);

        // Get fee details
        $fees = $db->fetchAll("
            SELECT f.*, c.course_name
            FROM fees f
            JOIN courses c ON f.course_id = c.id
            WHERE f.student_id = :student_id
        ", ['student_id' => $student['id']]);

        // Get payment history
        $payments = $db->fetchAll("
            SELECT * FROM payments 
            WHERE student_id = :student_id
            ORDER BY payment_date DESC
        ", ['student_id' => $student['id']]);

        $this->view('student/fees', [
            'fees' => $fees,
            'payments' => $payments
        ], 'layouts/student');
    }

    /**
     * Exam Results
     */
    public function results()
    {
        $db = Database::getInstance();
        $userId = Session::userId();

        $student = $db->fetchOne("SELECT * FROM students WHERE user_id = :user_id", ['user_id' => $userId]);

        $results = $db->fetchAll("
            SELECT er.*, e.exam_name, e.total_marks, c.course_name
            FROM exam_results er
            JOIN exams e ON er.exam_id = e.id
            JOIN courses c ON e.course_id = c.id
            WHERE er.student_id = :student_id
            ORDER BY e.exam_date DESC
        ", ['student_id' => $student['id']]);

        $this->view('student/results', [
            'results' => $results
        ], 'layouts/student');
    }

    /**
     * Certificates
     */
    public function certificates()
    {
        $db = Database::getInstance();
        $userId = Session::userId();

        $student = $db->fetchOne("SELECT * FROM students WHERE user_id = :user_id", ['user_id' => $userId]);

        $certificates = $db->fetchAll("
            SELECT cert.*, c.course_name
            FROM certificates cert
            JOIN courses c ON cert.course_id = c.id
            WHERE cert.student_id = :student_id
            ORDER BY cert.issue_date DESC
        ", ['student_id' => $student['id']]);

        $this->view('student/certificates', [
            'certificates' => $certificates
        ], 'layouts/student');
    }

    /**
     * Study Materials
     */
    public function materials()
    {
        $db = Database::getInstance();
        $userId = Session::userId();

        $student = $db->fetchOne("SELECT * FROM students WHERE user_id = :user_id", ['user_id' => $userId]);

        // Get materials for enrolled courses
        $materials = $db->fetchAll("
            SELECT DISTINCT sm.*, c.course_name
            FROM study_materials sm
            JOIN courses c ON sm.course_id = c.id
            JOIN student_courses sc ON c.id = sc.course_id
            WHERE sc.student_id = :student_id
            ORDER BY sm.created_at DESC
        ", ['student_id' => $student['id']]);

        $this->view('student/materials', [
            'materials' => $materials
        ], 'layouts/student');
    }
    /**
     * Download Certificate
     */
    public function downloadCertificate()
    {
        $db = Database::getInstance();
        $userId = Session::userId();
        $certId = $_GET['id'] ?? null;

        if (!$certId) {
            flashError('Invalid Certificate ID');
            redirect('student/certificates');
            return;
        }

        // Get Student
        $student = $db->fetchOne("SELECT * FROM students WHERE user_id = :user_id", ['user_id' => $userId]);

        // Get Certificate and Verify Ownership
        $certificate = $db->fetchOne("
            SELECT cert.*, c.course_name
            FROM certificates cert
            JOIN courses c ON cert.course_id = c.id
            WHERE cert.id = :id AND cert.student_id = :student_id
        ", ['id' => $certId, 'student_id' => $student['id']]);

        if (!$certificate) {
            flashError('Certificate not found');
            redirect('student/certificates');
            return;
        }

        // Get Institute Details
        $institute = $db->fetchOne("SELECT * FROM institutes WHERE id = ?", [$student['institute_id']]);

        // Get Final Exam result for marks
        $examResult = $db->fetchOne("
            SELECT er.*, e.exam_name, e.total_marks, e.exam_date
            FROM exam_results er
            JOIN exams e ON er.exam_id = e.id
            WHERE er.student_id = :student_id 
              AND e.course_id = :course_id
              AND er.status = 'pass'
            ORDER BY e.exam_date DESC
            LIMIT 1
        ", ['student_id' => $student['id'], 'course_id' => $certificate['course_id']]);

        // Prepare result array
        $result = [
            'id' => $certificate['id'],
            'first_name' => $student['first_name'],
            'last_name' => $student['last_name'],
            'student_id' => $student['student_id'],
            'photo' => $student['photo'],
            'course_name' => $certificate['course_name'],
            'institute_name' => $institute['institute_name'],
            'city' => $institute['city'],
            'state' => $institute['state'],
            'logo' => $institute['logo'],
            'marks_obtained' => $examResult['marks_obtained'] ?? 0,
            'total_marks' => $examResult['total_marks'] ?? 100,
            'grade' => $examResult['grade'] ?? 'A',
            'percentage' => $examResult ? ($examResult['marks_obtained'] / $examResult['total_marks'] * 100) : 0,
            'status' => 'pass'
        ];

        require_once '../views/institute/certificate.php';
    }
}
