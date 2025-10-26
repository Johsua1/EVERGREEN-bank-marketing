<?php
    session_start([
       'cookie_httponly' => true,
       'cookie_secure' => isset($_SERVER['HTTPS']),
       'use_strict_mode' => true
    ]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Privacy Policy</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Kulim+Park:ital,wght@0,200;0,300;0,400;0,600;0,700;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
  <style>
    /* General */
    * {
      font-family: "Inter", sans-serif;
      color: white;
    }

    body {
        background: linear-gradient(to bottom, #005a52, #8be1d4);
        height: 200%;
    }

    h1, h2, h3, h4, h5, h6, p {
      margin: 0;
      padding: 0;
    }

    /* Navigation Bar */
    nav {
      font-family: "Kulim Park", sans-serif; 
      display: flex;
      gap: 10px;
      position: sticky;
      top: 0;
    }

    nav img {
        width: 3.5%;
        height: 50%;
        border-radius: 50%;
    }

    .main-container {
      margin-top: 20px;
      padding-right: 10px;
      background: linear-gradient(to bottom, #E8FDF8, #9CE7D8);
      border-radius: 15px;
      padding: 20px;
      width: 80%;
      text-align: center;
    }

    /* Main Contents */
    main {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px;
      text-align: center;
      gap: 20px;
    }

    .heading, .sub-heading {
      font-family: "Kulim Park", sans-serif;
    } 

    .heading {
      font-size: 36px;
      font-weight: 700;
    }

    .sub-heading {
      font-size: 10px;
      font-weight: 400;
      max-width: 600px;
    }

    /* Privacy Contents */
    .main-container {
      display: flex;
      gap: 20px;
      text-align: left;
      color: #005a52;
      padding: 40px;
      flex-direction: column;
    }

    .main-wrap {
      display: flex;
      gap: 40px;
    }

    .left, .right {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 30px;
    }

    .prv-title, .prv-desc {
      font-family: "Kulim Park", sans-serif;
    }

    .prv-title {
      font-size: 15px;
      font-weight: 600;
      margin-bottom: 10px;
      color: #005a52;
    }

    .prv-desc {
      font-size: 12px;
      font-weight: 400;
      line-height: 1.5;
      color: #005a52;
    }

    /* Social Media */
    .social-links {
            display: flex;
            justify-content: flex-end;
            gap: 1.5rem;
            margin-top: 2rem;
            padding-right: 2rem;
        }

        .social-links a {
            color: #003631;
            font-size: 1.3rem;
            text-decoration: none;
            transition: color 0.3s;
        }

        .social-links a:hover {
            color: #F1B24A;
        }
  </style>
</head>
<body>
    <nav>
      <img src="images/icon.png" alt="logo" class="logo">
      <div class="nav-wrap">
        <h2 class="web-title">EVERGREEN</h2>
        <p class="motto">Secure, Invest, Achieve</p>
      </div>
  </nav>

    <main>
      <h1 class="heading">Privacy Policy</h1>
      <p class="sub-heading">At Evergreen we value your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, and safeguard your data when you use our website and services.</p>
    <div class="main-container">
      <div class="main-wrap">
        <div class="left">
          <div class="wrap">
            <h2 class="prv-title">1. Information We Collect</h2>
            <p class="prv-desc">At Evergreen we value your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, and safeguard your data when you use our website and services.</p>
          </div>

          <div class="wrap">
            <h2 class="prv-title">2. How We Use Your Information</h2>
            <p class="prv-desc">Your information is used to:</p>
            <p class="prv-desc">• Process and verify loan applications</p>
            <p class="prv-desc">• Provide updates on marketing offers and promotions</p>
            <p class="prv-desc">• Improve our website and services</p>
            <p class="prv-desc">• Communicate important account information</p>
          </div>

          <div class="wrap">
            <h2 class="prv-title">3. Data Protection</h2>
            <p class="prv-desc">We use secure systems and encryption to protect your data from unauthorized access, loss, or misuse. Only authorized personnel have access to your information.</p>
          </div>
        </div>
        <div class="right">
            <div class="wrap">
              <h2 class="prv-title">4. Information We Collect</h2>
              <p class="prv-desc">We do not sell or share your personal data with third parties, except when required by law or to process your loan securely.</p>
            </div>

            <div class="wrap">
              <h2 class="prv-title">5. Your Rights</h2>
              <p class="prv-desc">You have the right to access, update, or request deletion of your personal information. You may also opt out of marketing communications at any time.</p>
            </div>

            <div class="wrap">
              <h2 class="prv-title">6. Contact Us</h2>
              <p class="prv-desc">If you have questions about this Privacy Policy, please contact us at <a href="mailto:example@gmail.com">example@gmail.com</a>.</p>
            </div>
        </div>
      </div>
      <div class="soc-icons-container">
        <div class="social-links">
                    <a href="#" aria-label="Facebook">f</a>
                    <a href="#" aria-label="Twitter">𝕏</a>
                    <a href="#" aria-label="Instagram">📷</a>
                    <a href="#" aria-label="LinkedIn">in</a>
                </div>
      </div>
    </div>
  </main>
</body>
</html>