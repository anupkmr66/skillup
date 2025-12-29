<?php
require_once 'core/Database.php';

try {
    $db = Database::getInstance();

    $sql = "CREATE TABLE IF NOT EXISTS franchise_certificates (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        certificate_number VARCHAR(50) NOT NULL UNIQUE,
        franchise_id INT UNSIGNED NOT NULL,
        issue_date DATE NOT NULL,
        status ENUM('active', 'revoked') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (franchise_id) REFERENCES franchises(id) ON DELETE CASCADE,
        INDEX idx_certificate_number (certificate_number),
        INDEX idx_franchise (franchise_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $db->query($sql);
    echo "Table 'franchise_certificates' created successfully.";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
