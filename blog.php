<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog page</title>

    <script src="https://cdn.tiny.cloud/1/588jweagpuzfiwm32ssh4lkeqf5ewgu30b52736hyh6qt6ga/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="js/blog.js" defer></script>

    <link rel="stylesheet" href="css/blog.css">

    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>
    <?php require 'header.php'; ?>

    <?php
        require_once 'database/connessioneDB.php';

        $isAdmin = isset($_SESSION['admin'])
    ?>

    <div class="blog-container">
        <h1>Blog</h1>

        <!-- Sezione per gli admin -->
        <?php if ($isAdmin): ?>
            <div class="admin-panel-container">
                <button id="toggleAdminPanel">Create a new post</button>
                <div class="admin-panel" id="adminPanel" style="display: none;">
                    <h2>Create a new post</h2>
                    <form id="newPostForm">
                        <input type="text" id="postTitle" name="title" placeholder="Post Title" required>
                        <textarea id="postContent" name="content"></textarea>
                        <button type="submit">Publish</button>
                    </form>
                    <button id="closeAdminPanel">Close</button>
                </div>
            </div>
        <?php endif; ?>

        <!-- Sezione per visualizzare i post -->
        <div id="blogPosts">
            <h2>All Posts</h2>
            <?php
            // Recupera i post dal database
            $query = $conn->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
            $posts = $query->fetchAll();

            if ($posts):
                foreach ($posts as $post):
            ?>
                    <div class="post">
                        <h3><?= htmlspecialchars($post['title']) ?></h3>
                        <div><?= $post['content'] ?></div>
                        <small>Posted by <?= htmlspecialchars($post['creator']) ?> on <?= htmlspecialchars($post['created_at']) ?></small>
                    </div>
            <?php
                endforeach;
            else:
                echo "<p>No posts available.</p>";
            endif;
            ?>
        </div>
    </div>

    <?php require 'footer.php'; ?>
</body>
</html>