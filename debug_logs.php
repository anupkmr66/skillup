<?php
require_once 'core/Database.php';
try {
    $db = Database::getInstance();
    echo "Latest 5 Activity Logs:\n";
    $logs = $db->fetchAll("SELECT * FROM activity_logs ORDER BY created_at DESC LIMIT 5");
    print_r($logs);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
