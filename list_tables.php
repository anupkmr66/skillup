<?php
require_once 'core/Database.php';
try {
    $db = Database::getInstance();
    $tables = $db->fetchAll("SHOW TABLES");
    print_r($tables);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
