<?php
require_once 'core/Database.php';
try {
    $db = Database::getInstance();
    echo "Columns for student_courses:\n";
    print_r($db->fetchAll("DESCRIBE student_courses"));

    echo "\nColumns for fees:\n";
    print_r($db->fetchAll("DESCRIBE fees"));
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
