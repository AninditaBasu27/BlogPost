<?php
session_start();
include "db.php";
include 'nav.php';

// ✅ 1️⃣ If not logged in → show popup then redirect
if (!isset($_SESSION['user_id'])) {
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Redirecting...</title>
        <style>
            .popup {
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                background-color: #ff3333;
                color: white;
                padding: 15px 25px;
                border-radius: 10px;
                font-family: Arial, sans-serif;
                box-shadow: 0 0 10px rgba(0,0,0,0.3);
                z-index: 9999;
                opacity: 1;
                transition: opacity 0.6s ease;
            }
        </style>
    </head>
    <body>
        <div class="popup" id="popup">⚠️ Please login first!</div>

        <script>
            setTimeout(() => document.getElementById("popup").style.opacity = "0", 1800);
            setTimeout(() => window.location.href = "login.php", 2500);
        </script>
    </body>
    </html>';
    exit();
}

// ✅ 2️⃣ Allow only admin access
if (strtolower(trim($_SESSION['user_role'])) != 'admin') {
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Access Denied</title>
        <style>
            #popup {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                animation: fadeIn 0.3s ease;
            }
            .popup-content {
                background: #f44336;
                color: white;
                padding: 15px 25px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0,0,0,0.3);
                font-family: "Poppins", sans-serif;
                position: relative;
                min-width: 250px;
                opacity: 1;
                transition: opacity 0.6s ease;
            }
            .popup-content h3 { margin-bottom: 5px; }
            .close-btn {
                position: absolute;
                top: 8px;
                right: 10px;
                font-size: 20px;
                cursor: pointer;
                color: white;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateX(30px); }
                to { opacity: 1; transform: translateX(0); }
            }
        </style>
    </head>
    <body>
        <div id="popup">
            <div class="popup-content" id="popupContent">
                <span class="close-btn" onclick="closePopup()">&times;</span>
                <h3>Access Denied 🚫</h3>
                <p>You are not an admin. Only admins can add blogs.</p>
            </div>
        </div>

        <script>
            function closePopup() {
                const popup = document.getElementById("popupContent");
                popup.style.opacity = "0";
                setTimeout(() => window.location.href = "dashboard.php", 600);
            }
            setTimeout(closePopup, 4000);
        </script>
    </body>
    </html>';
    exit();
}

// ✅ 3️⃣ Admin section (only runs if logged in AND role == admin)
$user_id = $_SESSION['user_id'];

// Fetch categories for dropdown
$sql = "SELECT * FROM category ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Error fetching categories: {$conn->error}");
}

// ✅ 4️⃣ Handle post submission
if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $name = $_FILES['image']['name'];
    $temp_location = $_FILES['image']['tmp_name'];
    $ourlocation = "image/";

    // Upload image if exists
    if (!empty($name)) {
        move_uploaded_file($temp_location, $ourlocation . $name);
    }

    // Get category_id
    $sql1 = "SELECT id FROM category WHERE name = '$category_name'";
    $result1 = mysqli_query($conn, $sql1);

    if ($result1 && $result1->num_rows > 0) {
        $row = mysqli_fetch_assoc($result1);
        $category_id = $row['id'];

        // Insert post
        $sql2 = "INSERT INTO post (title, content, author_id, category_id, image)
                 VALUES ('$title', '$content', '$user_id', '$category_id', '$name')";
        $result2 = mysqli_query($conn, $sql2);

        if ($result2) {
            echo "<script>alert('✅ Post Inserted Successfully!'); window.location.href='dashboard.php';</script>";
        } else {
            echo "❌ Error inserting post: {$conn->error}";
        }
    } else {
        echo "⚠️ Category not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="insertpost.css">
    
</head>
<body>
   <div class="container">
       <form id="postForm" class="form" action="insertpost.php" method="post" enctype="multipart/form-data">
      <h2>Add New Blog Post ✍️</h2>
    <div class="form-group">
      <label class="form-label" for="title">Title</label>
      <input class="form-input" type="text" id="title" name="title" placeholder="Enter post title" required>
    </div>

    <div class="form-group">
      <label class="form-label" for="content">Content</label>
      <textarea class="form-textarea" id="content" name="content" rows="8" placeholder="Write your post..." required></textarea>
    </div>

    <div class="form-group">
      <label class="form-label" for="category">Category</label>
      <select class="form-select" id="category" name="category_name" required>
        <option value="" disabled selected hidden>Select Category</option>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <option value="<?php echo htmlspecialchars($row['name'], ENT_QUOTES); ?>">
            <?php echo htmlspecialchars($row['name']); ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="form-group">
      <label class="form-label" for="image">Image</label>
      <input class="form-file" type="file" id="image" name="image" accept="image/*">
    </div>

    <button class="btn btn-primary" type="submit" name="submit">Insert Post</button>
  </form>
</div>


</body>
</html>