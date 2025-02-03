<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_SESSION['admin'])) {
            echo json_encode([
                'success' => false,
                'error' => 'Unauthorized access'
            ]);
            exit;
        }
        require_once 'connessioneDB.php';

        $action = $_POST['action'];

        switch ($action) {
            case 'getTopDonors':

                //    ---    Validazione    ---  //
                $topN = filter_input(INPUT_POST, 'topN', FILTER_VALIDATE_INT);
                if ($topN === false || $topN <= 0) {
                    echo json_encode([
                    'success' => false,
                        'error' => 'Invalid number of top donors.'
                    ]);
                    exit;
                }
                
                //    ---    Query    ---  //
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

                //    ---    Validazione    ---  //

                if (empty($_POST['username']) || !is_string($_POST['username'])) {
                    echo json_encode([
                        'success' => false,
                        'error' => 'Invalid username.'
                    ]);
                    exit;
                }
                $username = trim($_POST['username']); 

                
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
                        'donations' => $donations,
                        'username' => $username
                    ]);
                } catch (PDOException $e) {
                    echo json_encode([
                        'success' => false,
                        'error' => $e->getMessage()
                    ]);
                }
                break;

            case 'refundMoney':

                //    ---    Validazione    ---  //
                if (empty($_POST['refundUsername']) || !is_string($_POST['refundUsername'])) {
                    echo json_encode([
                        'success' => false,
                        'error' => 'Invalid username for refund.'
                    ]);
                    exit;
                }
                $username = trim($_POST['refundUsername']);
                
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
                if ($totalRefunded === false) {
                    echo json_encode([
                        'success' => false,
                        'error' => 'No donations found for this user.'
                    ]);
                    exit;
                }

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

                //    ---    Validazione    ---  //
                $goal = filter_input(INPUT_POST, 'goal', FILTER_VALIDATE_INT);
                if ($goal === false || $goal < 100 || $goal > 1000000) {
                    echo json_encode([
                        'success' => false,
                        'error' => 'Goal must be between 100 and 1,000,000'
                    ]);
                    exit;
                }
                
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

            case 'singleRefund':

                //    ---    Validazione    ---  //

                $donationID = filter_input(INPUT_POST, 'donationID', FILTER_VALIDATE_INT);
                if ($donationID === false || $donationID <= 0) {
                    echo json_encode([
                        'success' => false,
                        'error' => 'Invalid donation ID.'
                    ]);
                    exit;
                }
                
                //    ---    Query    ---  //
                try{
                    $conn->beginTransaction();
                    $stmt = $conn->prepare("SELECT amount 
                                            FROM donations 
                                            WHERE id = :donationID");
                    $stmt->bindParam(':donationID', $donationID, PDO::PARAM_INT);
                    $stmt->execute();
                    $amountRefunded = $stmt->fetchColumn();

                    if ($amountRefunded === false) {
                        echo json_encode([
                            'success' => false,
                            'error' => 'No donation found with this ID.'
                        ]);
                        exit;
                    }

                    $stmt = $conn->prepare("DELETE FROM donations 
                                            WHERE id = :donationID");
                    $stmt->bindParam(':donationID', $donationID, PDO::PARAM_INT);
                    $stmt->execute();

                    $conn->commit();
                    echo json_encode([
                        'success' => true,
                        'amountRefunded' => $amountRefunded
                    ]);
                } catch (PDOException $e) {
                    $conn->rollBack();
                    echo json_encode([
                        'success' => false,
                        'error' => $e->getMessage()
                    ]);
                }
                break;
                

            default:
                echo "Azione non riconosciuta.";
        }
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Method not allowed'
        ]);
        header("Location: ../index.php");
        exit();
    }
?>