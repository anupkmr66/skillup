<?php
require_once 'core/Database.php';

try {
    $db = Database::getInstance();

    $sql = "CREATE TABLE IF NOT EXISTS leads (
        id INT AUTO_INCREMENT PRIMARY KEY,
        course_id INT UNSIGNED NOT NULL,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        city VARCHAR(100),
        education VARCHAR(100),
        message TEXT,
        status ENUM('new', 'contacted', 'enrolled', 'closed') DEFAULT 'new',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $db->query($sql);
    echo "Table 'leads' created successfully.";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
