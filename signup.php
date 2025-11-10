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
    $terms_accepted = isset($_POST['terms']) ? true : false;

    if (empty($first_name) || empty($middle_name) || empty($last_name) || 
        empty($address) || empty($city_province) || empty($email) || 
        empty($contact_number) || empty($birthday) || empty($password) || 
        empty($confirm_password)) {
        $error = "Please fill in all required fields.";
    } elseif (!$terms_accepted) {
        $error = "You must agree to the Terms and Conditions.";
    } elseif ($password !== $confirm_password) {
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
            
            // Store user data in session (NOT in database yet)
            $_SESSION['temp_registration'] = [
                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'last_name' => $last_name,
                'address' => $address,
                'city_province' => $city_province,
                'email' => $email,
                'contact_number' => $contact_number,
                'birthday' => $birthday,
                'password' => $hashed_password,
                'verification_code' => $verification_code,
                'bank_id' => $bank_id
            ];
            
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
      min-height: 100vh;
      overflow-x: hidden;
      overflow-y: auto;
      background: #f8f9fa;
    }

    .left {
      width: 45%;
      background: white;
      display: flex;
      flex-direction: column;
      padding: 40px 60px;
      padding-top: 120px;
      position: relative;
      box-shadow: 2px 0 30px rgba(0, 0, 0, 0.05);
      z-index: 2;
    }

    .logo {
      position: absolute;
      top: 30px;
      left: 30px;
      display: flex;
      align-items: center;
      gap: 12px;
      width: auto;
      transition: transform 0.3s ease;
    }

    .logo:hover {
      transform: scale(1.05);
    }

    .logo img {
      width: 48px;
      height: 48px;
      filter: drop-shadow(0 2px 8px rgba(13, 61, 56, 0.2));
    }

    .logo-text {
      display: flex;
      flex-direction: column;
    }

    .logo-text .name {
      font-size: 16px;
      font-weight: 700;
      color: #0d3d38;
      letter-spacing: 0.5px;
    }

    .logo-text .tagline {
      font-size: 10px;
      color: #666;
      letter-spacing: 0.3px;
      margin-top: 2px;
    }

    .back-container {
      position: absolute;
      top: 30px;
      right: 60px;
    }

    .back-link {
      font-size: 24px;
      text-decoration: none;
      color: #003631;
      transition: all 0.3s ease;
      padding: 10px 14px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(13, 61, 56, 0.05);
      backdrop-filter: blur(10px);
    }

    .back-link:hover {
      background: rgba(13, 61, 56, 0.1);
      transform: translateX(-4px);
    } 

    h2 {
      color: #0d3d38;
      font-size: 42px;
      font-weight: 600;
      margin-bottom: 10px;
      letter-spacing: -1px;
      text-align: center;
      background: linear-gradient(135deg, #0d3d38 0%, #1a6b62 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .subtitle {
      text-align: center;
      color: #777777ff;
      font-size: 14px;
      margin-bottom: 40px;
      font-weight: 400;
    }

    .alert {
      padding: 14px 18px;
      border-radius: 12px;
      margin-bottom: 24px;
      font-size: 13px;
      text-align: center;
      backdrop-filter: blur(10px);
      animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .alert.error {
      background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
      color: #dc3545;
      border: 1px solid rgba(220, 53, 69, 0.3);
    }

    .error-message {
      color: #dc3545;
      font-size: 13px;
      margin-top: 4px;
      display: none;
      font-weight: 400;
      line-height: 1.4;
    }

    .error-message.show {
      display: block;
      animation: fadeIn 0.2s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    input.error {
      border-color: #dc3545 !important;
      background: #fff5f5 !important;
    }

    .password-container {
      position: relative;
    }

    .eye-icon {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      width: 24px;
      height: 24px;
      background: none;
      border: none;
      padding: 0;
      font-size: 18px;
      color: #999;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .eye-icon:hover {
      color: #0d3d38;
      transform: translateY(-50%) scale(1.1);
    }

    .password-strength {
      margin-top: 10px;
      font-size: 12px;
    }

    .strength-bar {
      height: 6px;
      background: #e9ecef;
      border-radius: 10px;
      margin-top: 8px;
      overflow: hidden;
      box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .strength-fill {
      height: 100%;
      width: 0%;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      border-radius: 10px;
    }

    .strength-fill.weak {
      width: 33%;
      background: linear-gradient(90deg, #dc3545 0%, #e74c3c 100%);
    }

    .strength-fill.medium {
      width: 66%;
      background: linear-gradient(90deg, #ffc107 0%, #f39c12 100%);
    }

    .strength-fill.strong {
      width: 100%;
      background: linear-gradient(90deg, #28a745 0%, #20c997 100%);
    }

    .password-requirements {
      margin-top: 12px;
      padding: 14px;
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      border-radius: 12px;
      display: none;
      border: 1px solid #dee2e6;
    }

    .password-requirements.show {
      display: block;
      animation: slideDown 0.3s ease;
    }

    .requirement {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 8px;
      font-size: 12px;
      color: #666;
      transition: all 0.3s;
    }

    .requirement:last-child {
      margin-bottom: 0;
    }

    .requirement.met {
      color: #28a745;
    }

    .req-icon {
      font-size: 16px;
      font-weight: bold;
      transition: all 0.3s;
      width: 16px;
      height: 16px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #e9ecef;
      font-size: 10px;
    }

    .requirement.met .req-icon {
      background: #28a745;
      color: white;
    }

    .requirement.met .req-icon::before {
      content: '✓';
    }

    .password-match {
      margin-top: 10px;
      font-size: 12px;
      min-height: 18px;
      font-weight: 500;
    }

    #match-text {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    #match-text.match {
      color: #28a745;
    }

    #match-text.no-match {
      color: #dc3545;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
  width: 100%;
}

.form-row .input-wrapper {
  width: 100%;
}

.form-row .input-wrapper input {
  width: 100%;
}

.form-row .password-container {
  width: 100%;
}

.form-row .password-container input {
  width: 100%;
}

    .input-wrapper {
      display: flex;
      flex-direction: column;
    }

    .input-wrapper.full {
      grid-column: span 2;
    }

    .input-label {
      font-size: 13px;
      color: #0d3d38;
      margin-bottom: 8px;
      display: block;
      font-weight: 600;
      letter-spacing: 0.3px;
    }

    input {
      padding: 14px 18px;
      border: 2px solid #e9ecef;
      border-radius: 12px;
      font-size: 14px;
      background: #f8f9fa;
      color: #333;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      font-family: inherit;
    }

    input::placeholder {
      color: #adb5bd;
      font-size: 13px;
    }

    input:focus {
      outline: none;
      border-color: #0d3d38;
      background: white;
      box-shadow: 0 0 0 4px rgba(13, 61, 56, 0.1);
      transform: translateY(-2px);
    }

    input:hover:not(:focus) {
      border-color: #d0d5dd;
    }

    .checkbox-wrapper {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-top: 10px;
      justify-content: center;
      padding: 12px;
      background: #f8f9fa;
      border-radius: 12px;
    }

    .checkbox-wrapper input[type="checkbox"] {
      width: 18px;
      height: 18px;
      cursor: pointer;
      accent-color: #0d3d38;
    }

    .checkbox-wrapper label {
      font-size: 12px;
      color: #666;
      cursor: pointer;
      user-select: none;
    }

    .checkbox-wrapper a {
      color: #0d3d38;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s;
    }

    .checkbox-wrapper a:hover {
      color: #1a6b62;
      text-decoration: underline;
    }

    .create-btn {
      width: 100%;
      background: linear-gradient(135deg, #0d3d38 0%, #1a6b62 100%);
      color: white;
      padding: 16px;
      border: none;
      border-radius: 12px;
      font-size: 14px;
      font-weight: 700;
      cursor: pointer;
      letter-spacing: 1px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      margin-top: 12px;
      box-shadow: 0 4px 16px rgba(13, 61, 56, 0.2);
      text-transform: uppercase;
    }

    .create-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(13, 61, 56, 0.3);
    }

    .create-btn:active {
      transform: translateY(0);
    }

    .login-text {
      text-align: center;
      font-size: 13px;
      color: #666;
      margin-top: 24px;
      margin-bottom: 20px;
    }

    .login-text a {
      color: #0d3d38;
      text-decoration: none;
      font-weight: 700;
      transition: color 0.3s;
    }

    .login-text a:hover {
      color: #1a6b62;
      text-decoration: underline;
    }

    .right {
      width: 55%;
      background: linear-gradient(135deg, #0a3833 0%, #0d4a44 30%, #1a6b62 70%, #4d9d95 100%);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;
      padding: 60px;
      position: relative;
      overflow: hidden;
    }

    .circle-bg {
      position: absolute;
      border-radius: 50%;
      filter: blur(60px);
      opacity: 0.3;
    }

    .circle-1 {
      width: 800px;
      height: 800px;
      top: -300px;
      right: -250px;
      background: radial-gradient(circle, rgba(90, 140, 135, 0.4) 0%, transparent 70%);
      animation: float 20s ease-in-out infinite;
    }

    .circle-2 {
      width: 650px;
      height: 650px;
      bottom: -250px;
      left: -200px;
      background: radial-gradient(circle, rgba(60, 130, 125, 0.3) 0%, transparent 70%);
      animation: float 15s ease-in-out infinite reverse;
    }

    @keyframes float {
      0%, 100% { transform: translate(0, 0) scale(1); }
      50% { transform: translate(30px, 30px) scale(1.05); }
    }

    .right-content {
      position: relative;
      z-index: 1;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      width: 100%;
    }

    .welcome-text {
      font-size: 56px;
      font-weight: 300;
      color: white;
      margin-bottom: 8px;
      letter-spacing: -0.5px;
      text-align: left;
      opacity: 0.95;
      text-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
    }

    h1 {
      font-size: 72px;
      font-weight: 700;
      color: white;
      margin-bottom: 20px;
      letter-spacing: 2px;
      text-align: left;
      text-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
    }

    .right .subtitle {
      font-size: 18px;
      color: white;
      margin-bottom: 80px;
      font-weight: 300;
      letter-spacing: 0.5px;
      text-align: left;
      opacity: 0.8;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .laptop-img {
      position: absolute;
      right: -50px;
      top: 50%;
      left: 15%;
      transform: translateY(-50%) perspective(1200px) rotateY(-12deg);
      max-width: 1100px;
      width: 100%;
      filter: drop-shadow(0 40px 80px rgba(0, 0, 0, 0.4));
      animation: floatLaptop 6s ease-in-out infinite;
    }

    @keyframes floatLaptop {
      0%, 100% { transform: translateY(-50%) perspective(1200px) rotateY(-12deg); }
      50% { transform: translateY(-48%) perspective(1200px) rotateY(-12deg); }
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
      .left {
        width: 50%;
        padding: 40px 40px;
        padding-top: 100px;
      }

      .right {
        width: 50%;
      }

      h2 {
        font-size: 36px;
      }

      .welcome-text {
        font-size: 48px;
      }

      h1 {
        font-size: 60px;
      }
    }

    @media (max-width: 968px) {
      body {
        flex-direction: column;
      }

      .left {
        width: 100%;
        padding: 30px 30px;
        padding-top: 100px;
        box-shadow: none;
      }

      .right {
        width: 100%;
        padding: 60px 30px;
        min-height: 500px;
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

      .welcome-text {
        font-size: 40px;
      }

      h1 {
        font-size: 48px;
      }

      .right .subtitle {
        font-size: 16px;
      }

      .laptop-img {
        left: 10%;
        right: -30px;
      }

      .logo {
        left: 20px;
        top: 20px;
      }

      .back-container {
        right: 20px;
        top: 20px;
      }
    }

    @media (max-width: 480px) {
      .left {
        padding: 20px 20px;
        padding-top: 90px;
      }

      h2 {
        font-size: 28px;
        margin-bottom: 8px;
      }

      .left .subtitle {
        font-size: 13px;
        margin-bottom: 30px;
      }

      input {
        padding: 12px 16px;
        font-size: 13px;
      }

      input .password-container {
        width: 100%;
      }

      .create-btn {
        padding: 14px;
        font-size: 13px;
      }

      .welcome-text {
        font-size: 32px;
      }

      h1 {
        font-size: 40px;
      }

      .right {
        padding: 40px 20px;
        min-height: 400px;
      }
    }

    /* Smooth scroll behavior */
    html {
      scroll-behavior: smooth;
    }

    /* Loading animation for form submission */
    .create-btn.loading {
      position: relative;
      color: transparent;
    }

    .create-btn.loading::after {
      content: '';
      position: absolute;
      width: 20px;
      height: 20px;
      top: 50%;
      left: 50%;
      margin-left: -10px;
      margin-top: -10px;
      border: 3px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top-color: white;
      animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
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

    <div class="back-container">
      <a href="login.php" class="back-link">←</a>
    </div>

    <h2>Create an Account</h2>

    <?php if (!empty($error)): ?>
      <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" id="signupForm" novalidate>
      <div class="form-row">
        <div class="input-wrapper">
          <label class="input-label">First Name</label>
          <input type="text" name="first_name" id="first_name" placeholder="Juan" 
                 value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>">
          <span class="error-message" id="first_name_error">This field is required</span>
        </div>
        <div class="input-wrapper">
          <label class="input-label">Middle Name</label>
          <input type="text" name="middle_name" id="middle_name" placeholder="Andrade"
                 value="<?php echo isset($_POST['middle_name']) ? htmlspecialchars($_POST['middle_name']) : ''; ?>">
          <span class="error-message" id="middle_name_error">This field is required</span>
        </div>
      </div>

      <div class="input-wrapper full">
        <label class="input-label">Surname</label>
        <input type="text" name="last_name" id="last_name" placeholder="Dela Cruz" 
               value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>">
        <span class="error-message" id="last_name_error">This field is required</span>
      </div>

      <div class="form-row">
        <div class="input-wrapper" style="grid-column: span 2;">
          <label class="input-label">House number/Street/Brgy</label>
          <input type="text" name="address" id="address" placeholder="29 Simforosa st. Brgy. Nagkaisang" 
                 value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
          <span class="error-message" id="address_error">This field is required</span>
        </div>
      </div>

      <div class="form-row">
        <div class="input-wrapper">
          <label class="input-label">City/Province</label>
          <input type="text" name="city_province" id="city_province" placeholder="Metro Manila" 
                 value="<?php echo isset($_POST['city_province']) ? htmlspecialchars($_POST['city_province']) : ''; ?>">
          <span class="error-message" id="city_province_error">This field is required</span>
        </div>
        <div class="input-wrapper">
          <label class="input-label">Email</label>
          <input type="email" name="email" id="email" placeholder="example@gmail.com" 
                 value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
          <span class="error-message" id="email_error">This field is required</span>
        </div>
      </div>

      <div class="form-row">
        <div class="input-wrapper">
          <label class="input-label">Contact Number</label>
          <input type="tel" name="contact_number" id="contact_number" placeholder="0927 379 2682" 
                 value="<?php echo isset($_POST['contact_number']) ? htmlspecialchars($_POST['contact_number']) : ''; ?>">
          <span class="error-message" id="contact_number_error">This field is required</span>
        </div>
        <div class="input-wrapper">
          <label class="input-label">Birthday</label>
          <input type="text" name="birthday" id="birthday" placeholder="MM/DD/YEAR" onfocus="(this.type='date')" 
                 value="<?php echo isset($_POST['birthday']) ? htmlspecialchars($_POST['birthday']) : ''; ?>">
          <span class="error-message" id="birthday_error">This field is required</span>
        </div>
      </div>

      <div class="form-row">
        <div class="input-wrapper">
          <label class="input-label">Password</label>
          <div class="password-container">
            <input type="password" name="password" id="password" placeholder="Password">
            <button type="button" class="eye-icon" onclick="togglePassword('password')"></button>
          </div>
          <span class="error-message" id="password_error">This field is required</span>
          <div class="password-strength">
            <div class="strength-bar">
              <div class="strength-fill" id="strength-fill"></div>
            </div>
            <span id="strength-text" style="color: #666; font-size: 11px; margin-top: 4px; display: block;"></span>
          </div>
          <div class="password-requirements" id="password-requirements">
            <div class="requirement" id="req-length">
              <span class="req-icon"></span>
              <span class="req-text">At least 8 characters</span>
            </div>
            <div class="requirement" id="req-case">
              <span class="req-icon"></span>
              <span class="req-text">Upper & lowercase letters</span>
            </div>
            <div class="requirement" id="req-number">
              <span class="req-icon"></span>
              <span class="req-text">At least one number</span>
            </div>
            <div class="requirement" id="req-special">
              <span class="req-icon"></span>
              <span class="req-text">At least one special character</span>
            </div>
          </div>
        </div>
        <div class="input-wrapper">
          <label class="input-label">Confirm Password</label>
          <div class="password-container">
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
            <button type="button" class="eye-icon" onclick="togglePassword('confirm_password')"></button>
          </div>
          <span class="error-message" id="confirm_password_error">This field is required</span>
          <div class="password-match">
            <span id="match-text"></span>
          </div>
        </div>
      </div>

      <div class="checkbox-wrapper">
        <input type="checkbox" id="terms" name="terms">
        <label for="terms">I agree with <a href="#">Terms and Conditions</a></label>
      </div>
      <span class="error-message" id="terms_error" style="text-align: center;">You must agree to the Terms and Conditions</span>

      <button type="submit" class="create-btn">CREATE</button>
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

  <script>
// Toggle password visibility
function togglePassword(id) {
  const input = document.getElementById(id);
  const btn = input.nextElementSibling;
  if (input.type === 'password') {
    input.type = 'text';
    btn.textContent = '';
  } else {
    input.type = 'password';
    btn.textContent = '';
  }
}

// Password strength checker with requirements
const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirm_password');

if (password) {
  const requirements = document.getElementById('password-requirements');
  
  // Show requirements immediately when user starts typing
  password.addEventListener('input', function() {
    const passwordValue = this.value;
    
    // Show requirements panel when there's input
    if (passwordValue.length > 0) {
      requirements.classList.add('show');
    } else {
      requirements.classList.remove('show');
    }
    
    const strengthFill = document.getElementById('strength-fill');
    const strengthText = document.getElementById('strength-text');
    
    // Check individual requirements
    const reqLength = document.getElementById('req-length');
    const reqCase = document.getElementById('req-case');
    const reqNumber = document.getElementById('req-number');
    const reqSpecial = document.getElementById('req-special');
    
    let strength = 0;
    
    // Length check
    if (passwordValue.length >= 8) {
      reqLength.classList.add('met');
      strength++;
    } else {
      reqLength.classList.remove('met');
    }
    
    // Upper & lowercase check
    if (passwordValue.match(/[a-z]/) && passwordValue.match(/[A-Z]/)) {
      reqCase.classList.add('met');
      strength++;
    } else {
      reqCase.classList.remove('met');
    }
    
    // Number check
    if (passwordValue.match(/[0-9]/)) {
      reqNumber.classList.add('met');
      strength++;
    } else {
      reqNumber.classList.remove('met');
    }
    
    // Special character check
    if (passwordValue.match(/[^a-zA-Z0-9]/)) {
      reqSpecial.classList.add('met');
      strength++;
    } else {
      reqSpecial.classList.remove('met');
    }
    
    // Update strength bar and text
    strengthFill.className = 'strength-fill';
    if (passwordValue.length === 0) {
      strengthFill.style.width = '0%';
      strengthText.textContent = '';
    } else if (strength <= 1) {
      strengthFill.classList.add('weak');
      strengthText.textContent = 'Weak password';
      strengthText.style.color = '#dc3545';
    } else if (strength <= 2) {
      strengthFill.classList.add('medium');
      strengthText.textContent = 'Medium password';
      strengthText.style.color = '#ffc107';
    } else if (strength === 3) {
      strengthFill.classList.add('medium');
      strengthText.textContent = 'Good password';
      strengthText.style.color = '#17a2b8';
    } else {
      strengthFill.classList.add('strong');
      strengthText.textContent = 'Strong password';
      strengthText.style.color = '#28a745';
    }
    
    // Check password match if confirm field has value
    if (confirmPassword.value) {
      checkPasswordMatch();
    }
  });
}

// Password match checker
if (confirmPassword) {
  confirmPassword.addEventListener('input', checkPasswordMatch);
}

function checkPasswordMatch() {
  const passwordValue = password.value;
  const confirmValue = confirmPassword.value;
  const matchText = document.getElementById('match-text');
  
  if (confirmValue.length === 0) {
    matchText.textContent = '';
    matchText.className = '';
    return;
  }
  
  if (passwordValue === confirmValue) {
    matchText.textContent = '✓ Passwords match';
    matchText.className = 'match';
  } else {
    matchText.textContent = '✕ Passwords do not match';
    matchText.className = 'no-match';
  }
}

// Signup Form Validation
document.getElementById('signupForm').addEventListener('submit', function(e) {
  let isValid = true;
  
  // Required fields to validate
  const requiredFields = [
    'first_name',
    'middle_name',
    'last_name', 
    'address', 
    'city_province', 
    'email', 
    'contact_number', 
    'birthday', 
    'password', 
    'confirm_password'
  ];
  
  // Validate each required field
  requiredFields.forEach(fieldId => {
    const field = document.getElementById(fieldId);
    const errorMsg = document.getElementById(fieldId + '_error');
    
    if (!field.value.trim()) {
      field.classList.add('error');
      errorMsg.classList.add('show');
      isValid = false;
    } else {
      field.classList.remove('error');
      errorMsg.classList.remove('show');
    }
  });
  
  // Validate terms checkbox
  const terms = document.getElementById('terms');
  const termsError = document.getElementById('terms_error');
  if (!terms.checked) {
    termsError.classList.add('show');
    isValid = false;
  } else {
    termsError.classList.remove('show');
  }
  
  if (!isValid) {
    e.preventDefault();
    // Scroll to first error
    const firstError = document.querySelector('input.error');
    if (firstError) {
      firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
      firstError.focus();
    }
  }
});

// Remove error styling on input
document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], input[type="password"], input[type="date"]').forEach(input => {
  input.addEventListener('input', function() {
    if (this.value.trim()) {
      this.classList.remove('error');
      const errorMsg = document.getElementById(this.id + '_error');
      if (errorMsg) {
        errorMsg.classList.remove('show');
      }
    }
  });
});

// Remove terms error on checkbox change
document.getElementById('terms').addEventListener('change', function() {
  const termsError = document.getElementById('terms_error');
  if (this.checked) {
    termsError.classList.remove('show');
  }
});
</script>
</body>
</html>
