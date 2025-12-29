<?php
require_once 'core/Database.php';

try {
    $db = Database::getInstance();
    echo "Checking courses table columns...\n";

    $stmt = $db->query("DESCRIBE courses");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "Current columns: " . implode(', ', $columns) . "\n";

    if (!in_array('regular_price', $columns)) {
        echo "Adding regular_price...\n";
        try {
            $db->query("ALTER TABLE courses ADD COLUMN regular_price DECIMAL(10,2) DEFAULT 0.00");
            echo "Success.\n";
        } catch (Exception $e) {
            echo "Error adding regular_price: " . $e->getMessage() . "\n";
        }
    } else {
        echo "regular_price already exists.\n";
    }

    if (!in_array('offer_price', $columns)) {
        echo "Adding offer_price...\n";
        try {
            $db->query("ALTER TABLE courses ADD COLUMN offer_price DECIMAL(10,2) DEFAULT 0.00");
            echo "Success.\n";
        } catch (Exception $e) {
            echo "Error adding offer_price: " . $e->getMessage() . "\n";
        }
    } else {
        echo "offer_price already exists.\n";
    }

    // Refresh columns
    $stmt = $db->query("DESCRIBE courses");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (in_array('regular_price', $columns) && in_array('offer_price', $columns)) {
        echo "Migrating data...\n";
        // Assuming 'fee' column exists based on previous logs
        if (in_array('fee', $columns)) {
            $db->query("UPDATE courses SET regular_price = fee, offer_price = fee WHERE (regular_price = 0 OR regular_price IS NULL) AND fee > 0");
            echo "Data migrated from 'fee'.\n";
        } elseif (in_array('fees', $columns)) {
            $db->query("UPDATE courses SET regular_price = fees, offer_price = fees WHERE (regular_price = 0 OR regular_price IS NULL) AND fees > 0");
            echo "Data migrated from 'fees'.\n";
        }
    }

    echo "Final columns: " . implode(', ', $columns) . "\n";

} catch (Exception $e) {
    echo "Fatal Error: " . $e->getMessage() . "\n";
}
