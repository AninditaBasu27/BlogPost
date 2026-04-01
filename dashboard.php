<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BlendUp | Blogs</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<?php if (!isset($_SESSION['user_id'])) { ?>
  <?php include 'nav.php'; ?>
      <script>
        document.getElementById("myButton").addEventListener("click", function() {
            let popup = document.createElement('div');
            popup.innerText = '⚠️ Please login first!';
            popup.classList.add('popup');
            document.body.appendChild(popup);

            // Show popup for 20 seconds
            setTimeout(() => popup.style.opacity = '0', 19000);
            setTimeout(() => window.location.href = 'login.php', 20000);
        });
    </script>

<?php } else { ?>
    <?php include 'nav.php'; ?>
    <div class="page-content">
  <div class="user-info">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> 👋</h1>
    <p>You are: <strong><?php echo htmlspecialchars($_SESSION['user_role']); ?></strong></p>
    <a href="logout.php" class="logout-btn">Logout</a>
  </div>
</div>

<?php } ?>

<!-- BLOG SECTION -->
<section class="blog-section">
    <h1 class="section-title">Our Latest Blogs ✨</h1>

    <div class="cards-container">

      <!-- 💻 Technology -->
      <div class="card">
        <img src="./photos/Technology.jpg" alt="Technology">
        <div class="card-content">
          <h3>Technology</h3>
          <p>Stay up to date with the latest tech trends, innovations, and digital transformations.</p>
          <a href="category.php?category=Technology" class="btn">Explore Now</a>
        </div>
      </div>

      <!-- 🎓 Education -->
      <div class="card">
        <img src="./photos/Education.jpg" alt="Education">
        <div class="card-content">
          <h3>Education</h3>
          <p>Unlock knowledge, learn new skills, and explore opportunities to grow academically.</p>
          <a href="category.php?category=Education" class="btn">Explore Now</a>
        </div>
      </div>

      <!-- ⚽ Sports -->
      <div class="card">
        <img src="./photos/Sports.png" alt="Sports">
        <div class="card-content">
          <h3>Sports</h3>
          <p>Catch up on exciting sports news, training tips, and inspiring stories from the world of athletics.</p>
          <a href="category.php?category=Sports" class="btn">Explore Now</a>
        </div>
      </div>

      <!-- 🎬 Entertainment -->
      <div class="card">
        <img src="./photos/Entertainment.jpeg" alt="Entertainment">
        <div class="card-content">
          <h3>Entertainment</h3>
          <p>Dive into movies, music, and trending pop culture — everything that keeps you entertained.</p>
          <a href="category.php?category=Entertainment" class="btn">Explore Now</a>
        </div>
      </div>

      <div class="card">
        <img src="./photos/Travel.webp" alt="Travel">
        <div class="card-content">
          <h3>Travel</h3>
          <p>Explore breathtaking destinations, travel tips, and adventure stories from around the world.</p>
          <a href="category.php?category=Travel" class="btn">Explore Now</a>
        </div>
      </div>

      <div class="card">
        <img src="./photos/Lifestyle.avif" alt="Lifestyle">
        <div class="card-content">
          <h3>Lifestyle</h3>
          <p>Get inspired with articles on personal growth, home décor, and wellness routines that uplift your life.</p>
          <a href="category.php?category=Lifestyle" class="btn">Explore Now</a>
        </div>
      </div>

      <div class="card">
        <img src="./photos/Food.avif" alt="Food">
        <div class="card-content">
          <h3>Food</h3>
          <p>Delicious recipes, cooking tips, and food stories that bring flavor and joy to your kitchen.</p>
          <a href="category.php?category=Food" class="btn">Explore Now</a>
        </div>
      </div>

    </div>
</section>

</body>
</html>
