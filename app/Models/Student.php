<?php
/**
 * Student Model
 */
class Student extends Model
{
    protected $table = 'students';

    /**
     * Generate unique student ID
     */
    public function generateStudentId()
    {
        $prefix = 'STU';
        $year = date('Y');

        // Get last student ID
        $sql = "SELECT student_id FROM students 
                WHERE student_id LIKE :pattern 
                ORDER BY id DESC LIMIT 1";

        $result = $this->db->fetchOne($sql, ['pattern' => $prefix . $year . '%']);

        if ($result) {
            $lastNumber = (int) substr($result['student_id'], -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $year . $newNumber;
    }

    /**
     * Get student with institute details
     */
    public function getStudentWithDetails($studentId)
    {
        $sql = "SELECT s.*, 
                i.institute_name,
                f.franchise_name,
                u.username, u.email as user_email
                FROM students s
                LEFT JOIN institutes i ON s.institute_id = i.id
                LEFT JOIN franchises f ON i.franchise_id = f.id
                LEFT JOIN users u ON s.user_id = u.id
                WHERE s.id = :id";

        return $this->db->fetchOne($sql, ['id' => $studentId]);
    }

    /**
     * Get students by institute
     */
    public function getStudentsByInstitute($instituteId)
    {
        return $this->where('institute_id', $instituteId, 'created_at DESC');
    }

    /**
     * Get student courses
     */
    public function getStudentCourses($studentId)
    {
        $sql = "SELECT sc.*, c.course_name, c.duration, c.fee, b.batch_name
                FROM student_courses sc
                JOIN courses c ON sc.course_id = c.id
                LEFT JOIN batches b ON sc.batch_id = b.id
                WHERE sc.student_id = :student_id
                ORDER BY sc.created_at DESC";

        return $this->db->fetchAll($sql, ['student_id' => $studentId]);
    }
}
