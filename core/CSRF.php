<?php
/**
 * CSRF Protection Class
 * Token generation and validation
 */
class CSRF
{

    /**
     * Generate CSRF token
     */
    public static function generateToken()
    {
        if (!Session::has('csrf_token')) {
            $token = bin2hex(random_bytes(32));
            Session::set('csrf_token', $token);
        }
        return Session::get('csrf_token');
    }

    /**
     * Get CSRF token
     */
    public static function getToken()
    {
        return self::generateToken();
    }

    /**
     * Generate CSRF field for forms
     */
    public static function field()
    {
        $token = self::getToken();
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }

    /**
     * Validate CSRF token
     */
    public static function validate($token = null)
    {
        if ($token === null) {
            $token = $_POST['csrf_token'] ?? $_GET['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        }

        $sessionToken = Session::get('csrf_token');

        if (empty($sessionToken) || empty($token)) {
            return false;
        }

        return hash_equals($sessionToken, $token);
    }

    /**
     * Verify CSRF token or die
     */
    public static function verify()
    {
        if (!self::validate()) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'CSRF token validation failed']);
            exit;
        }
    }
}
