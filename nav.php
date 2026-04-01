<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BlendUp</title>
  <link rel="stylesheet" href="nav.css">
</head>
<body>
  <nav>
    <!-- Logo -->
    <div class="logo">
      <img src="./source/logo.png" alt="logo">
      <h2><b>BlogVerse</b></h2>
    </div>

    <!-- Nav links -->
    <div class="nav-links">
      <a href="dashboard.php"><b>Home</b></a>
      <a href="displaypost.php"><b>All Blogs</b></a>
      <a href="insertpost.php"><b>Add Blogs</b></a>
    </div>

    <!-- Search Bar -->
    <div class="search-bar">
      <form action="search.php" method="GET">
        <input type="text" name="query" placeholder="Search blogs..." required>
        <button type="submit">Search</button>
      </form>
    </div>

    <!-- Auth Buttons -->
    <div class="auth-buttons">
      <a href="login.php" class="login">Login</a>
      <a href="register.php" class="register">Register</a>
    </div>
  </nav>

  <script>
    function toggleMenu() {
      const menu = document.getElementById("menu");
      menu.classList.toggle("nav-active");
    }
  </script>
</body>
</html>
