<?php
require 'core/Database.php';

try {
    $db = Database::getInstance();
    echo "Adding reset_token and reset_expires_at columns to users table...\n";

    // Add reset_token
    try {
        $db->query("ALTER TABLE users ADD COLUMN reset_token VARCHAR(64) NULL AFTER role_id");
        echo "Added reset_token column.\n";
    } catch (Exception $e) {
        echo "reset_token column might already exist or error: " . $e->getMessage() . "\n";
    }

    // Add reset_expires_at
    try {
        $db->query("ALTER TABLE users ADD COLUMN reset_expires_at DATETIME NULL AFTER reset_token");
        echo "Added reset_expires_at column.\n";
    } catch (Exception $e) {
        echo "reset_expires_at column might already exist or error: " . $e->getMessage() . "\n";
    }

    echo "Schema update complete.\n";

} catch (Exception $e) {
    echo "Critical Error: " . $e->getMessage() . "\n";
}
