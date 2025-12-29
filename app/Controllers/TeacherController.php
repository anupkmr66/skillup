<?php
/**
 * Teacher Controller
 * Teacher/Staff Dashboard
 */
class TeacherController extends Controller
{

    public function __construct()
    {
        if (!Session::isAuthenticated() || Session::userRole() != ROLE_TEACHER) {
            flashError('Access denied');
            redirect('login');
            exit;
        }
    }

    /**
     * Teacher Dashboard
     */
    public function dashboard()
    {
        $db = Database::getInstance();
        $userId = Session::userId();

        // Get teacher's batches
        $batches = $db->fetchAll("
            SELECT b.*, c.course_name, i.institute_name,
            COUNT(DISTINCT sc.student_id) as student_count
            FROM batches b
            JOIN courses c ON b.course_id = c.id
            JOIN institutes i ON b.institute_id = i.id
            LEFT JOIN student_courses sc ON b.id = sc.batch_id
            WHERE b.teacher_id = :teacher_id AND b.status = 'active'
            GROUP BY b.id
            ORDER BY b.start_date DESC
        ", ['teacher_id' => $userId]);

        $this->view('teacher/dashboard', [
            'batches' => $batches
        ], 'layouts/teacher');
    }

    /**
     * Manage Batches
     */
    public function batches()
    {
        $db = Database::getInstance();
        $userId = Session::userId();

        $batches = $db->fetchAll("
            SELECT b.*, c.course_name, i.institute_name
            FROM batches b
            JOIN courses c ON b.course_id = c.id
            JOIN institutes i ON b.institute_id = i.id
            WHERE b.teacher_id = :teacher_id
            ORDER BY b.start_date DESC
        ", ['teacher_id' => $userId]);

        $this->view('teacher/batches', [
            'batches' => $batches
        ], 'layouts/teacher');
    }

    /**
     * Study Materials
     */
    public function materials()
    {
        $db = Database::getInstance();
        $userId = Session::userId();

        // Get materials for teacher's batches
        $materials = $db->fetchAll("
            SELECT sm.*, c.course_name, b.batch_name
            FROM study_materials sm
            JOIN courses c ON sm.course_id = c.id
            LEFT JOIN batches b ON sm.batch_id = b.id
            WHERE sm.uploaded_by = :teacher_id
            ORDER BY sm.created_at DESC
        ", ['teacher_id' => $userId]);

        // Get teacher's batches for upload dropdown
        $batches = $db->fetchAll("
            SELECT b.*, c.course_name 
            FROM batches b
            JOIN courses c ON b.course_id = c.id
            WHERE b.teacher_id = :teacher_id AND b.status = 'active'
        ", ['teacher_id' => $userId]);

        $this->view('teacher/materials', [
            'materials' => $materials,
            'batches' => $batches
        ], 'layouts/teacher');
    }
}
