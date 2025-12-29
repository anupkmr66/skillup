<?php
require 'core/Database.php';

try {
    $db = Database::getInstance();

    echo "Tables:\n";
    $tables = $db->fetchAll("SHOW TABLES");
    foreach ($tables as $t) {
        echo "- " . current($t) . "\n";
    }

    echo "\nBatches Columns:\n";
    $columns = $db->fetchAll("SHOW COLUMNS FROM batches");
    foreach ($columns as $c) {
        echo "- " . $c['Field'] . " (" . $c['Type'] . ")\n";
    }

    echo "\nTeachers Columns (if exists):\n";
    try {
        $columns = $db->fetchAll("SHOW COLUMNS FROM teachers");
        foreach ($columns as $c) {
            echo "- " . $c['Field'] . " (" . $c['Type'] . ")\n";
        }
    } catch (Exception $e) {
        echo "Table 'teachers' does not exist.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
