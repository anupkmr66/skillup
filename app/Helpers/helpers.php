<?php
/**
 * Helper Functions
 */

/**
 * Generate URL
 */
function url($path = '')
{
    // Force the correct base URL for this environment
    $appUrl = 'http://localhost/skillup/public';

    $appUrl = rtrim($appUrl, '/');
    $path = ltrim($path, '/');

    // If path already contains 'public/' and appUrl also has it, don't duplicate
    if (str_contains($path, 'public/') && str_ends_with($appUrl, 'public')) {
        $path = str_replace('public/', '', $path);
    }

    return $appUrl . '/' . $path;
}

/**
 * Asset URL
 */
function asset($path)
{
    return url('public/assets/' . ltrim($path, '/'));
}

/**
 * Redirect helper
 */
function redirect($url)
{
    header('Location: ' . url($url));
    exit;
}

/**
 * Old input (for form repopulation)
 */
function old($key, $default = '')
{
    return Session::get('old_' . $key, $default);
}

/**
 * Flash success message
 */
function flashSuccess($message)
{
    Session::flash('success', $message);
}

/**
 * Flash error message
 */
function flashError($message)
{
    Session::flash('error', $message);
}

/**
 * Get flash message
 */
function getFlash($type)
{
    return Session::flash($type);
}

/**
 * Escape output
 */
function e($string)
{
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Debug helper
 */
function dd(...$vars)
{
    foreach ($vars as $var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
    die;
}

/**
 * Format date for display
 */
function formatDate($date, $format = 'd-m-Y')
{
    if (empty($date)) {
        return 'N/A';
    }
    return date($format, strtotime($date));
}

/**
 * Format currency
 */
function formatCurrency($amount)
{
    return '₹' . number_format($amount, 2);
}

/**
 * Generate unique ID
 */
function generateId($prefix, $length = 8)
{
    $year = date('Y');
    $number = str_pad(mt_rand(1, 99999999), $length, '0', STR_PAD_LEFT);
    return $prefix . $year . $number;
}

/**
 * Check user role
 */
function hasRole($role)
{
    return Session::userRole() === $role;
}

/**
 * Check if user is authenticated
 */
function isAuth()
{
    return Session::isAuthenticated();
}

/**
 * Get authenticated user
 */
function auth()
{
    return [
        'id' => Session::userId(),
        'role' => Session::userRole(),
        'data' => Session::userData()
    ];
}

/**
 * Sanitize input
 */
function sanitize($input)
{
    if (is_array($input)) {
        return array_map('sanitize', $input);
    }
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

/**
 * Upload path
 */
function uploadPath($path = '')
{
    return PUBLIC_PATH . '/uploads/' . ltrim($path, '/');
}

/**
 * Upload URL
 */
function uploadUrl($path = '')
{
    return url('public/uploads/' . ltrim($path, '/'));
}

/**
 * Send Email (and log for development)
 */
function sendEmail($to, $subject, $message)
{
    // 1. Try sending via PHP mail()
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: SkillUp CIMS <no-reply@skillup.com>' . "\r\n";

    $mailSent = @mail($to, $subject, $message, $headers);

    // 2. Log to file for local development (storage/logs/emails.log)
    // We navigate up from app/Helpers to storage/logs
    $logDir = dirname(__DIR__, 2) . '/storage/logs';

    if (!file_exists($logDir)) {
        mkdir($logDir, 0777, true);
    }

    $logParams = [
        'Time' => date('Y-m-d H:i:s'),
        'To' => $to,
        'Subject' => $subject,
        'Status' => $mailSent ? 'Sent' : 'Failed'
    ];

    $logContent = "--------------------------------------------------\n";
    foreach ($logParams as $key => $val) {
        $logContent .= "[$key]: $val\n";
    }
    // Add message body separately to avoid array mess
    $logContent .= "Message Body:\n" . strip_tags($message) . "\n";
    $logContent .= "--------------------------------------------------\n\n";

    file_put_contents($logDir . '/emails.log', $logContent, FILE_APPEND);

    return true; // Always return true for dev flow
}
