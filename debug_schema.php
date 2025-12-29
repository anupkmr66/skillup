<?php
require_once 'core/Database.php';

try {
    $db = Database::getInstance();
    $stmt = $db->query("DESCRIBE courses");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($columns);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
