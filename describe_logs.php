<?php
require_once 'core/Database.php';
try {
    $db = Database::getInstance();
    echo "Columns for activity_logs:\n";
    print_r($db->fetchAll("DESCRIBE activity_logs"));
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
