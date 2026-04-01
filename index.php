<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome | BlendUp</title>
  <style>
    nav {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    padding: 10px 20px;
    background: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    }
        /* Logo */
    .logo {
    display: flex;
    align-items: flex-start;
    justify-self: flex-start;
    gap: 8px;
    }

    .logo img {
    width: 38px;
    height: 38px;
    }

    .logo h2 {
    font-size: 22px;
    font-weight: 700;
    color: #5a1f1f;
    }

    /* Page base */
    body {
      font-family: "Poppins", Arial, sans-serif;
      margin: 0;
      padding: 0;
      height: 100vh;
      background: url('./source/home.jpeg') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;;
      align-items: center;
      color: #213b14ff;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
    }

    /* Welcome text */
    p {
      text-align: center;
      font-size: 50px;
      background: transparent;
      padding: 30px 50px;
      border-radius: 20px;
      margin-right: 100px;
    }

    /* Link button */
    a {
      display: inline-block;
      text-decoration: none;
      border: none;
      background: linear-gradient(90deg, #667eea, #764ba2);
      color: #fff;
      border-radius: 25px;
      padding: 12px 25px;
      font-weight: bold;
      font-size: 22px;
      /* margin-top: 10px; */
      transition: all 0.3s ease;
    }

    /* Hover effect */
    a:hover {
      background: linear-gradient(90deg, #5a67d8, #6b46c1);
      transform: scale(1.05);
    }
  </style>
</head>
<body>
    <nav>
     <div class="logo">
      <img src="./source/logo.png" alt="logo">
      <h2><b>BlogVerse</b></h2>
    </div>
    </nav>

  <p>
    Welcome to <strong>BlogVerse!🌏</strong> <br><br>
    <a href="dashboard.php">Tap here to View the site</a>
  </p>

</body>
</html>
