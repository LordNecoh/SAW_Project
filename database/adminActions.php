<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'connessioneDB.php';

    $action = $_POST['action'];

    switch ($action) {
        case 'topDonors':

            //    ---    Query    ---  //
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
            }
        
            break;

        case 'userDonations':
            $username = $_POST['username'];
            
            //    ---    Query    ---  //
            try{
                $Query = $conn->query("SELECT * 
                                    FROM donations 
                                    WHERE email = (SELECT email 
                                                    FROM users 
                                                    WHERE username = '$username')");
                $donations = $Query->fetchAll();
                echo json_encode([
                    'success' => true,
                    'donations' => $donations
                ]);
            } catch (PDOException $e) {
                echo json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ]);
            }
            break;

        case 'spendMoney':
            $amount = $_POST['amount'];
            
            //    ---    Query    ---  //
            try{
                $conn->beginTransaction();
                $conn->exec("UPDATE users SET balance = balance - $amount WHERE email = '$_SESSION[email]'");
                $conn->exec("INSERT INTO donations (email, amount, public) VALUES ('$_SESSION[email]', $amount, 1)");
                $conn->commit();
                echo json_encode([
                    'success' => true
                ]);
            } catch (PDOException $e) {
                $conn->rollBack();
                echo json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ]);
            }
            break;

        case 'setGoal':
            $goal = $_POST['goal'];
            
            //    ---    Query    ---  //
            try{
                $conn->exec("UPDATE donations SET goal = $goal WHERE email = '$_SESSION[email]'");
                echo json_encode([
                    'success' => true
                ]);
            } catch (PDOException $e) {
                echo json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ]);
            }
            break;

        default:
            echo "Azione non riconosciuta.";
    }
}
?>