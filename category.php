<?php
include "db.php";
include 'nav.php';

// Get category from URL
if (isset($_GET['category'])) {
    $category = mysqli_real_escape_string($conn, $_GET['category']);
} else {
    die("Category not specified!");
}

// Fetch posts from this category
$sql = "SELECT post.*, category.name AS category_name
        FROM post 
        JOIN category 
        ON post.category_id = category.id
        WHERE category.name = '$category'";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo ucfirst($category); ?> Blogs | BlendUp</title>
  <link rel="stylesheet" href="category.css">
</head>
<body>

<section class="category-section">
  <h1><?php echo ucfirst($category); ?> Blogs ✨</h1>

  <div class="posts-container">
    <?php
      if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              $short_content = substr($row['content'], 0, 100) . '...';
              echo "
                <div class='post-card'>
                <img src='image/" . $row['image'] . "' alt='" . $row['title'] . "'>
                <div class='post-info'>
                    <h2>" . $row['title'] . "</h2>
                    <p>" . substr($row['content'], 0, 100) . "...</p>
                    <a href='post.php?id=" . $row['id'] . "' class='btn'>Read More</a>
                </div>
                </div>";

          }
      } else {
          echo "<p class='no-posts'>No posts found in this category yet.</p>";
      }
    ?>
  </div>
</section>

</body>
</html>
