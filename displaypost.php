<?php
session_start();
include "db.php";
include "nav.php";

// ✅ Get logged-in username
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : "Guest";

// ✅ Fetch posts with author names
$sql = "SELECT post.*, users.name AS user_name 
        FROM post 
        JOIN users ON post.author_id = users.id 
        ORDER BY post.id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Blog Posts</title>
  <link rel="stylesheet" href="displaypost.css"> <!-- 👈 External CSS -->
</head>
<body>
  <main class="content-wrapper">
    <h1>All Blog Posts</h1>

    <div class="post-container">
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="post-card">
          <?php if (!empty($row['image'])): ?>
            <img src="image/<?php echo $row['image']; ?>" alt="Post Image">
          <?php endif; ?>

          <div class="post-content">
            <h2><?php echo htmlspecialchars($row['title']); ?></h2>
            
            <?php 
              // Short preview (first 150 chars)
              $preview = substr(strip_tags($row['content']), 0, 150);
              if (strlen($row['content']) > 150) $preview .= "...";
            ?>
            <p><?php echo htmlspecialchars($preview); ?></p>

            <div class="author">By: <?php echo htmlspecialchars($row['user_name']); ?></div>

            <a href="post.php?id=<?php echo $row['id']; ?>" class="read-more">Read More</a>
          </div>
        </div>
      <?php } ?>
    </div>
  </main>
</body>
</html>
