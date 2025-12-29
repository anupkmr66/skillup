<?php
require_once 'core/Database.php';

try {
    $db = Database::getInstance();

    // Check if column exists
    $columns = $db->fetchAll("DESCRIBE fees");
    $exists = false;
    foreach ($columns as $col) {
        if ($col['Field'] === 'discount_amount') {
            $exists = true;
            break;
        }
    }

    if (!$exists) {
        $sql = "ALTER TABLE fees ADD COLUMN discount_amount DECIMAL(10,2) DEFAULT 0.00 AFTER total_fee";
        $db->query($sql);
        echo "Successfully added 'discount_amount' column to fees table.\n";
    } else {
        echo "Column 'discount_amount' already exists.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
