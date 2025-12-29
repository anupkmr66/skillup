<?php
require 'core/Database.php';
require 'config/constants.php';

try {
    $db = Database::getInstance();

    // Find Shreya
    $student = $db->fetchOne("SELECT * FROM students WHERE first_name LIKE 'Shreya%' LIMIT 1");

    if (!$student) {
        die("Student 'Shreya' not found.\n");
    }

    echo "Student Found: " . $student['first_name'] . " " . $student['last_name'] . " (ID: " . $student['id'] . ")\n";

    // Check Enrollment (to get Course ID)
    $enrollment = $db->fetchOne("SELECT * FROM student_courses WHERE student_id = ?", [$student['id']]);

    if ($enrollment) {
        echo "Enrolled in Course ID: " . $enrollment['course_id'] . "\n";
    } else {
        echo "No Course Enrollment found for this student.\n";
    }

    // Check Certificate
    $cert = $db->fetchOne("SELECT * FROM certificates WHERE student_id = ?", [$student['id']]);

    if ($cert) {
        echo "Certificate FOUND. ID: " . $cert['id'] . ", Status: " . $cert['status'] . "\n";
    } else {
        echo "No Certificate found in 'certificates' table.\n";

        // Attempt to create one providing we have a course ID
        if ($enrollment) {
            echo "Creating missing certificate...\n";
            $data = [
                'student_id' => $student['id'],
                'course_id' => $enrollment['course_id'], // Use ACTUAL course ID
                'certificate_number' => 'CERT-' . date('Y') . '-' . str_pad($student['id'], 4, '0', STR_PAD_LEFT),
                'issue_date' => date('Y-m-d'),
                'status' => 'active'
            ];

            $db->insert('certificates', $data);
            echo "Certificate created successfully!\n";
        } else {
            echo "Cannot create certificate: Missing Course ID.\n";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
