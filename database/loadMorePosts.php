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

    error_log("Posts fetched: " . print_r($posts, true));   //Debug


    $posts = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($posts as $post) {
        $post['content'] = htmlspecialchars($post['content']); // Escape dell'HTML
    }

    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'posts' => $posts]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>