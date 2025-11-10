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
    <title>Evergreen Bank - Banking that grows with you</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background: #003631;
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        nav span {
            font-size: 24px;
        }

        nav span a {
            color: white;
            text-decoration: none;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: transparent; /* was #F1B24A */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            overflow: hidden;
        }

        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain; /* change from cover -> contain */
            object-position: center;
            display: block;
            border-radius: 50%;
            background: transparent;
        }

        .nav-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-login {
            background: transparent;
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .btn-login:hover {
            background: rgba(255,255,255,0.1);
        }

        .btn-primary {
            background: #f5a623;
            color: #0d4d4d;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .btn-primary:hover {
            background: #e69610;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #003631 0%, #003631 100%);
            padding: 3rem 5% 4rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
            min-height: 90vh;
        }

        .hero-content h1 {
            color: white;
            font-size: 4rem;
            margin-bottom: 1.6rem;
            line-height: 1.2;
        }

        .hero-content h1 .highlight {
            color: #F1B24A;
        }

        .hero-content p {
            color: rgba(255,255,255,0.9);
            font-size: 1.5rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: bold;
            padding: 1rem;
            font-size: 1rem;
        }

        .btn-secondary:hover {
            background: rgba(255,255,255,0.1);
            background-color: #FAF7EF;
            color: #003631;
            font-weight: bold;
        }

        .hero-card {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            color: white;
            margin: 0 auto;
            overflow: hidden;
        }

        .hero-card::before,
        .hero-card::after {
           content: "";
           position: absolute;
           background: #F1B24A;
           border-radius: 50%;
           z-index: 0;
           opacity: 0.2;
           transition: all 0.3s ease;
        }

        /* Top-left shape */
        .hero-card::before {
           top: -11%;
           left: 90%;
           width: 25%;
           height: 25%;
        }

        /* Bottom-right shape */
        .hero-card::after {
           bottom: -10%;
           right: 90%;
           width: 20%;
           height: 20%;
        }

        .hero-image {
            width: 100%;
            height: 300px;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            z-index: 1000;
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
            
        }

        .hero-card h3 {
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        .hero-card p {
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }

        /* Financial Solutions Section */
        .solutions {
            padding: 5rem 5%;
            background: #f5f5f5;
        }

        .solutions h2 {
            text-align: center;
            font-size: 2.5rem;
            color: #0d4d4d;
            margin-bottom: 1rem;
        }

        .solutions-intro {
            text-align: center;
            color: #666;
            max-width: 600px;
            margin: 0 auto 3rem;
            line-height: 1.6;
        }

        .solutions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .solution-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease-out, box-shadow 0.3s;
            cursor: pointer;
        }

        .solution-card:hover, .loan-card:hover {
            transform: scale(1.1);
            transition: 0.3s ease-in;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .solution-icon {
            width: 50px;
            height: 50px;
            background: #f0f0f0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .solution-card h3 {
            color: #0d4d4d;
            margin-bottom: 1rem;
        }

        .solution-card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .learn-more {
            color: #003631;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
        }

        .btn-explore-all {
            background: #003631;
            color: white;
            display: block;
            margin: 0 auto;
            width: fit-content;
        }

        .btn-explore-all:hover {
            background: #003631;
        }

        /* Rewards Section */
        .rewards-section {
            position: relative;
            background: url('images/bg-rewards.png') no-repeat center center/cover;
            color: #fff;
            overflow: hidden;
            margin: 0 auto;
            padding: 0;
            opacity: 1;
        }

        .rewards-container {
            max-width: 90%;
            margin: 0% auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 3rem;
        }

        /* Left Side Text */
        .rewards-text {
            flex: 1 1 400px;
            z-index: 2;
        }

        .rewards-text h1 {
            font-size: 4rem;
            font-weight: 700;
            color: #F1B24A;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .rewards-text h1 span {
            color: #ffd877;
        }

        .rewards-text p {
            max-width: 500px;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.6;
            margin-bottom: 3rem;
            font-size: 1.2rem;
            margin-top: 5rem;
            font-weight: bold;
        }

        /* Button */
        .rewards-btn {
            display: inline-block;
            background: #F1B24A;
            color: #013220;
            padding: 0.9rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s ease;
    }

        .rewards-btn:hover {
            background: #ffcc5c;
            transform: scale(1.05);
    }

        /* Right Side Image */
        .rewards-image {
            flex: 1 1 400px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            position: relative;
            margin-right: -80px;
        }

        .rewards-image img {
            width: 100%;
            max-width: 680px;
            height: 100%;
            object-fit: contain;
            animation: float 3s ease-in-out infinite;
        }

        /* Loan Services Section */
        .loans {
            background: linear-gradient(to right, #F1B24A 50%, #fef3e2 50%);
            padding: 5rem 5%;
        }

        .loans h2 {
            color: #0d4d4d;
            font-size: 3rem;
            margin-bottom: 3rem;
        }

        .loans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .loan-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .loan-image {
            width: 100%;
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .loan-image img {
            width: 30%;
            height: auto;
            object-fit: contain;
        }

        .loan-image2{
            width: 100%;
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .loan-image2 img {
            width: 50%;
            height: auto;
            object-fit: contain;
        }

        .loan-image3 {
            width: 100%;
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .loan-image3 img {
            width: 55%;
            height: auto;
            object-fit: contain;
        }

        .loan-image4 {
            width: 100%;
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .loan-image4 img {
            width: 30%;
            height: auto;
            object-fit: contain;
        }

        .loan-content {
            padding: 1.5rem;
            text-align: center;
        }

        .loan-content h3 {
            color: #003631;
            margin-bottom: 0.5rem;
        }

        .loan-content p {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .loan-link {
            color: #003631;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
        }

        /* Footer */
        footer {
            background: #003631;
            color: white;
            padding: 3rem 5% 1rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            margin-bottom: 2rem;
        }

        .footer-brand p {
            color: rgba(255,255,255,0.7);
            margin: 1rem 0;
            line-height: 1.6;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-icon {
            width: 35px;
            height: 35px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s;
        }

        /* Career Section */
        .career-section {
            background: #003631;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 60px 0px;
            position: relative;
            overflow: hidden;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .content {
            color: white;
            padding-right: 40px;
        }

        .content h1 {
            font-size: 3.5rem;
            font-weight: bold;
            color: #F1B24A;
            margin-bottom: 30px;
            line-height: 1.1;
        }

        .content .intro {
            font-size: 1rem;
            margin-bottom: 35px;
            line-height: 1.7;
            color: #ffffff;
        }

        .content h2 {
            font-size: 1.1rem;
            color: #F1B24A;
            margin-bottom: 12px;
            margin-top: 25px;
            font-weight: 600;
        }

        .content p {
            margin-bottom: 15px;
            color: #ffffff;
            font-size: 0.95rem;
        }

        .location {
            margin: 20px 0 25px 0;
            font-size: 0.95rem;
        }

        .location strong {
            color: #F1B24A;
        }

        .requirements {
            margin-top: 25px;
        }

        .requirements h2 {
            margin-bottom: 15px;
        }

        .requirements ul {
            list-style: none;
            padding-left: 0;
        }

        .requirements li {
            padding: 6px 0;
            padding-left: 25px;
            position: relative;
            color: #ffffff;
            font-size: 0.95rem;
        }

        .requirements li::before {
            content: '•';
            color: #F1B24A;
            font-weight: bold;
            font-size: 1.4rem;
            position: absolute;
            left: 0;
            top: -2px;
        }

        .note {
            background: rgba(241, 178, 74, 0.1);
            padding: 18px;
            border-radius: 8px;
            margin-top: 25px;
            border-left: 4px solid #F1B24A;
            font-size: 0.95rem;
        }

        .note strong {
            color: #F1B24A;
        }

        .image-container {
            position: relative;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: -40%;
        }

        .image-wrapper {
            background-image: url("images/bg-image-1.jpg");
            border-radius: 50%;
            position: relative;
            width: 100%;
            max-width: 700px;
        }

        .curved-image {
            position: relative;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            z-index: 2;
        }

        .curved-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border: 5px solid #F1B24A;
            border-radius: 50%;
            z-index: 2;
            pointer-events: none;
        }

        .curved-image img {
            width: 100%;
            height: 100%;
            height: auto;
            display: block;
            z-index: 1;
        }

        .decorative-curve img {
            margin-right: -150%;
            position: absolute;
            margin-top: -100%;
            width: 100%;
            height: 100%;
            z-index: 9999;
        }

        /* Decorative dots grid */
        .decorative-dots {
            position: absolute;
            bottom: 30px;
            right: 30px;
            display: grid;
            grid-template-columns: repeat(5, 6px);
            grid-template-rows: repeat(3, 6px);
            gap: 10px;
            z-index: 3;
        }

        .decorative-dots span {
            width: 6px;
            height: 6px;
            background: rgba(241, 178, 74, 0.7);
            border-radius: 50%;
        }

        .social-icon:hover {
            background: #F1B24A;
        }

        .footer-section h4 {
            margin-bottom: 1rem;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section ul li a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section ul li a:hover {
            color: #F1B24A;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            color: rgba(255,255,255,0.7);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-links {
            display: flex;
            gap: 2rem;
        }

        .footer-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.9rem;
        }

        /* DROPDOWN STYLES */
        .dropdown {
            position: relative;
        }   

        .dropbtn {
            background: none;
            border: none;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            padding: 0.5rem 1rem;
            transition: color 0.3s;
        }

        .dropbtn:hover {
            color: #F1B24A;
        }

        /* Dropdown menu box */
        .dropdown-content {
            display: none;
            position: absolute;
            left: 0;
            top: 150%;
            width: 150vw;
            background-color: #D9D9D9;
            padding: 1.5rem 0;
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
            z-index: 99;
            text-align: center;
            transform: translateX(-50%);
            left: 150%;
            gap: 10rem;
        }

        /* Links inside dropdown */
        .dropdown-content a {
            color: #003631;
            margin: 0 3rem;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
        }

        .dropdown-content a:hover {
            text-decoration: underline;
        }

        /* Make dropdown align properly inside nav */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }


        /* Responsive */
        @media (max-width: 1024px) {
        .hero {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .hero-content h1 {
            font-size: 3rem;
        }
  
        .hero-card {
            margin-top: 2rem;
        }

        .rewards-container {
            flex-direction: column;
            text-align: center;
        }

        .rewards-image {
            justify-content: center;
        }
     }


        @media (max-width: 768px) {
         nav {
            flex-direction: column;
            align-items: flex-start;
        }
        .nav-buttons {
            flex-wrap: wrap;
            margin-top: 1rem;
        }
        .solutions-grid,
        .loans-grid {
            grid-template-columns: 1fr 1fr;
        }

        .footer-content {
        grid-template-columns: 1fr 1fr;
        }
        }

        @media (max-width: 480px) {

        .hero-content h1 {
            font-size: 2rem;
        }

        .solutions-grid,
        .loans-grid {
        grid-template-columns: 1fr;
        }

        .footer-content {
        grid-template-columns: 1fr;
        }

        .rewards-text h1 {
        font-size: 2rem;
        }
        }

    </style>
    <html>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="logo">
            <div class="logo-icon">
                <a href="viewing.php">
                    <img src="images/Logo.png.png">
                </a>
            </div>
                <span>
                    <a href="viewing.php">
                    EVERGREEN
                    </a>
                </span>
        </div>
        <div class="nav-buttons">
            <a href="login.php" class="btn btn-login">Login</a>
                
            <a href="login.php" class="btn btn-primary">Get Started</a>

        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Banking that grows <br>with <span class="highlight">you</span></br></h1>
            <p>Secure financial solutions for every stage of your life journey.<br> Invest, save, and achieve your goals with Evergreen.</p>
            <div class="hero-buttons">
                <a href="login.php" class="btn btn-primary">Open an Account</a>
                <a href="learnmoreno.php" class="btn btn-secondary">Learn More</a>
            </div>
        </div>
        <div class="hero-card">
    <div class="hero-image">
        <img src="images/hero-image.png" alt="Hero Image">
    </div>
    <h3>Banking at your fingertips</h3>
    <p>Experience our award-winning digital banking platform designed for your<br>convenience.</p>
</div>
    </section>

    <!-- Financial Solutions Section -->
    <section class="solutions">
        <h2>Financial Solutions for Every Need</h2>
        <p class="solutions-intro">Discover our comprehensive range of banking products designed to support your financial journey.</p>
        
        <div class="solutions-grid">
            <div class="solution-card">
                <div class="solution-icon">💳</div>
                <h3>Everyday Banking</h3>
                <p>Fee-free checking accounts with <br>premium benefits and rewards on<br> everyday spending.</p>
            </div>
            
            <div class="solution-card">
                <div class="solution-icon">🏦</div>
                <h3>Savings & Deposits</h3>
                <p>High-yield savings accounts and<br> CDs to help your money grow<br> faster.</p>
            </div>
            
            <div class="solution-card">
                <div class="solution-icon">📈</div>
                <h3>Investments</h3>
                <p>Personalized investment strategies aligned with your financial goals.</p>
            </div>
            
            <div class="solution-card">
                <div class="solution-icon">🏠</div>
                <h3>Home Loans</h3>
                <p>Competitive mortgage rates and flexible repayment options for your dream home.</p>
            </div>
        </div>
        
    </section>

    <!-- Rewards Section -->
    <section class="rewards-section">
  <div class="rewards-container">
    <div class="rewards-text">
      <h1>Get a Card<br>to get some<br><span>Awesome Rewards!</span></h1>
      <p>
        Open an account with us today and enjoy exclusive rewards, special offers, and member-only perks designed to make your banking more rewarding.
      </p>
      <a href="#" class="rewards-btn">Learn More</a>
    </div>

    <div class="rewards-image">
      <img src="images/card.png" alt="Reward Card">
    </div>
  </div>
</section

    <!-- Loan Services Section -->
    <section class="loans">
        <h2>LOAN SERVICES<br>WE OFFER</h2>
        
        <div class="loans-grid">
            <div class="loan-card">
                <div class="loan-image">
                    <img src="images/personalloan.png" alt="Personal Loan">
                </div>
                <div class="loan-content">
                    <h3>Personal Loan</h3>
                    <p>Stop worrying and bring your<br> plans to life.</p>
                </div>
            </div>
            
            <div class="loan-card">
                <div class="loan-image2">
                    <img src="images/autoloan.png" alt="Auto Loan">
                </div>
                <div class="loan-content">
                    <h3>Auto Loan</h3>
                    <p>Drive your new car with low rates and fast approval.</p>
                </div>
            </div>
            
            <div class="loan-card">
                <div class="loan-image3">
                    <img src="images/homeloan.png" alt="Home Loan">
                </div>
                <div class="loan-content">
                    <h3>Home Loan</h3>
                    <p>Take the next step to your new home property to fund your various needs.</p>
                </div>
            </div>
            
            <div class="loan-card">
                <div class="loan-image4">
                    <img src="images/multipurposeloan.png" alt="Multipurpose Loan">
                </div>
                <div class="loan-content">
                    <h3>Multipurpose Loan</h3>
                    <p>Carry on with your plans. Use your property to fund your various needs.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Career Section -->
    <section class="career-section">
        <div class="container">
            <div class="content">
                <h1>Build a Meaningful Career in the World of Banking!</h1>
                
                <p class="intro">
                    At Evergreen Bank, we believe that our employees are the heart of our success. We're looking 
                    for dedicated, skilled, and passionate individuals who are ready to grow with us. Whether you're 
                    an experienced banker or a fresh graduate eager to learn, we provide a supportive environment 
                    where your talents can thrive and your career can flourish.
                </p>

                <div class="application-info">
                    <h2>How to apply?</h2>
                    <p>
                        Interested applicants are encouraged to personally visit our branch to submit their application. 
                        Please bring the following requirements and apply directly at Evergreen Bank's Human Resources 
                        Department.
                    </p>
                </div>

                <div class="location">
                    <strong>Where to Apply:</strong><br>
                    Evergreen Bank Main Branch<br>
                    123 Evergreen Avenue, City Center
                </div>

                <div class="requirements">
                    <h2>Requirements:</h2>
                    <ul>
                        <li>Updated Resume / Curriculum Vitae</li>
                        <li>Application Letter</li>
                        <li>Valid ID</li>
                        <li>Photocopy of Transcript of Records (if applicable)</li>
                    </ul>
                </div>

                <div class="note">
                    <strong>Note:</strong> Walk-in applicants are welcome. Our HR team will be glad to assist you with the next steps in your 
                    application process.
                </div>
            </div>

            <div class="image-container">
                <div class="image-wrapper">
                    <div class="curved-image">
                        <img src="images/recruit.png" alt="Professional woman in business suit shaking hands">
                        <div class="decorative-dots">
                            <span></span><span></span><span></span><span></span><span></span>
                            <span></span><span></span><span></span><span></span><span></span>
                            <span></span><span></span><span></span><span></span><span></span>
                        </div>
                    </div>
                    <div class="decorative-curve">
                        <img src="images/recruitstyle.png" alt="Images Design">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-brand">
                <div class="logo">
                    <div class="logo-icon">
                        <img src="images/icon.png">
                    </div>
                </div>
                <p>Secure. Invest. Achieve. Your trusted financial partner for a prosperous future.</p>
                <div class="social-icons">
                    <div class="social-icon">f</div>
                    <div class="social-icon">𝕏</div>
                    <div class="social-icon">in</div>
                    <div class="social-icon">in</div>
                </div>
            </div>
            
            <div class="footer-section">
                <h4>Products</h4>
                <ul>
                    <li><a href="#">Credit Cards</a></li>
                    <li><a href="#">Debit Cards</a></li>
                    <li><a href="#">Prepaid Cards</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Services</h4>
                <ul>
                    <li><a href="#">Home Loans</a></li>
                    <li><a href="#">Personal Loans</a></li>
                    <li><a href="#">Auto Loans</a></li>
                    <li><a href="#">Multipurpose Loans</a></li>
                    <li><a href="#">Website Banking</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Contact Us</h4>
                <div class="contact-item">📞 1-800-EVERGREEN</div>
                <div class="contact-item">✉️ hello@evergreenbank.com</div>
                <div class="contact-item">📍 123 Financial District, Suite 500<br>&nbsp;&nbsp;&nbsp;&nbsp;New York, NY 10004</div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>© 2023 Evergreen Bank. All rights reserved.<br>Member FDIC. Equal Housing Lender. Evergreen Bank, N.A.</p>
            <div class="footer-links">
                <a href="policy.php">Privacy Policy</a>
                <a href="terms.php">Terms and Agreements</a>
                <a href="faq.php">FAQS</a>
                <a href="about.php">About Us</a>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll effect to navbar
        let lastScroll = 0;
        const nav = document.querySelector('nav');

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 100) {
                nav.style.padding = '0.7rem 5%';
            } else {
                nav.style.padding = '1rem 5%';
            }
            
            lastScroll = currentScroll;
        });

        // Button click animations


        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        function toggleDropdown() {
            const dropdown = document.getElementById("cardsDropdown");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        }

        // Close dropdown when clicking outside
        window.addEventListener("click", function(e) {
            if (!e.target.matches('.dropbtn')) {
                const dropdown = document.getElementById("cardsDropdown");
                if (dropdown && dropdown.style.display === "block") {
                    dropdown.style.display = "none";
                }
            }
        }); 
    </script>
</body>
</html>