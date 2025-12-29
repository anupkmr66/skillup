<?php
require_once 'core/Database.php';
try {
    $db = Database::getInstance();
    echo "Checking for valid certificates...\n";

    $sql = "SELECT er.id, er.status, s.first_name, c.course_name 
            FROM exam_results er
            JOIN students s ON er.student_id = s.id
            JOIN exams e ON er.exam_id = e.id
            JOIN courses c ON e.course_id = c.id
            JOIN institutes i ON s.institute_id = i.id
            LIMIT 10";

    $results = $db->fetchAll($sql);

    if (empty($results)) {
        echo "No exam results found with full joins.\n";

        // Debug partial tables
        echo "Total Exam Results: " . $db->fetchOne("SELECT COUNT(*) as c FROM exam_results")['c'] . "\n";
        echo "Total Students: " . $db->fetchOne("SELECT COUNT(*) as c FROM students")['c'] . "\n";
    } else {
        foreach ($results as $r) {
            echo "ID: " . $r['id'] . " | Status: " . $r['status'] . " | Student: " . $r['first_name'] . " | Course: " . $r['course_name'] . "\n";
            echo "Try verifying with: CERT-" . str_pad($r['id'], 6, '0', STR_PAD_LEFT) . "\n";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
