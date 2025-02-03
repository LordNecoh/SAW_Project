<?php

require_once 'connessioneDB.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
}else{
    echo json_encode([
        'success' => false,
        'error' => 'Method not allowed'
    ]);
    header("Location: ../index.php");
    exit();
}
