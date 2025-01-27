<?php
require_once 'connessioneDB.php';

$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;

error_log("Offset: $offset, Limit: $limit");    //Debug

try {
    $query = $conn->prepare("SELECT * FROM blog_posts ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
    $query->bindValue(':limit', $limit, PDO::PARAM_INT);
    $query->bindValue(':offset', $offset, PDO::PARAM_INT);
    $query->execute();

    $posts = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($posts) {
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
        echo '<p>No more posts to load.</p>';
    }
} catch (PDOException $e) {
    echo '<p>Error loading posts: ' . htmlspecialchars($e->getMessage()) . '</p>';
}
?>