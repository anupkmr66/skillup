<?php
/**
 * Role Middleware
 * Check if user has required role
 */
class RoleMiddleware
{
    private $allowedRoles;

    public function __construct($roles = [])
    {
        $this->allowedRoles = is_array($roles) ? $roles : [$roles];
    }

    public function handle()
    {
        if (!Session::isAuthenticated()) {
            header('Location: ' . url('login'));
            exit;
        }

        $userRole = Session::userRole();

        if (!empty($this->allowedRoles) && !in_array($userRole, $this->allowedRoles)) {
            http_response_code(403);
            die('Access Denied: Insufficient permissions');
        }

        return true;
    }
}
