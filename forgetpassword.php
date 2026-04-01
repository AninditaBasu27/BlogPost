<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot & Reset Password</title>
  <link rel="stylesheet" href="forgotpassword.css">
  <!-- Font Awesome for eye icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="container" id="container">
    <!-- Forgot Password Section -->
    <div id="forgot-section">
      <h2>Forgot Password</h2>
      <p>Enter your registered email address to reset your password.</p>
      <form id="forgotForm">
        <input type="email" id="email" placeholder="you@example.com" required>
        <button type="submit">Send Reset Link</button>
      </form>
      <div class="back">
        <a href="login.php">Back to login</a>
      </div>
    </div>

    <!-- Reset Password Section -->
    <div id="reset-section" class="hidden">
      <h2>Reset Password</h2>
      <p>Enter and confirm your new password below.</p>
      <form id="resetForm">
        <div class="password-field">
          <input type="password" id="newPassword" placeholder="New password" required>
          <i class="fa-solid fa-eye" id="toggleNewPass"></i>
        </div>

        <div class="password-field">
          <input type="password" id="confirmPassword" placeholder="Confirm password" required>
          <i class="fa-solid fa-eye" id="toggleConfirmPass"></i>
        </div>

        <button type="submit">Reset Password</button>
      </form>
      <div class="back">
        <a href="login.php">Back to login</a>
      </div>
    </div>
  </div>

  <script>
    const forgotForm = document.getElementById("forgotForm");
    const resetForm = document.getElementById("resetForm");
    const forgotSection = document.getElementById("forgot-section");
    const resetSection = document.getElementById("reset-section");

    // Handle Forgot Password
    forgotForm.addEventListener("submit", function(e){
      e.preventDefault();
      const email = document.getElementById("email").value.trim();

      if(email === ""){
        alert("Please enter your email!");
        return;
      }

      alert("A reset link has been sent to: " + email);
      forgotSection.classList.add("hidden");
      resetSection.classList.remove("hidden");
    });

    // Handle Reset Password
    resetForm.addEventListener("submit", function(e){
      e.preventDefault();
      const newPass = document.getElementById("newPassword").value;
      const confirmPass = document.getElementById("confirmPassword").value;

      if(newPass !== confirmPass){
        alert("Passwords do not match!");
        return;
      }

      alert("Password reset successful!");
      window.location.href = "login.php";
    });

    // Toggle Password Visibility
    const toggleNewPass = document.getElementById("toggleNewPass");
    const newPassword = document.getElementById("newPassword");
    const toggleConfirmPass = document.getElementById("toggleConfirmPass");
    const confirmPassword = document.getElementById("confirmPassword");

    toggleNewPass.addEventListener("click", () => {
      const type = newPassword.type === "password" ? "text" : "password";
      newPassword.type = type;
      toggleNewPass.classList.toggle("fa-eye-slash");
    });

    toggleConfirmPass.addEventListener("click", () => {
      const type = confirmPassword.type === "password" ? "text" : "password";
      confirmPassword.type = type;
      toggleConfirmPass.classList.toggle("fa-eye-slash");
    });
  </script>
</body>
</html>