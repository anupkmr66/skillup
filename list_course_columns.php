<?php
require_once 'core/Database.php';
try {
    $db = Database::getInstance();
    echo "Columns for courses:\n";
    print_r($db->fetchAll("DESCRIBE courses"));
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
