<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$columns = $db->fetchAll("DESCRIBE payments");
print_r($columns);
