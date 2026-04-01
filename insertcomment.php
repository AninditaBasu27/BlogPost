<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $post_id = intval($_POST['post_id']);
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];
    $user_comment = trim($_POST['comment']);

    if (!empty($user_comment)) {
        $sql = "INSERT INTO comments (post_id, username, email, comment) 
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $post_id, $user_name, $user_email, $user_comment);

        if ($stmt->execute()) {
            // Redirect back to the post page after successful comment
            header("Location: post.php?id=" . $post_id);
            exit;
        } else {
            echo "Error adding comment: " . $conn->error;
        }
    } else {
        echo "Comment cannot be empty!";
    }
}
?>
