<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'connessioneDB.php';

    session_start();

    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'createPost':
            if (!isset($_SESSION['admin'])) {
                echo json_encode(['success' => false, 'error' => 'Unauthorized']);
                exit;
            }

            $title = $_POST['title'];
            $content = $_POST['content'];
            $username = $_SESSION['username'];

            try {
                $stmt = $conn->prepare("INSERT INTO blog_posts (title, content, creator) 
                                                VALUES (:title, :content, :creator)");
                $stmt->execute(['title' => $title, 'content' => $content, 'creator' => $username]);
                echo json_encode(['success' => true]);
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            }
            break;

        default:
            echo json_encode(['success' => false, 'error' => 'Invalid action']);
            break;
    }
}
?>