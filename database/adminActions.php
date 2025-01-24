<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'connessioneDB.php';

    $action = $_POST['action'];

    switch ($action) {
        case 'topDonors':
            $topN = $_POST['topN'];
            try{
                $Query = $conn->query("SELECT u.username, d.email, SUM(d.amount) AS total_donated
                                    FROM donations d
                                    INNER JOIN users u ON u.email = d.email
                                    WHERE d.public = 1
                                    GROUP BY u.username, d.email
                                    ORDER BY total_donated DESC
                                    LIMIT $topN");
                $donors = $Query->fetchAll();
                echo json_encode([
                    'success' => true,
                    'donors' => $donors
                ]);
            } catch (PDOException $e) {
                echo json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ]);
                exit;
            }

            //Da continuare
            break;

        case 'userDonations':
            $username = $_POST['username'];
            // Logica per cercare le donazioni dell'utente
            break;

        case 'spendMoney':
            $amount = $_POST['amount'];
            // Logica per spendere soldi
            break;

        case 'setGoal':
            $goal = $_POST['goal'];
            // Logica per impostare l'obiettivo
            break;

        default:
            echo "Azione non riconosciuta.";
    }
}
?>