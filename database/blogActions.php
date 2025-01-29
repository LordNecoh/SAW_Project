<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'connessioneDB.php';

    session_start();

    $action = $_POST['action'] ?? '';
    $isAdmin = isset($_SESSION['admin']);

    switch ($action) {
        case 'createPost':
            if (!$isAdmin) {
                echo json_encode(['success' => false, 'error' => 'Unauthorized']);
                exit;
            }

            //    ----  Validazione  ----  //
            if (empty($_POST['title']) || empty($_POST['content'])) {
                echo json_encode(['success' => false, 'error' => 'Title and content are required.']);
                exit;
            }
            
            $title = trim($_POST['title']);
            $content = trim($_POST['content']);
            $username = $_SESSION['username'];

            //    ----  Query  ----  //

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
                            <h3><?= htmlspecialchars($post['title']) ?></h3>
                            <div><?= $post['content'] ?></div>
                            <small>Posted by <?= htmlspecialchars($post['creator']) ?> on <?= htmlspecialchars($post['created_at']) ?></small>
                            <?php if ($isAdmin): ?>
                                <button class="deletePost" id="<?= $post['id'] ?>">Delete</button>
                            <?php endif; ?>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p>No posts found.</p>';
                }
            } catch (PDOException $e) {
                echo '<p>Error loading posts: ' . $e->getMessage() . '</p>';
            }
            break;

        case 'deletePost':
            if (!$isAdmin) {
                echo json_encode(['success' => false, 'error' => 'Unauthorized']);
                exit;
            }

            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            if ($id === false || $id <= 0) {
                echo json_encode(['success' => false, 'error' => 'Invalid post ID.']);
                exit;
            }

            try {
                $stmt = $conn->prepare("DELETE FROM blog_posts WHERE id = :id");
                $stmt->execute(['id' => $id]);
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