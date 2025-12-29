<?php
/**
 * Course Model
 */
class Course extends Model
{
    protected $table = 'courses';

    /**
     * Get active courses
     */
    public function getActiveCourses()
    {
        return $this->where('status', STATUS_ACTIVE, 'course_name ASC');
    }

    /**
     * Get course with enrollment count
     */
    public function getCourseWithStats($courseId)
    {
        $sql = "SELECT c.*, 
                COUNT(DISTINCT sc.student_id) as total_students,
                COUNT(DISTINCT b.id) as total_batches
                FROM courses c
                LEFT JOIN student_courses sc ON c.id = sc.course_id
                LEFT JOIN batches b ON c.id = b.course_id
                WHERE c.id = :id
                GROUP BY c.id";

        return $this->db->fetchOne($sql, ['id' => $courseId]);
    }
}
