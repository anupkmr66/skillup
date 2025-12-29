<?php
/**
 * User Model
 * Handles user authentication and management
 */
class User extends Model
{
    protected $table = 'users';

    /**
     * Authenticate user
     */
    public function authenticate($username, $password)
    {
        // Check if input is email
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $user = $this->findBy('email', $username);
        } else {
            $user = $this->findBy('username', $username);
        }

        if ($user && password_verify($password, $user['password_hash'])) {
            if ($user['status'] !== STATUS_ACTIVE) {
                return ['success' => false, 'message' => 'Account is inactive'];
            }

            // Get role name
            $role = $this->getRoleById($user['role_id']);

            return [
                'success' => true,
                'user' => $user,
                'role' => $role
            ];
        }

        return ['success' => false, 'message' => 'Invalid credentials'];
    }

    /**
     * Create new user
     */
    public function createUser($data)
    {
        $data['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT);
        unset($data['password']);

        return $this->create($data);
    }

    /**
     * Update password
     */
    public function updatePassword($userId, $newPassword)
    {
        return $this->update($userId, [
            'password_hash' => password_hash($newPassword, PASSWORD_BCRYPT)
        ]);
    }

    /**
     * Get role by ID
     */
    private function getRoleById($roleId)
    {
        $sql = "SELECT role_name FROM roles WHERE id = :id";
        $result = $this->db->fetchOne($sql, ['id' => $roleId]);
        return $result['role_name'] ?? null;
    }

    /**
     * Get user with role
     */
    public function getUserWithRole($userId)
    {
        $sql = "SELECT u.*, r.role_name 
                FROM users u 
                LEFT JOIN roles r ON u.role_id = r.id 
                WHERE u.id = :id";
        return $this->db->fetchOne($sql, ['id' => $userId]);
    }

    /**
     * Get users by role
     */
    public function getUsersByRole($roleId)
    {
        return $this->where('role_id', $roleId, 'created_at DESC');
    }
}
