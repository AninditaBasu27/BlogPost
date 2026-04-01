<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=>, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const popup = document.querySelector(".popup");
    const closeBtn = document.querySelector(".close-btn");

    // Close popup manually
    if (closeBtn) {
        closeBtn.addEventListener("click", () => {
            popup.style.opacity = "0";
            popup.style.transform = "translateX(120%)";
            setTimeout(() => popup.remove(), 500);
        });
    }

    // Auto close popup after 60 seconds
    setTimeout(() => {
        if (popup) {
            popup.style.opacity = "0";
            popup.style.transform = "translateX(120%)";
            setTimeout(() => popup.remove(), 500);
        }
    }, 60000); // 60 seconds
});
</script>

<body>
    <?php include 'nav.php'; ?>
    <div class="wrapper">
        <form action="login.php" method="post">
            <h1>Login</h1>
            <div class="input-box">
                <input type="email" name = "email" placeholder="Email" required>
                <i class='bx bxs-envelope' ></i>       
            </div>
            <div class="input-box">
                <input type="password" name ="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt' ></i>
            </div>
            <input type="submit" name="submit" value="Login" class="btn">

            <div class="register-link">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </form>
    </div>

    <script>
        const password = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', () => {
            if (password.type === 'password') {
                password.type = 'text';
                togglePassword.classList.replace('bx-show', 'bx-hide');
            } else {
                password.type = 'password';
                togglePassword.classList.replace('bx-hide', 'bx-show');
            }
        });
    </script>
</body>
</html>


<?php
    session_start();
    include "db.php";

    if (isset($_SESSION['user_id'])) {
    // Already logged in — show popup message
        echo "<div class='popup warning'>
                <span class='close-btn'>&times;</span>
                <p>You are already logged in! Please log out first.</p>
                <a href='logout.php'>Logout</a>
            </div>";
        exit(); // Stop further login code
    }

    if(isset($_POST['submit']))
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);//function to execute query
        if(!$result)
        {
            echo "Error: {$conn->error}";
        }
        else
        {
            
            if($result->num_rows > 0)
            {
                $row = mysqli_fetch_assoc($result);//fetch data stored as associative array
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] =$row['name'];
                $_SESSION['user_role'] = $row['role'];
                $_SESSION['user_email'] = $row['email'];
                echo "<div class='popup success'>
                        <span class='close-btn'>&times;</span>
                        <p>Login Successful!</p>
                        <a href='dashboard.php'>Go to Home</a>
                        </div>";
            }
            else
            {
                echo "<div class='popup error'>
                        <span class='close-btn'>&times;</span>
                        <p>Invalid Email or Password</p>
                        </div>";
            }
        }
    }

    
    ?>