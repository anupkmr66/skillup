<?php
/**
 * Application Configuration
 */

return [
    'name' => 'SkillUp - Computer Center Management System',
    'url' => getenv('APP_URL') ?: 'http://localhost/skillup',
    'timezone' => 'Asia/Kolkata',
    'debug' => getenv('APP_DEBUG') ?: true,

    // File upload settings
    'upload' => [
        'max_size' => 5 * 1024 * 1024, // 5MB
        'allowed_images' => ['jpg', 'jpeg', 'png', 'gif'],
        'allowed_documents' => ['pdf', 'doc', 'docx'],
        'allowed_videos' => ['mp4', 'avi', 'mov'],
    ],

    // Pagination
    'pagination' => [
        'per_page' => 10,
    ],

    // Student ID format
    'student_id_prefix' => 'STU',

    // Franchise code prefix
    'franchise_code_prefix' => 'FR',

    // Certificate number prefix
    'certificate_prefix' => 'CERT',
];
