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
  <title>FaQs</title>
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
        height: 100vh;
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
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
    }

    .heading, .sub-heading {
      font-family: "Kulim Park", sans-serif;
      font-weight: 400;
    }

    .sub-heading {
      font-size: 15px;
    }

    .left {
      display: flex;
      flex-direction: column;
      gap: 10px;
      align-self: center;
    }

    .right {
      background: linear-gradient(to bottom, #E8FDF8, #9CE7D8);
      border-radius: 15px;
      padding: 50px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    hr {
      border-top: 1px solid #ccc;
      width: 100%;
    }

    .faq-wrap {
      display: flex;
      flex-direction: column;
      gap: 10px; 
    }

    .faq-question {
      color: #005a52;
      font-weight: 500;
      font-family: "Kulim Park", sans-serif;
    }

    .faq-answer {
      color: black;
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
    <div class="main-container">
      <div class="left">
        <h1 class="heading">Frequently Asked Questions</h1>
        <h3 class="sub-heading">Find quick answers to common questions about our banking services, accounts, and digital tools.</h3>
      </div>
      <div class="right">
        <div class="faq-wrap">
          <h2 class="faq-question">How long does it take to get loan approval?</h2>
          <p class="faq-answer">
            Loan approval usually takes 1–3 business days after submitting all required documents. You’ll receive a notification once your application has been reviewed.
          </p>
        </div>
        <hr>
        <div class="faq-wrap">
          <h2 class="faq-question">Is my personal information safe when applying online?</h2>
        </div>
        <hr>
        <div class="faq-wrap">
          <h2 class="faq-question">How do I contact customer support for loan inquiries?</h2>
        </div>
        <hr>
        <div class="faq-wrap">
          <h2 class="faq-question">Is my personal information safe when applying online?</h2>
        </div>
    </div>
  </main>
</body>
</html>