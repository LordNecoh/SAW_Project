<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'connessioneDB.php';

    $action = $_POST['action'];

    switch ($action) {
        case 'getTopDonors':

            //    ---    Query    ---  //
            $topN = $_POST['topN'];
            try{
                $stmt = $conn->prepare("SELECT u.username, d.email, SUM(d.amount) AS total_donated
                                        FROM donations d
                                        INNER JOIN users u ON u.email = d.email
                                        GROUP BY u.username, d.email
                                        ORDER BY total_donated DESC
                                        LIMIT :topN");
                $stmt->bindParam(':topN', $topN, PDO::PARAM_INT);
                $stmt->execute();
                $donors = $stmt->fetchAll();
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

        case 'getUserDonations':
            $username = $_POST['username'];
            
            //    ---    Query    ---  //
            try{
                $stmt = $conn->prepare("SELECT * 
                                        FROM donations 
                                        WHERE email = (SELECT email 
                                                       FROM users 
                                                       WHERE username = :username)");
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->execute();
                $donations = $stmt->fetchAll();
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

        case 'refundMoney':
            $username = $_POST['refundUsername'];
            
            //    ---    Query    ---  //
            try{
                $conn->beginTransaction();
                $stmt = $conn->prepare("SELECT SUM(amount) AS total_refunded 
                                        FROM donations 
                                        WHERE email = (SELECT email 
                                                       FROM users 
                                                       WHERE username = :username)");
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->execute();
                $totalRefunded = $stmt->fetchColumn();

                $stmt = $conn->prepare("DELETE FROM donations 
                                        WHERE email = (SELECT email 
                                                       FROM users 
                                                       WHERE username = :username)");
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->execute();

                $conn->commit();
                echo json_encode([
                    'success' => true,
                    'totalRefunded' => $totalRefunded
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
                $stmt = $conn->prepare("UPDATE campaign_info SET amount = :goal WHERE name = 'goal'");
                $stmt->bindParam(':goal', $goal, PDO::PARAM_INT);
                $stmt->execute();
                echo json_encode([
                    'success' => true,
                    'newGoal' => $goal
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