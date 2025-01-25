<?php
require_once 'connessioneDB.php';

header('Content-Type: application/json');

try {
    $query = $conn->query("SELECT amount 
                                FROM campaign_info
                                WHERE name='goal'");
    $result = $query->fetch();

    echo json_encode([
        'success' => true,
        'goal' => $result['amount']
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
    exit;
}
