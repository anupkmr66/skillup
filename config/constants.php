<?php
/**
 * Application Constants
 */

// Base paths
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('STORAGE_PATH', ROOT_PATH . '/storage');
define('VIEW_PATH', ROOT_PATH . '/views');

// URL
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$script = str_replace('/public/index.php', '', $_SERVER['SCRIPT_NAME']);
define('BASE_URL', $protocol . $host . $script);

// User roles
define('ROLE_SUPER_ADMIN', 1);
define('ROLE_FRANCHISE_ADMIN', 2);
define('ROLE_INSTITUTE_ADMIN', 3);
define('ROLE_TEACHER', 4);
define('ROLE_STUDENT', 5);

// Status constants
define('STATUS_ACTIVE', 'active');
define('STATUS_INACTIVE', 'inactive');
define('STATUS_PENDING', 'pending');

// Payment status
define('PAYMENT_PAID', 'paid');
define('PAYMENT_PARTIAL', 'partial');
define('PAYMENT_DUE', 'due');

// Exam status
define('EXAM_PASS', 'pass');
define('EXAM_FAIL', 'fail');
