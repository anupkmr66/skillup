<?php
require_once 'core/Database.php';

try {
    $db = Database::getInstance();
    echo "Updating courses table schema...\n";

    // Add regular_price column
    try {
        $db->query("ALTER TABLE courses ADD COLUMN regular_price DECIMAL(10,2) DEFAULT 0.00 AFTER fee");
        echo "Added regular_price column.\n";
    } catch (Exception $e) {
        echo "regular_price column might already exist or error: " . $e->getMessage() . "\n";
    }

    // Add offer_price column
    try {
        $db->query("ALTER TABLE courses ADD COLUMN offer_price DECIMAL(10,2) DEFAULT 0.00 AFTER regular_price");
        echo "Added offer_price column.\n";
    } catch (Exception $e) {
        echo "offer_price column might already exist or error: " . $e->getMessage() . "\n";
    }

    // Migrate existing fee data to new columns
    // Note: column name is 'fee' (singular)
    echo "Migrating existing fee data...\n";
    // Check if fee column exists first just to be safe (though we know it does)
    try {
        $db->query("UPDATE courses SET regular_price = fee, offer_price = fee WHERE regular_price = 0 OR regular_price IS NULL");
        echo "Data migration completed.\n";
    } catch (Exception $e) {
        echo "Migration error: " . $e->getMessage() . "\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
