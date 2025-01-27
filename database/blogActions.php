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

        case 'searchPosts':
            $search = $_POST['search'] ?? '';

            try {
                $stmt = $conn->prepare("SELECT * FROM blog_posts WHERE title LIKE :search OR content LIKE :search");
                $stmt->execute(['search' => "%$search%"]);
                $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if($posts) {
                    foreach ($posts as $post) {
                        ?>
                        <div class="post">
                            <h3><?= $post['title'] ?></h3>
                            <div><?= $post['content'] ?></div>
                            <small>Posted by <?= htmlspecialchars($post['creator']) ?> on <?= htmlspecialchars($post['created_at']) ?></small>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p>No posts found.</p>';
                }
            } catch (PDOException $e) {
                echo '<p>Error loading posts: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
            break;

        default:
            echo json_encode(['success' => false, 'error' => 'Invalid action']);
            break;
    }
}
?>