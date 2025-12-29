<?php
/**
 * Franchise Controller
 * Franchise Admin Dashboard
 */
class FranchiseController extends Controller
{

    public function __construct()
    {
        if (!Session::isAuthenticated() || Session::userRole() != ROLE_FRANCHISE_ADMIN) {
            flashError('Access denied');
            redirect('login');
            exit;
        }
    }

    /**
     * Franchise Dashboard
     */
    public function dashboard()
    {
        $db = Database::getInstance();
        $userId = Session::userId();

        // Get franchise details
        $franchise = $db->fetchOne("
            SELECT f.*, w.balance, w.total_earned
            FROM franchises f
            LEFT JOIN wallets w ON f.id = w.franchise_id
            WHERE f.user_id = :user_id
        ", ['user_id' => $userId]);

        if (!$franchise) {
            flashError('Franchise not found');
            redirect('login');
            return;
        }

        // Get statistics
        $stats = [
            'total_institutes' => $db->fetchOne("SELECT COUNT(*) as count FROM institutes WHERE franchise_id = :id", ['id' => $franchise['id']])['count'],
            'total_students' => $db->fetchOne("
                SELECT COUNT(DISTINCT s.id) as count 
                FROM students s
                JOIN institutes i ON s.institute_id = i.id
                WHERE i.franchise_id = :id
            ", ['id' => $franchise['id']])['count'],
            'wallet_balance' => $franchise['balance'] ?? 0,
            'total_earned' => $franchise['total_earned'] ?? 0
        ];

        $this->view('franchise/dashboard', [
            'franchise' => $franchise,
            'stats' => $stats
        ], 'layouts/franchise');
    }

    /**
     * Manage Institutes
     */
    public function institutes()
    {
        $userId = Session::userId();
        $db = Database::getInstance();

        $franchise = $db->fetchOne("SELECT * FROM franchises WHERE user_id = :user_id", ['user_id' => $userId]);

        $institutes = $db->fetchAll("
            SELECT * FROM institutes 
            WHERE franchise_id = :id 
            ORDER BY created_at DESC
        ", ['id' => $franchise['id']]);

        $this->view('franchise/institutes', [
            'institutes' => $institutes
        ], 'layouts/franchise');
    }

    /**
     * Wallet
     */
    public function wallet()
    {
        $userId = Session::userId();
        $db = Database::getInstance();

        $franchise = $db->fetchOne("SELECT * FROM franchises WHERE user_id = :user_id", ['user_id' => $userId]);

        $wallet = $db->fetchOne("SELECT * FROM wallets WHERE franchise_id = :id", ['id' => $franchise['id']]);

        $transactions = $db->fetchAll("
            SELECT * FROM wallet_transactions 
            WHERE wallet_id = :wallet_id 
            ORDER BY created_at DESC 
            LIMIT 50
        ", ['wallet_id' => $wallet['id']]);

        $this->view('franchise/wallet', [
            'wallet' => $wallet,
            'transactions' => $transactions
        ], 'layouts/franchise');
    }

    /**
     * Withdrawals
     */
    public function withdrawals()
    {
        $userId = Session::userId();
        $db = Database::getInstance();

        $franchise = $db->fetchOne("SELECT * FROM franchises WHERE user_id = :user_id", ['user_id' => $userId]);

        $withdrawals = $db->fetchAll("
            SELECT * FROM withdrawal_requests 
            WHERE franchise_id = :id 
            ORDER BY request_date DESC
        ", ['id' => $franchise['id']]);

        $this->view('franchise/withdrawals', [
            'withdrawals' => $withdrawals
        ], 'layouts/franchise');
    }
}
