<?php
/**
 * Web Routes
 */

// Public routes
$router->get('/', 'HomeController@index');
$router->get('/about', 'HomeController@about');
$router->get('/courses', 'HomeController@courses');
$router->get('/course/details', 'HomeController@courseDetails'); // Using query param ?id=X
$router->get('/contact', 'HomeController@contact');
$router->post('/contact', 'HomeController@submitContact');
$router->get('/verify-certificate', 'HomeController@verifyCertificate');
$router->post('/verify-certificate', 'HomeController@checkCertificate');
$router->get('/franchise-inquiry', 'HomeController@franchiseInquiry');
$router->post('/franchise-inquiry', 'HomeController@submitFranchiseInquiry');

// Legal Pages
$router->get('/terms', 'HomeController@terms');
$router->get('/privacy', 'HomeController@privacy');
$router->get('/policy', 'HomeController@policy');

// Authentication routes
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

// Password Reset routes
$router->get('/forgot-password', 'AuthController@showForgotPassword');
$router->post('/forgot-password', 'AuthController@sendResetLink');
$router->get('/reset-password', 'AuthController@showResetPassword');
$router->post('/reset-password', 'AuthController@resetPassword');

// Super Admin routes
$router->get('/admin/dashboard', 'AdminController@dashboard', ['auth']);
$router->get('/admin/franchises', 'AdminController@franchises', ['auth']);
$router->post('/admin/franchises/create', 'AdminController@createFranchise', ['auth']);
$router->post('/admin/franchises/update', 'AdminController@updateFranchise', ['auth']);
$router->post('/admin/franchises/delete', 'AdminController@deleteFranchise', ['auth']);
$router->get('/admin/franchise/certificate', 'AdminController@viewFranchiseCertificate', ['auth']);
$router->get('/admin/institutes', 'AdminController@institutes', ['auth']);
$router->post('/admin/institutes/create', 'AdminController@createInstitute', ['auth']);
$router->post('/admin/institutes/update', 'AdminController@updateInstitute', ['auth']);
$router->post('/admin/institutes/delete', 'AdminController@deleteInstitute', ['auth']);
$router->get('/admin/students', 'AdminController@students', ['auth']);
$router->get('/admin/reports', 'AdminController@reports', ['auth']);
$router->get('/admin/settings', 'AdminController@settings', ['auth']);
$router->post('/admin/settings', 'AdminController@updateSettings', ['auth']);
$router->get('/admin/leads', 'AdminController@leads', ['auth']);

// Course Management
$router->get('/admin/courses', 'AdminController@courses', ['auth']);
$router->post('/admin/courses/create', 'AdminController@createCourse', ['auth']);
$router->post('/admin/courses/update', 'AdminController@updateCourse', ['auth']);
$router->post('/admin/courses/delete', 'AdminController@deleteCourse', ['auth']);

// Institute Management
$router->post('/admin/institutes/create', 'AdminController@createInstitute', ['auth']);
$router->post('/admin/institutes/update', 'AdminController@updateInstitute', ['auth']);
$router->post('/admin/institutes/delete', 'AdminController@deleteInstitute', ['auth']);

// Franchise Admin routes
$router->get('/franchise/dashboard', 'FranchiseController@dashboard', ['auth']);
$router->get('/franchise/institutes', 'FranchiseController@institutes', ['auth']);
$router->get('/franchise/wallet', 'FranchiseController@wallet', ['auth']);
$router->get('/franchise/withdrawals', 'FranchiseController@withdrawals', ['auth']);

// Institute Admin routes
$router->get('/institute/dashboard', 'InstituteController@dashboard', ['auth']);
$router->get('/institute/students', 'InstituteController@students', ['auth']);
$router->get('/institute/fees', 'InstituteController@fees', ['auth']);
$router->get('/institute/fees/print-receipt', 'InstituteController@printReceipt', ['auth']);
$router->get('/institute/fees/print-statement', 'InstituteController@printStatement', ['auth']);
$router->get('/institute/exams', 'InstituteController@exams', ['auth']);
$router->get('/institute/batches', 'InstituteController@batches', ['auth']);
$router->get('/institute/teachers', 'InstituteController@teachers', ['auth']);
$router->get('/institute/attendance', 'InstituteController@attendance', ['auth']);
$router->get('/institute/attendance/report', 'InstituteController@attendanceReport', ['auth']);
$router->get('/institute/exam/results', 'InstituteController@examResults', ['auth']);
$router->get('/institute/certificate/download', 'InstituteController@downloadCertificate', ['auth']);
$router->get('/institute/profile', 'InstituteController@profile', ['auth']);

// Teacher routes
$router->get('/teacher/dashboard', 'TeacherController@dashboard', ['auth']);
$router->get('/teacher/batches', 'TeacherController@batches', ['auth']);
$router->get('/teacher/materials', 'TeacherController@materials', ['auth']);

// Student routes
$router->get('/student/dashboard', 'StudentController@dashboard', ['auth']);
$router->get('/student/profile', 'StudentController@profile', ['auth']);
$router->get('/student/fees', 'StudentController@fees', ['auth']);
$router->get('/student/results', 'StudentController@results', ['auth']);
$router->get('/student/certificates', 'StudentController@certificates', ['auth']);
$router->get('/student/certificate/download', 'StudentController@downloadCertificate', ['auth']);
$router->get('/student/materials', 'StudentController@materials', ['auth']);

// ============================================
// API ROUTES (AJAX Endpoints)
// ============================================
$router->post('/api/student/create', 'ApiController@createStudent', ['auth']);
$router->post('/api/student/update', 'ApiController@updateStudent', ['auth']);
$router->post('/api/student/delete', 'ApiController@deleteStudent', ['auth']);
$router->get('/api/student/get', 'ApiController@getStudent', ['auth']);

$router->post('/api/teacher/create', 'ApiController@createTeacher', ['auth']);
$router->post('/api/teacher/update', 'ApiController@updateTeacher', ['auth']);
$router->post('/api/teacher/delete', 'ApiController@deleteTeacher', ['auth']);

$router->post('/api/payment/create', 'ApiController@createPayment', ['auth']);
$router->get('/api/fee/get', 'ApiController@getFee', ['auth']);
$router->post('/api/fee/discount', 'ApiController@applyDiscount', ['auth']);
$router->post('/api/batch/create', 'ApiController@createBatch', ['auth']);
$router->post('/api/batch/update', 'ApiController@updateBatch', ['auth']);
$router->post('/api/batch/delete', 'ApiController@deleteBatch', ['auth']);
$router->get('/api/batch/students', 'ApiController@getBatchStudents', ['auth']);
$router->post('/api/exam/create', 'ApiController@createExam', ['auth']);
$router->post('/api/exam/update', 'ApiController@updateExam', ['auth']);
$router->post('/api/exam/delete', 'ApiController@deleteExam', ['auth']);
$router->get('/api/exam/results', 'ApiController@getExamResults', ['auth']);
$router->post('/api/exam/results/update', 'ApiController@updateExamResults', ['auth']);
$router->post('/api/course/create', 'ApiController@createCourse', ['auth']);
$router->post('/api/enroll', 'ApiController@enrollStudent', ['auth']);
$router->post('/api/lead/submit', 'ApiController@submitLead'); // Public route
$router->post('/api/material/upload', 'ApiController@uploadMaterial', ['auth']);
$router->post('/api/attendance/record', 'ApiController@recordAttendance', ['auth']);
$router->get('/api/attendance/monthly', 'ApiController@getMonthlyAttendance', ['auth']);
$router->post('/api/institute/update', 'ApiController@updateInstituteProfile', ['auth']);
$router->get('/api/stats', 'ApiController@getDashboardStats', ['auth']);

// End of routes
