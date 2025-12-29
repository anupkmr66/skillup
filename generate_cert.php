<?php
require 'core/Database.php';
require 'config/constants.php';

try {
    $db = Database::getInstance();

    // Get first student
    $student = $db->fetchOne("SELECT * FROM students LIMIT 1");
    if (!$student)
        die("No students found\n");

    $courseId = $student['course_id'] ?? 1; // Fallback

    // Check if certificate exists
    $exists = $db->fetchOne("SELECT * FROM certificates WHERE student_id = ?", [$student['id']]);

    if ($exists) {
        die("Certificate already exists for Student ID: " . $student['id'] . "\n");
    }

    $data = [
        'student_id' => $student['id'],
        'course_id' => $courseId,
        'certificate_number' => 'CERT-' . date('Y') . '-' . str_pad($student['id'], 4, '0', STR_PAD_LEFT),
        'issue_date' => date('Y-m-d'),
        'status' => 'active'
    ];

    $db->insert('certificates', $data);
    echo "Sample certificate created for Student ID: " . $student['id'] . "\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
