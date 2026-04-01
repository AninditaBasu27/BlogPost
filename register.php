<?php
session_start();
include "db.php";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // ✅ Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $checkResult = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($checkResult) > 0) {
        // ⚠️ Email already exists → show popup
        echo "<script>alert('This email is already registered! Please use another email.');</script>";
    } else {
        // ✅ Insert new user
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>alert('User Registered Successfully!');</script>";
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;
            echo "<script>window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Error: {$conn->error}');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="register.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <?php include 'nav.php';?>
  <div class="container">
    <h1>Create Account</h1>
    <p>Join us by filling in the details below.</p>

    <!-- ✅ Added method and action -->
    <form id="registerForm" method="POST" action="register.php">

      <div class="input-field right-icon">
        <input type="text" id="fullname" name="name" placeholder="Full Name" required>
        <i class="fa-solid fa-user"></i>
      </div>

      <div class="input-field right-icon">
        <input type="email" id="email" name="email" placeholder="Email Address" required>
        <i class="fa-solid fa-envelope"></i>
      </div>

      <div class="input-field right-icon">
        <select id="role" name="role" class="role" required>
          <option value="" disabled selected>Select Your Role</option>
          <option value="admin">Admin</option>
          <!-- <option value="author">Author</option> -->
          <option value="subscriber">Subscriber</option>
        </select>
      </div>

      <div class="password-field right-icon">
        <input type="password" id="password" name="password" placeholder="Password" required>
        <i class="fa-solid fa-eye" id="togglePassword"></i>
      </div>

      <div class="password-field right-icon">
        <input type="password" id="confirmPassword" placeholder="Confirm Password" required>
        <i class="fa-solid fa-eye" id="toggleConfirmPassword"></i>
      </div>

      <!-- ✅ Submit button has name="submit" for PHP -->
      <button type="submit" name="submit">Register</button>
    </form>

    <div class="back">
      <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
  </div>

  <script>
    // ✅ Password visibility toggle
    document.getElementById("togglePassword").addEventListener("click", () => {
      const passwordInput = document.getElementById("password");
      const type = passwordInput.type === "password" ? "text" : "password";
      passwordInput.type = type;
      event.target.classList.toggle("fa-eye-slash");
    });

    document.getElementById("toggleConfirmPassword").addEventListener("click", () => {
      const confirmPasswordInput = document.getElementById("confirmPassword");
      const type = confirmPasswordInput.type === "password" ? "text" : "password";
      confirmPasswordInput.type = type;
      event.target.classList.toggle("fa-eye-slash");
    });
  </script>
</body>
</html>
