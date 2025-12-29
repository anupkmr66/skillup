<?php
/**
 * Authentication Middleware
 * Protect routes that require authentication
 */
class AuthMiddleware
{

    public function handle()
    {
        if (!Session::isAuthenticated()) {
            // Set intended URL for redirect after login
            Session::set('intended_url', $_SERVER['REQUEST_URI']);

            // Redirect to login
            header('Location: ' . url('login'));
            exit;
        }

        return true;
    }
}
