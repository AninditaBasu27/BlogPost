<?php
session_start();
include "db.php";
include "nav.php";

// ✅ Get post details safely
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $sql = "SELECT post.*, users.name AS user_name, category.name AS category_name 
          FROM post
          JOIN users ON post.author_id = users.id
          JOIN category ON post.category_id = category.id
          WHERE post.id = $id";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  
  if (!$row) {
    die("❌ Post not found.");
  }
} else {
  die("❌ Invalid Post ID.");
}

$logged_in_user_id = $_SESSION['user_id'] ?? null;
$logged_in_role = $_SESSION['user_role'] ?? 'guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($row['title']); ?></title>
  <link rel="stylesheet" href="post.css">
</head>
<body>
  <main class="single-post">
    <div class="post-wrapper">

      <!-- 🔙 Back Button -->
      <a href="displaypost.php" class="back-btn">← Back to All Posts</a>

      <!-- 📝 Post Header -->
      <h1><?php echo htmlspecialchars($row['title']); ?></h1>

      <div class="meta-info">
        <span class="author">👤 By <?php echo htmlspecialchars($row['user_name']); ?></span>
        <span class="category">📂 Category: <?php echo htmlspecialchars($row['category_name']); ?></span>
      </div>

      <!-- 🖼️ Post Image -->
      <?php if (!empty($row['image'])): ?>
        <img src="image/<?php echo htmlspecialchars($row['image']); ?>" alt="Post Image" class="post-image">
      <?php endif; ?>

      <!-- 🧾 Post Content -->
      <p class="post-content"><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
      <!-- ✏️ Edit/Delete Buttons (Visible to Author or Admin) -->
      <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
        <div class="post-actions">
          <a href="editpost.php?id=<?php echo (int)$row['id']; ?>" class="edit-btn">✏️ Edit</a>

          <form action="deletepost.php" method="post" onsubmit="return confirm('Are you sure you want to delete this post?');" style="display:inline">
            <input type="hidden" name="post_id" value="<?php echo (int)$row['id']; ?>">
            <button type="submit" class="delete-btn">🗑️ Delete</button>
          </form>
        </div>
      <?php endif; ?>




      <!-- 💬 Comment Form -->
      <form class="comment-form" action="insertcomment.php" method="post">
        <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
        <textarea name="comment" rows="4" placeholder="Write your comment..." required></textarea>
        <button type="submit" name="submit" class="comment-btn">Post Comment</button>
      </form>

      <!-- 💭 Display Comments -->
      <div class="comments-section">
        <h3>Comments</h3>
        <?php
        $comment_sql = "SELECT * FROM comments WHERE post_id = $id ORDER BY id DESC";
        $comment_result = mysqli_query($conn, $comment_sql);

        if (mysqli_num_rows($comment_result) > 0) {
          while ($comment = mysqli_fetch_assoc($comment_result)) {
            echo "<div class='comment-box'>
                    <h4>" . htmlspecialchars($comment['username']) . "</h4>
                    <p>" . nl2br(htmlspecialchars($comment['comment'])) . "</p>
                  </div>";
          }
        } else {
          echo "<p class='no-comments'>No comments yet. Be the first!</p>";
        }

        ?>
      </div>
    </div>
  </main>
</body>
</html>
