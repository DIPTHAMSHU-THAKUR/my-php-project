<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

// Get all posts
$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
?>

<h2>All Posts</h2>
<a href="create.php">+ Add New Post</a> | <a href="logout.php">Logout</a>
<hr>

<?php while ($row = $result->fetch_assoc()): ?>
    <div>
        <h3><?= htmlspecialchars($row['title']) ?></h3>
        <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
        <small>Posted on: <?= $row['created_at'] ?></small><br>
        <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?');">Delete</a>
        <hr>
    </div>
<?php endwhile; ?>
