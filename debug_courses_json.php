<?php
require_once 'core/Database.php';

try {
    $db = Database::getInstance();
    $courses = $db->fetchAll("SELECT * FROM courses");

    echo "Checking " . count($courses) . " courses...\n";

    foreach ($courses as $course) {
        $json = json_encode($course);
        if ($json === false) {
            echo "XXX JSON Encode FAILED for Course ID " . $course['id'] . ": " . json_last_error_msg() . "\n";
            // dump the bad data
            print_r($course);
        } else {
            echo "OK: Course ID " . $course['id'] . " encodes successfully.\n";
            // Check for potential attribute breaking chars
            if (strpos($json, "'") !== false)
                echo "   -> Contains single quote\n";
            if (strpos($json, '"') !== false)
                echo "   -> Contains double quote\n";

            // output the encoded string for one record to see structure
            if ($course['id'] == 1)
                echo "Example JSON: " . $json . "\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
