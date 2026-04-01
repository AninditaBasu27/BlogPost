<?php
session_start();
include "db.php";

// ✅ Require login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$logged_user_id = $_SESSION['user_id'];
$role = strtolower(trim($_SESSION['user_role'] ?? ''));

// ✅ Get post ID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = intval($_POST['post_id']);
} elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $post_id = intval($_GET['id']);
} else {
    $message = "⚠️ No post specified.";
    $type = "error";
}

// ✅ Fetch post
if (!isset($message)) {
    $stmt = $conn->prepare("SELECT id, author_id, image FROM post WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows !== 1) {
        $message = "⚠️ Post not found.";
        $type = "error";
    } else {
        $post = $res->fetch_assoc();

        // ✅ Permission check
        if ($role !== 'admin' && (int)$post['author_id'] !== (int)$logged_user_id) {
            $message = "🚫 You are not authorized to delete this post.";
            $type = "error";
        } else {
            // ✅ Delete comments first
            $delComments = $conn->prepare("DELETE FROM comments WHERE post_id = ?");
            $delComments->bind_param("i", $post_id);
            $delComments->execute();
            $delComments->close();

            // ✅ Delete post
            $delPost = $conn->prepare("DELETE FROM post WHERE id = ?");
            $delPost->bind_param("i", $post_id);
            if ($delPost->execute()) {
                $message = "✅ Post deleted successfully!";
                $type = "success";

                // ✅ Delete image if exists
                if (!empty($post['image'])) {
                    $imgPath = __DIR__ . "/image/" . $post['image'];
                    if (file_exists($imgPath)) {
                        @unlink($imgPath);
                    }
                }
            } else {
                $message = "❌ Error deleting post: " . htmlspecialchars($conn->error);
                $type = "error";
            }
            $delPost->close();
        }
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Delete Status</title>
  <link rel="stylesheet" href="deletepost.css">
</head>
<body>
  <div class="popup <?php echo ($type === 'success') ? 'success' : (($type === 'error') ? 'error' : 'info'); ?>">
    <?php echo htmlspecialchars($message); ?>
  </div>
  <script>
    setTimeout(() => {
      window.location.href = 'displaypost.php'; // ✅ Redirect to all posts page
    }, 2000);
  </script>
  <script>
  // Add fade-out effect before redirect
  setTimeout(() => {
    const popup = document.querySelector(".popup");
    if (popup) popup.classList.add("fade-out");
  }, 1500);

  // Redirect to all posts page after 2 seconds
  setTimeout(() => {
    window.location.href = 'displaypost.php';
  }, 2000);
</script>

</body>
</html>
