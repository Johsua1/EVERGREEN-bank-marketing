<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Buffer output to prevent headers already sent error
ob_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer-7.0.0/src/Exception.php';
require 'PHPMailer-7.0.0/src/PHPMailer.php';
require 'PHPMailer-7.0.0/src/SMTP.php';
include("db_connect.php");

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);
    $address = trim($_POST['address']);
    $city_province = trim($_POST['city_province']);
    $email = trim($_POST['email']);
    $contact_number = trim($_POST['contact_number']);
    $birthday = $_POST['birthday'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $check_sql = "SELECT id FROM users WHERE email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            // Generate verification code and bank ID
            $verification_code = sprintf("%06d", rand(0, 999999));
            $bank_id = sprintf("%04d", mt_rand(0, 9999));
            
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert user with bank ID
            $sql = "INSERT INTO users (first_name, middle_name, last_name, address, city_province, email, contact_number, birthday, password, verification_code, bank_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssssss", $first_name, $middle_name, $last_name, $address, $city_province, $email, $contact_number, $birthday, $hashed_password, $verification_code, $bank_id);
            
            if ($stmt->execute()) {
                $user_id = $conn->insert_id;
                
                // Store temp session data
                $_SESSION['temp_user_id'] = $user_id;
                $_SESSION['temp_email'] = $email;
                $_SESSION['temp_bank_id'] = $bank_id;
                
                // Send verification email
                $mail = new PHPMailer(true);
                
                try {
                    // Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_OFF;
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'evrgrn.64@gmail.com';
                    $mail->Password = 'dourhhbymvjejuct';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
                    
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
                    $mail->Timeout = 30;
                    
                    // Recipients
                    $mail->setFrom('evrgrn.64@gmail.com', 'Evergreen Banking');
                    $mail->addAddress($email, $first_name . ' ' . $last_name);
                    
                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Welcome to Evergreen - Verify Your Email';
                    $mail->Body = "
                        <html>
                        <body style='font-family: Arial, sans-serif; padding: 20px;'>
                            <h2 style='color: #0d3d38;'>Welcome to Evergreen Banking!</h2>
                            <p>Thank you for creating an account. Here are your important details:</p>
                            
                            <div style='background: #f5f5f5; padding: 20px; border-radius: 10px; margin: 20px 0;'>
                                <h3 style='color: #0d3d38; margin-bottom: 10px;'>Bank ID: <span style='color: #1a6b62;'>{$bank_id}</span></h3>
                                <h3 style='color: #0d3d38;'>Verification Code:</h3>
                                <h1 style='color: #0d3d38; letter-spacing: 5px; font-size: 36px;'>{$verification_code}</h1>
                            </div>
                            
                            <p>Please keep your Bank ID safe as you'll need it for future transactions.</p>
                            <p>Use the verification code above to verify your email address.</p>
                            <p>This code will expire in 10 minutes.</p>
                            <p style='color: #666; font-size: 12px; margin-top: 20px;'>If you didn't create an account, please ignore this email.</p>
                        </body>
                        </html>
                    ";
                    
                    error_log("Attempting to send verification email to: " . $email);
                    $mail->send();
                    error_log("Verification email sent successfully to: " . $email);
                    
                    ob_end_clean();
                    header("Location: verify.php");
                    exit;
                    
                } catch (Exception $e) {
                    error_log("Failed to send verification email: " . $mail->ErrorInfo);
                    $_SESSION['email_error'] = "Failed to send verification code. Please try again.";
                    ob_end_clean();
                    header("Location: verify.php");
                    exit;
                }
            } else {
                $error = "Registration failed. Please try again.";
            }
            $stmt->close();
        }
        $check_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Evergreen - Sign Up</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', sans-serif;
      display: flex;
      min-height: 100vh; /* changed from height: 100vh */
      overflow-x: hidden; /* only hide horizontal overflow */
      overflow-y: auto; /* allow vertical scrolling */
    }


    .left {
      width: 39%;
      background: #ebe8df;
      display: flex;
      flex-direction: column;
      padding: 0 80px;
      padding-top: 100px;
      position: relative; /* ADD THIS - makes absolute children position relative to this container */
    }

    /* Logo stays on the left */
    .logo {
      position: absolute;
      top: 30px;
      left: 30px;
      display: flex;
      align-items: center;
      gap: 12px;
      width: auto;
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

    /* Back button - on the right side of LEFT panel */
    .back-container {
      position: absolute;
      top: 30px;
      right: 80px; /* Changed from 30px to align with left panel padding */
      display: flex;
      align-items: center;
    }

    .back-link {
      font-size: 28px;
      text-decoration: none;
      color: #003631;
      transition: all 0.2s ease;
      padding: 8px 12px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .back-link:hover {
      background: rgba(0, 54, 49, 0.1);
      transform: translateX(-2px);
    } 

    /* ADD THIS - h2 styles were missing */
    h2 {
      color: #0d3d38;
      font-size: 48px;
      font-weight: 400;
      margin-bottom: 50px;
      letter-spacing: -0.5px;
    }

    .alert {
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 20px;
      font-size: 13px;
      text-align: center;
    }

    .alert.error {
      background: #fee;
      color: #c33;
      border: 1px solid #fcc;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 18px;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    .input-wrapper {
      display: flex;
      flex-direction: column;
    }

    .input-wrapper.full {
      grid-column: span 2;
    }

    .input-label {
      font-size: 12px;
      color: #0d3d38;
      margin-bottom: 8px;
      display: block;
      font-weight: 400;
    }

    input {
      padding: 14px 16px;
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
      font-size: 12px;
    }

    input:focus {
      outline: none;
      border-color: #0d3d38;
    }

    .checkbox-wrapper {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-top: 8px;
      justify-content: center;
    }

    .checkbox-wrapper input[type="checkbox"] {
      width: 16px;
      height: 16px;
      cursor: pointer;
    }

    .checkbox-wrapper label {
      font-size: 11px;
      color: #666;
      cursor: pointer;
    }

    .checkbox-wrapper a {
      color: #0d3d38;
      text-decoration: underline;
      font-weight: 600;
    }

    .create-btn {
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
      margin-top: 12px;
    }

    .create-btn:hover {
      background: #0a2d29;
    }

    .login-text {
      text-align: center;
      font-size: 12px;
      color: #666;
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .login-text a {
      color: #0d3d38;
      text-decoration: none;
      font-weight: 600;
    }

    .login-text a:hover {
      text-decoration: underline;
    }

    .right {
      width: 61%;
      background: linear-gradient(135deg, #0a3833 0%, #0d4a44 30%, #1a6b62 70%, #4d9d95 100%);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;
      padding: 60px;
      position: fixed; /* changed from relative */
      right: 0;
      top: 0;
      height: 100vh;
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
      font-size: 38px;
      font-weight: 300;
      color: white;
      margin-bottom: 8px;
      letter-spacing: 0.5px;
      text-align: left;
    }

    h1 {
      font-size: 68px;
      font-weight: 700;
      color: white;
      margin-bottom: 20px;
      letter-spacing: 1px;
      text-align: left;
    }

    .subtitle {
      font-size: 13px;
      color: white;
      margin-bottom: 80px;
      font-weight: 300;
      letter-spacing: 0.3px;
      text-align: left;
    }

    .laptop-img {
      position: absolute;
      right: 80px;
      top: 50%;
      transform: translateY(-50%) perspective(1000px) rotateY(-15deg);
      max-width: 460px;
      width: 100%;
      filter: drop-shadow(0 35px 70px rgba(0, 0, 0, 0.5));
    }

    @media (max-width: 968px) {
      body {
        flex-direction: column;
        height: auto;
      }

      .left {
        width: 100%;
        padding: 60px 40px;
      }

      .right {
        width: 100%;
        padding: 40px;
        min-height: 400px;
      }

      .form-row {
        grid-template-columns: 1fr;
      }

      .input-wrapper.full {
        grid-column: span 1;
      }

      h2 {
        font-size: 32px;
      }

      h1 {
        font-size: 48px;
      }
    }
  </style>
</head>
<body>
  <div class="left">
  <!-- Logo on the left -->
  <div class="logo">
    <img src="images/loginlogo.png" alt="Logo">
    <div class="logo-text">
      <span class="name">EVERGREEN</span>
      <span class="tagline">Secure. Invest. Achieve</span>
    </div>
  </div>

  <!-- ADD THIS: Back button on the right -->
  <div class="back-container">
    <a href="viewing.php" class="back-link">←</a>
  </div>

  <h2>Create an Account</h2>

    <?php if (!empty($error)): ?>
      <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-row">
        <div class="input-wrapper">
          <label class="input-label">First Name</label>
          <input type="text" name="first_name" placeholder="Juan" required>
        </div>
        <div class="input-wrapper">
          <label class="input-label">Middle Name</label>
          <input type="text" name="middle_name" placeholder="Andrade">
        </div>
      </div>

      <div class="input-wrapper full">
        <label class="input-label">Surname</label>
        <input type="text" name="last_name" placeholder="Dela Cruz" required>
      </div>

      <div class="form-row">
        <div class="input-wrapper" style="grid-column: span 2;">
          <label class="input-label">House number/Street/Brgy</label>
          <input type="text" name="address" placeholder="29 Simforosa st. Brgy. Nagkaisang" required>
        </div>
      </div>

      <div class="form-row">
        <div class="input-wrapper">
          <label class="input-label">City/Province</label>
          <input type="text" name="city_province" placeholder="Metro Manila" required>
        </div>
        <div class="input-wrapper">
          <label class="input-label">Email</label>
          <input type="email" name="email" placeholder="example@gmail.com" required>
        </div>
      </div>

      <div class="form-row">
        <div class="input-wrapper">
          <label class="input-label">Contact Number</label>
          <input type="tel" name="contact_number" placeholder="0927 379 2682" required>
        </div>
        <div class="input-wrapper">
          <label class="input-label">Birthday</label>
          <input type="text" name="birthday" placeholder="MM/DD/YEAR" onfocus="(this.type='date')" required>
        </div>
      </div>

      <div class="form-row">
        <div class="input-wrapper">
          <label class="input-label">Password</label>
          <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="input-wrapper">
          <label class="input-label">Confirm Password</label>
          <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        </div>
      </div>

      <button type="submit" class="create-btn">CREATE</button>

      <div class="checkbox-wrapper">
        <input type="checkbox" id="terms" required>
        <label for="terms">I agree with <a href="#">Terms and Conditions</a></label>
      </div>
    </form>

    <div class="login-text">
      Already have an account? <a href="login.php">Log In</a>
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
</body>
</html>