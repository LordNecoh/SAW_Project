<?php
require 'connessioneDB.php';

header('Content-Type: application/json');

try {
    $totalQuery = $conn->query("SELECT SUM(amount) AS total FROM donations");
    $totalResult = $totalQuery->fetch();
    $totalDonations = $totalResult['total'] ?? 0;

    $donorsQuery = $conn->query("SELECT email, amount FROM donations WHERE public = 1");
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
