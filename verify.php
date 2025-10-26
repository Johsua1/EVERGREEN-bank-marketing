<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer-7.0.0/src/Exception.php';
require 'PHPMailer-7.0.0/src/PHPMailer.php';
require 'PHPMailer-7.0.0/src/SMTP.php';

session_start();
include("db_connect.php");

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user just signed up
if (!isset($_SESSION['temp_user_id'])) {
    header("Location: signup.php");
    exit;
}

$error = "";
$success = "";

// Check if there was an email error from signup
if (isset($_SESSION['email_error'])) {
    $error = $_SESSION['email_error'];
    unset($_SESSION['email_error']); // Clear it after displaying
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['verify'])) {
        $entered_code = trim($_POST['code1'] . $_POST['code2'] . $_POST['code3'] . $_POST['code4'] . $_POST['code5'] . $_POST['code6']);
        $user_id = $_SESSION['temp_user_id'];
        
        // Get user's verification code from database
        $sql = "SELECT verification_code, email FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            if ($entered_code === $row['verification_code']) {
                // Mark user as verified
                $update_sql = "UPDATE users SET is_verified = 1 WHERE id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("i", $user_id);
                $update_stmt->execute();
                $update_stmt->close();
                
                // Clear temp session and redirect to login
                unset($_SESSION['temp_user_id']);
                unset($_SESSION['temp_email']);
                echo "<script>alert('Account verified successfully!'); window.location.href='login.php';</script>";
                exit;
            } else {
                $error = "Invalid verification code. Please try again.";
            }
        }
        $stmt->close();
    } elseif (isset($_POST['resend'])) {
        // Generate new verification code
        $new_code = sprintf("%06d", rand(0, 999999));
        $user_id = $_SESSION['temp_user_id'];
        
        // Update verification code in database
        $sql = "UPDATE users SET verification_code = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_code, $user_id);
        
        if ($stmt->execute()) {
            // Get user email
            $query = "SELECT email, first_name, last_name FROM users WHERE id = ?";
            $get_stmt = $conn->prepare($query);
            $get_stmt->bind_param("i", $user_id);
            $get_stmt->execute();
            $user = $get_stmt->get_result()->fetch_assoc();

            // Send new verification code via email
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'nambio.johsua.agustin@gmail.com';
                $mail->Password = 'tgpfxpvmgdihdtux'; // Your Gmail app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                
                // Additional SMTP settings for reliability
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                $mail->Timeout = 30; // Longer timeout
                
                // Recipients
                $mail->setFrom('nambio.johsua.agustin@gmail.com', 'Evergreen Banking');
                $mail->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
                
                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Evergreen - New Verification Code';
                $mail->Body = "
                    <html>
                    <body style='font-family: Arial, sans-serif; padding: 20px;'>
                        <h2 style='color: #0d3d38;'>New Verification Code</h2>
                        <p>You requested a new verification code.</p>
                        <h1 style='color: #0d3d38; letter-spacing: 5px; font-size: 36px;'>{$new_code}</h1>
                        <p>This code will expire in 10 minutes.</p>
                        <p style='color: #666; font-size: 12px;'>If you didn't request this code, please ignore this email.</p>
                    </body>
                    </html>
                ";
                
                // Log before sending
                error_log("Attempting to send email to: " . $user['email']);
                
                $mail->send();
                $success = "A new verification code has been sent to your email.";
                
                // Log success
                error_log("Email sent successfully to: " . $user['email']);
            } catch (Exception $e) {
                $error = "Could not send email. Mailer Error: {$mail->ErrorInfo}";
                // Log error
                error_log("Failed to send email: " . $mail->ErrorInfo);
            }

            $get_stmt->close();
        }
        $stmt->close();
    }
}

$email = $_SESSION['temp_email'] ?? '';
?>

<!-- Rest of your HTML remains unchanged -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Evergreen - Verification</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', sans-serif;
      background: #ebe8df;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px 20px;
    }

    .logo-container {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 60px;
    }

    .logo-container img {
      width: 48px;
      height: 48px;
    }

    .logo-text {
      display: flex;
      flex-direction: column;
    }

    .logo-text .name {
      font-size: 16px;
      font-weight: 700;
      color: #0d3d38;
      letter-spacing: 0.3px;
    }

    .logo-text .tagline {
      font-size: 10px;
      color: #666;
      letter-spacing: 0.2px;
    }

    .verify-container {
      background: white;
      padding: 50px 60px;
      border-radius: 20px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      max-width: 600px;
      width: 100%;
      text-align: center;
    }

    h2 {
      color: #0d3d38;
      font-size: 32px;
      font-weight: 600;
      margin-bottom: 40px;
      letter-spacing: -0.5px;
    }

    .code-inputs {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-bottom: 30px;
    }

    .code-input {
      width: 70px;
      height: 80px;
      border: 1.5px solid #c5c1b3;
      border-radius: 12px;
      font-size: 32px;
      font-weight: 600;
      text-align: center;
      color: #0d3d38;
      transition: all 0.2s;
      background: #faf9f6;
    }

    .code-input:focus {
      outline: none;
      border-color: #0d3d38;
      background: white;
    }

    .info-text {
      font-size: 13px;
      color: #666;
      margin-bottom: 35px;
      line-height: 1.6;
    }

    .info-text .email {
      color: #0d3d38;
      font-weight: 600;
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

    .alert.success {
      background: #efe;
      color: #3c3;
      border: 1px solid #cfc;
    }

    .confirm-btn {
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
      margin-bottom: 25px;
    }

    .confirm-btn:hover {
      background: #0a2d29;
    }

    .confirm-btn:disabled {
      background: #ccc;
      cursor: not-allowed;
    }

    .resend-section {
      font-size: 12px;
      color: #666;
    }

    .resend-section .resend-link {
      color: #0d3d38;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      border: none;
      background: none;
      padding: 0;
      font-family: inherit;
      font-size: inherit;
    }

    .resend-section .resend-link:hover {
      text-decoration: underline;
    }

    .timer {
      color: #999;
      font-size: 11px;
      margin-top: 5px;
    }

    @media (max-width: 768px) {
      .verify-container {
        padding: 40px 30px;
      }

      h2 {
        font-size: 28px;
      }

      .code-inputs {
        gap: 10px;
      }

      .code-input {
        width: 50px;
        height: 60px;
        font-size: 24px;
      }
    }
  </style>
</head>
<body>
  <div class="logo-container">
    <img src="images/loginlogo.png" alt="Logo">
    <div class="logo-text">
      <span class="name">EVERGREEN</span>
      <span class="tagline">Secure. Invest. Achieve</span>
    </div>
  </div>

  <div class="verify-container">
    <h2>Verification Code</h2>

    <?php if (!empty($error)): ?>
      <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
      <div class="alert success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" id="verifyForm">
      <div class="code-inputs">
        <input type="text" class="code-input" name="code1" maxlength="1" pattern="[0-9]" required autocomplete="off">
        <input type="text" class="code-input" name="code2" maxlength="1" pattern="[0-9]" required autocomplete="off">
        <input type="text" class="code-input" name="code3" maxlength="1" pattern="[0-9]" required autocomplete="off">
        <input type="text" class="code-input" name="code4" maxlength="1" pattern="[0-9]" required autocomplete="off">
        <input type="text" class="code-input" name="code5" maxlength="1" pattern="[0-9]" required autocomplete="off">
        <input type="text" class="code-input" name="code6" maxlength="1" pattern="[0-9]" required autocomplete="off">
      </div>

      <p class="info-text">
        We've sent a 6-digit verification code to <span class="email"><?= htmlspecialchars($email) ?></span>.<br>
        Please enter the code above to continue.
      </p>

      <button type="submit" name="verify" class="confirm-btn">CONFIRM</button>
    </form>

    <div class="resend-section">
      Didn't receive the code?
      <form method="POST" style="display: inline;">
        <button type="submit" name="resend" class="resend-link" id="resendBtn">Resend Code</button>
      </form>
      <span id="timerText"></span>
      <div class="timer" id="timer"></div>
    </div>
  </div>

  <script>
    // Auto-focus and move to next input
    const inputs = document.querySelectorAll('.code-input');
    
    inputs.forEach((input, index) => {
      input.addEventListener('input', (e) => {
        if (e.target.value.length === 1 && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }
      });

      input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !e.target.value && index > 0) {
          inputs[index - 1].focus();
        }
      });

      // Only allow numbers
      input.addEventListener('keypress', (e) => {
        if (!/[0-9]/.test(e.key)) {
          e.preventDefault();
        }
      });

      // Handle paste
      input.addEventListener('paste', (e) => {
        e.preventDefault();
        const pastedData = e.clipboardData.getData('text').slice(0, 6);
        const digits = pastedData.match(/\d/g);
        
        if (digits) {
          digits.forEach((digit, i) => {
            if (inputs[i]) {
              inputs[i].value = digit;
            }
          });
          if (digits.length < 6) {
            inputs[digits.length].focus();
          }
        }
      });
    });

    // Auto-focus first input
    inputs[0].focus();

    // Resend timer
    let timeLeft = 30;
    const resendBtn = document.getElementById('resendBtn');
    const timer = document.getElementById('timer');
    const timerText = document.getElementById('timerText');

    function startTimer() {
      resendBtn.disabled = true;
      resendBtn.style.color = '#ccc';
      resendBtn.style.cursor = 'not-allowed';
      
      const interval = setInterval(() => {
        timeLeft--;
        timer.textContent = `(You can request a new code in ${timeLeft} seconds)`;
        timerText.textContent = '';
        
        if (timeLeft <= 0) {
          clearInterval(interval);
          resendBtn.disabled = false;
          resendBtn.style.color = '#0d3d38';
          resendBtn.style.cursor = 'pointer';
          timer.textContent = '';
          timeLeft = 30;
        }
      }, 1000);
    }

    // Start timer on page load
    startTimer();

    // Restart timer when resend is clicked
    resendBtn.addEventListener('click', () => {
      if (!resendBtn.disabled) {
        startTimer();
      }
    });
  </script>
</body>
</html> 
