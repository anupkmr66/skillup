<?php
require 'core/Database.php';

try {
    $db = Database::getInstance();

    echo "Creating teachers table...\n";

    $sql = "CREATE TABLE IF NOT EXISTS teachers (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT(11) UNSIGNED NOT NULL,
        institute_id INT(11) UNSIGNED NOT NULL,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        qualification VARCHAR(100),
        experience VARCHAR(50),
        specialization VARCHAR(100),
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (institute_id) REFERENCES institutes(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $db->query($sql);
    echo "Table 'teachers' created successfully.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
