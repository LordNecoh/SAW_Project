<?php
require_once 'connessioneDB.php';

header('Content-Type: application/json');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $totalQuery = $conn->query("SELECT SUM(amount) AS total FROM donations");
        $totalResult = $totalQuery->fetch();
        $totalDonations = $totalResult['total'] ?? 0;

        $donorsQuery = $conn->query("SELECT u.username, d.email, SUM(d.amount) AS total_donated
                                    FROM donations d
                                    INNER JOIN users u ON u.email = d.email
                                    WHERE d.public = 1
                                    GROUP BY u.username, d.email");    
        
        $donors = $donorsQuery->fetchAll();

        echo json_encode([
            'success' => true,
            'total' => $totalDonations,
            'donors' => $donors
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
