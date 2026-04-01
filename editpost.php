<?php
session_start();
include "db.php";
include "nav.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$logged_user_id = $_SESSION['user_id'];
$role = strtolower(trim($_SESSION['user_role'] ?? ''));

// ✅ If form submitted → update post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = intval($_POST['post_id']);
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = intval($_POST['category_id']);

    // ✅ Get existing post to check permissions and old image
    $stmt = $conn->prepare("SELECT author_id, image FROM post WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows !== 1) {
        die("❌ Post not found.");
    }

    $post = $res->fetch_assoc();
    $stmt->close();

    // ✅ Permission check
    if ($role !== 'admin' && (int)$post['author_id'] !== (int)$logged_user_id) {
        die("⛔ Not authorized to edit this post.");
    }

    // ✅ Handle image upload (optional)
    $image_name = $post['image'];
    if (!empty($_FILES['image']['name'])) {
        $tmp = $_FILES['image']['tmp_name'];
        $image_name = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($tmp, __DIR__ . "/image/" . $image_name);

        // Remove old image if exists
        if (!empty($post['image']) && file_exists(__DIR__ . "/image/" . $post['image'])) {
            unlink(__DIR__ . "/image/" . $post['image']);
        }
    }

    // ✅ Update post
    $upd = $conn->prepare("UPDATE post SET title=?, content=?, category_id=?, image=? WHERE id=?");
    $upd->bind_param("ssisi", $title, $content, $category_id, $image_name, $post_id);

    if ($upd->execute()) {
        echo "<script>
                alert('✅ Post updated successfully!');
                window.location.href = 'post.php?id={$post_id}';
              </script>";
        exit;
    } else {
        echo "⚠️ Error updating: " . $conn->error;
    }

    $upd->close();
    exit;
}

// ✅ If GET → show edit form
if (!isset($_GET['id'])) {
    header("Location: displaypost.php");
    exit;
}

$post_id = intval($_GET['id']);

// ✅ Load post data
$stmt = $conn->prepare("SELECT * FROM post WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows !== 1) {
    die("❌ Post not found.");
}
$post = $res->fetch_assoc();
$stmt->close();

// ✅ Permission check — only admins allowed to edit
if ($role !== 'admin') {
    echo "<script>
            alert('⛔ You are not allowed to edit posts.');
            window.location.href = 'displaypost.php';
          </script>";
    exit;
}


// ✅ Load categories for dropdown
$cats = $conn->query("SELECT * FROM category ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Post</title>
  <link rel="stylesheet" href="editpost.css">
</head>
<body>
  <div class="edit-container">
  <main class="edit-wrapper">
    <h2>Edit Post</h2>
    <form action="editpost.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="post_id" value="<?php echo (int)$post['id']; ?>">

      <label>Title</label>
      <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>

      <label>Content</label>
      <textarea name="content" rows="8" required><?php echo htmlspecialchars($post['content']); ?></textarea>

      <label>Category</label>
      <select name="category_id" required>
        <?php while ($c = mysqli_fetch_assoc($cats)) { ?>
          <option value="<?php echo $c['id']; ?>" <?php if ($c['id'] == $post['category_id']) echo 'selected'; ?>>
            <?php echo htmlspecialchars($c['name'] ?? $c['category_name']); ?>
          </option>
        <?php } ?>
      </select>

      <label>Image (optional)</label>
      <input type="file" name="image">

      <?php if (!empty($post['image'])): ?>
        <div class="current-image">
          <p>Current Image:</p>
          <img src="image/<?php echo $post['image']; ?>" alt="Current Image" width="200">
        </div>
      <?php endif; ?>

      <button type="submit" class="btn-update">Update Post</button>
    </form>
  </main>
  </div>
</body>
</html>
