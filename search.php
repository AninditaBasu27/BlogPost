<?php
include "db.php";
include 'nav.php';

// Check if the search term exists
if (isset($_GET['query'])) {
    $query = mysqli_real_escape_string($conn, $_GET['query']);
} else {
    die("No search term entered!");
}

// SQL: search in title, content, and category name
$sql = "SELECT post.*, category.name AS category_name
        FROM post
        JOIN category ON post.category_id = category.id
        WHERE post.title LIKE '%$query%'
        OR post.content LIKE '%$query%'
        OR category.name LIKE '%$query%'";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search Results for "<?php echo htmlspecialchars($query); ?>"</title>
  <link rel="stylesheet" href="nav.css">
  <link rel="stylesheet" href="category.css">
</head>
<body>

<section class="category-section">
  <h1>Search Results for “<?php echo htmlspecialchars($query); ?>” 🔍</h1>

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
                <p>" . $short_content . "</p>
                <a href='post.php?id=" . $row['id'] . "' class='btn'>Read More</a>
              </div>
            </div>";
        }
    } else {
        echo "<p class='no-posts'>No results found for your search.</p>";
    }
    ?>
  </div>
</section>

</body>
</html>
