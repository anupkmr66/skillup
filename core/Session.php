<?php
/**
 * Session Handler Class
 * Secure session management with timeout
 */
class Session
{

    /**
     * Start session
     */
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            // Secure session configuration
            ini_set('session.cookie_httponly', 1);
            ini_set('session.use_only_cookies', 1);
            ini_set('session.cookie_secure', 0); // Set to 1 for HTTPS

            session_start();

            // Check session timeout (30 minutes)
            if (self::has('last_activity')) {
                $inactive = time() - self::get('last_activity');
                if ($inactive > 1800) { // 30 minutes
                    self::destroy();
                    return false;
                }
            }

            self::set('last_activity', time());

            // Regenerate session ID periodically
            if (!self::has('created')) {
                self::regenerate();
                self::set('created', time());
            } elseif (time() - self::get('created') > 1800) {
                self::regenerate();
                self::set('created', time());
            }
        }

        return true;
    }

    /**
     * Set session variable
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get session variable
     */
    public static function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Check if session variable exists
     */
    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Remove session variable
     */
    public static function remove($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Flash message (available for one request)
     */
    public static function flash($key, $value = null)
    {
        if ($value === null) {
            $flash = self::get('flash_' . $key);
            self::remove('flash_' . $key);
            return $flash;
        }
        self::set('flash_' . $key, $value);
    }

    /**
     * Regenerate session ID
     */
    public static function regenerate()
    {
        session_regenerate_id(true);
    }

    /**
     * Destroy session
     */
    public static function destroy()
    {
        session_unset();
        session_destroy();
    }

    /**
     * Check if user is authenticated
     */
    public static function isAuthenticated()
    {
        return self::has('user_id') && self::has('user_role');
    }

    /**
     * Get authenticated user ID
     */
    public static function userId()
    {
        return self::get('user_id');
    }

    /**
     * Get authenticated user role
     */
    public static function userRole()
    {
        return self::get('user_role');
    }

    /**
     * Set user session
     */
    public static function setUser($userId, $role, $userData = [])
    {
        self::set('user_id', $userId);
        self::set('user_role', $role);
        self::set('user_data', $userData);
        self::regenerate();
    }

    /**
     * Get user data
     */
    public static function userData($key = null)
    {
        $data = self::get('user_data', []);
        return $key ? ($data[$key] ?? null) : $data;
    }
}
