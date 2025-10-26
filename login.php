<?php
session_start();
include("db_connect.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bank_id = trim($_POST['bank_id']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($bank_id) || empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $sql = "SELECT * FROM users WHERE email = ? AND bank_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $bank_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['first_name'] = $row['first_name'];
                $_SESSION['last_name'] = $row['last_name'];
                header("Location: viewingpage.php");
                exit;
            } else {
                $error = "Invalid credentials!";
            }
        } else {
            $error = "Invalid credentials!";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Evergreen - Login</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', sans-serif;
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    .left {
      width: 39%;
      background: #ebe8df;
      display: flex;
      flex-direction: column;
      padding: 0 80px;
      padding-top: 100px;
    }

    .logo {
      position: absolute;
      top: 30px;
      left: 30px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .logo img {
      width: 42px;
      height: 42px;
    }

    .logo-text {
      display: flex;
      flex-direction: column;
    }

    .logo-text .name {
      font-size: 15px;
      font-weight: 700;
      color: #0d3d38;
      letter-spacing: 0.3px;
    }

    .logo-text .tagline {
      font-size: 10px;
      color: #666;
      letter-spacing: 0.2px;
    }

    h2 {
      color: #0d3d38;
      font-size: 48px;
      font-weight: 400;
      margin-bottom: 50px;
      letter-spacing: -0.5px;
    }

    .input-wrapper {
      margin-bottom: 22px;
    }

    .input-label {
      font-size: 12px;
      color: #0d3d38;
      margin-bottom: 8px;
      display: block;
      font-weight: 400;
    }

    input {
      width: 100%;
      padding: 16px 18px;
      border: 1.5px solid #c5c1b3;
      border-radius: 10px;
      font-size: 13px;
      background: white;
      color: #333;
      transition: all 0.2s;
      font-family: inherit;
    }

    input::placeholder {
      color: #a8a499;
    }

    input:focus {
      outline: none;
      border-color: #0d3d38;
    }

    .password-container {
      position: relative;
    }

    .password-container input {
      padding-right: 50px;
    }

    .eye-icon {
      position: absolute;
      right: 18px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      width: 20px;
      height: 20px;
      background: none;
      border: none;
      padding: 0;
    }

    .forgot-link {
      text-align: right;
      margin-top: 8px;
      margin-bottom: 28px;
    }

    .forgot-link a {
      font-size: 11px;
      color: #0d3d38;
      text-decoration: none;
      font-weight: 500;
    }

    .forgot-link a:hover {
      text-decoration: underline;
    }

    .signin-btn {
      width: 100%;
      background: #0d3d38;
      color: white;
      padding: 15px;
      border: none;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      letter-spacing: 0.5px;
      transition: all 0.2s;
      margin-bottom: 32px;
    }

    .signin-btn:hover {
      background: #0a2d29;
    }

    .signup-text {
      text-align: center;
      font-size: 12px;
      color: #666;
    }

    .signup-text a {
      color: #0d3d38;
      text-decoration: none;
      font-weight: 600;
    }

    .signup-text a:hover {
      text-decoration: underline;
    }

    .right {
      width: 61%;
      background: linear-gradient(135deg, #0a3833 0%, #0d4a44 30%, #1a6b62 70%, #4d9d95 100%);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;
      padding: 10px;
      position: relative;
      overflow: hidden;
    }

    .circle-bg {
      position: absolute;
      border-radius: 50%;
    }

    .circle-1 {
      width: 700px;
      height: 700px;
      top: -250px;
      right: -200px;
      background: rgba(90, 140, 135, 0.25);
    }

    .circle-2 {
      width: 550px;
      height: 550px;
      bottom: -200px;
      left: -150px;
      background: rgba(60, 130, 125, 0.2);
    }

    .right-content {
      position: relative;
      z-index: 1;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      padding-left: 60px;
      width: 100%;
    }

    .welcome-text {
      font-size: 64px;
      font-weight: 300;
      color: white;
      margin-bottom: 8px;
      letter-spacing: 0.5px;
      text-align: left;
    }

    h1 {
      font-size: 64px;
      font-weight: 700;
      color: white;
      margin-bottom: 20px;
      letter-spacing: 1px;
      text-align: left;
    }

    .subtitle {
      font-size: 16px;
      color: white;
      margin-bottom: 80px;
      font-weight: 300;
      letter-spacing: 0.3px;
      text-align: left;
      opacity: 0.5;
    }

    .laptop-img {
      position: absolute;
      right: 0;
      top: 50%;
      left: 20%;
      transform: translateY(-50%) perspective(1000px) rotateY(-15deg);
      max-width: 1000px;
      width: 100%;
      filter: drop-shadow(0 35px 70px rgba(0, 0, 0, 0.5));
    }


    @media (max-width: 968px) {
      body {
        flex-direction: column;
      }

      .left, .right {
        width: 100%;
      }

      .left {
        padding: 60px 40px;
        height: auto;
      }

      .right {
        padding: 40px;
        min-height: 400px;
      }

      h2 {
        font-size: 36px;
      }

      h1 {
        font-size: 48px;
      }
    }
  </style>
</head>
<body>
  <div class="left">
    <div class="logo">
      <img src="images/loginlogo.png" alt="Logo">
      <div class="logo-text">
        <span class="name">EVERGREEN</span>
        <span class="tagline">Secure. Invest. Achieve</span>
      </div>
    </div>

    <h2>Log In</h2>

    <form method="POST">
      <div class="input-wrapper">
        <label class="input-label">Bank ID</label>
        <input type="text" name="bank_id" placeholder="Bank ID" required>
      </div>

      <div class="input-wrapper">
        <label class="input-label">Email</label>
        <input type="email" name="email" placeholder="example@gmail.com" required>
      </div>

      <div class="input-wrapper">
        <label class="input-label">Password</label>
        <div class="password-container">
          <input type="password" id="password" name="password" placeholder="Password" required>
          <button type="button" class="eye-icon" onclick="togglePassword()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </button>
        </div>
      </div>

      <div class="forgot-link">
        <a href="forgot_password.php">Forgot Password?</a>
      </div>

      <button type="submit" class="signin-btn">SIGN IN</button>
    </form>

    <div class="signup-text">
      Don't have an account? <a href="signup.php">Sign Up</a>
    </div>
  </div>

  <div class="right">
    <div class="circle-bg circle-1"></div>
    <div class="circle-bg circle-2"></div>
    
    <div class="right-content">
      <p class="welcome-text">Welcome to</p>
      <h1>EVERGREEN</h1>
      <p class="subtitle">Sign up to create an account!</p>
      <img src="images/laptop.png" alt="Laptop" class="laptop-img">
    </div>
  </div>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const type = passwordInput.type === 'password' ? 'text' : 'password';
      passwordInput.type = type;
    }
  </script>
</body>
</html>