<?php
require 'connessioneDB.php';

header('Content-Type: application/json');

try {
    $query = $conn->query("SELECT d.amount 
                            FROM donations d
                            WHERE d.public = 0");    

    $donors = $query->fetchAll();

    echo json_encode([
        'success' => true,
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
    exit;
}