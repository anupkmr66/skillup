<?php
/**
 * Franchise Model
 */
class Franchise extends Model
{
    protected $table = 'franchises';

    /**
     * Generate unique franchise code
     */
    public function generateFranchiseCode()
    {
        $prefix = 'FR';
        $year = date('Y');

        // Get last franchise code
        $sql = "SELECT franchise_code FROM franchises 
                WHERE franchise_code LIKE :pattern 
                ORDER BY id DESC LIMIT 1";

        $result = $this->db->fetchOne($sql, ['pattern' => $prefix . $year . '%']);

        if ($result) {
            $lastNumber = (int) substr($result['franchise_code'], -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $year . $newNumber;
    }

    /**
     * Get franchise with wallet
     */
    public function getFranchiseWithWallet($franchiseId)
    {
        $sql = "SELECT f.*, w.balance, w.total_earned, w.total_withdrawn
                FROM franchises f
                LEFT JOIN wallets w ON f.id = w.franchise_id
                WHERE f.id = :id";

        return $this->db->fetchOne($sql, ['id' => $franchiseId]);
    }

    /**
     * Get franchise statistics
     */
    public function getFranchiseStats($franchiseId)
    {
        $sql = "SELECT 
                COUNT(DISTINCT i.id) as total_institutes,
                COUNT(DISTINCT s.id) as total_students,
                SUM(p.amount) as total_revenue
                FROM franchises f
                LEFT JOIN institutes i ON f.id = i.franchise_id
                LEFT JOIN students s ON i.id = s.institute_id
                LEFT JOIN fees fe ON s.id = fe.student_id
                LEFT JOIN payments p ON fe.id = p.fee_id
                WHERE f.id = :id";

        return $this->db->fetchOne($sql, ['id' => $franchiseId]);
    }
}
