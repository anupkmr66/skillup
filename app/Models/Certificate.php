<?php
/**
 * Certificate Model
 */
class Certificate extends Model
{
    protected $table = 'certificates';

    /**
     * Generate unique certificate number
     */
    public function generateCertificateNumber()
    {
        $prefix = 'CERT';
        $year = date('Y');

        // Get last certificate number
        $sql = "SELECT certificate_number FROM certificates 
                WHERE certificate_number LIKE :pattern 
                ORDER BY id DESC LIMIT 1";

        $result = $this->db->fetchOne($sql, ['pattern' => $prefix . $year . '%']);

        if ($result) {
            $lastNumber = (int) substr($result['certificate_number'], -5);
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '00001';
        }

        return $prefix . $year . $newNumber;
    }

    /**
     * Get certificate with student and course details
     */
    public function getCertificateDetails($certificateId)
    {
        $sql = "SELECT c.*, 
                s.first_name, s.last_name, s.student_id,
                co.course_name, co.duration
                FROM certificates c
                JOIN students s ON c.student_id = s.id
                JOIN courses co ON c.course_id = co.id
                WHERE c.id = :id";

        return $this->db->fetchOne($sql, ['id' => $certificateId]);
    }
}
