<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Invalid ID");
}

// On form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $content, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

// Fetch post data
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();
?>

<h2>Edit Post</h2>
<form method="post">
    Title: <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required><br><br>
    Content:<br>
    <textarea name="content" rows="5" cols="40" required><?= htmlspecialchars($post['content']) ?></textarea><br><br>
    <button type="submit">Update</button>
</form>
<a href="index.php">Back</a>
