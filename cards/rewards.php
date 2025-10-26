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
    <title>Cash Rewards - Evergreen</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            background-color: #f5f5f0;
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
            width: 40px;
            height: 40px;
            background: #F1B24A;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin: 0 1.1rem;
            font-size: 1rem;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #F1B24A;
        }

        .nav-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .username-profile {
            background: transparent;
            color: #FFFFFF;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }

        .username-profile:hover {
            background: rgba(255,255,255,0.1);
            color: #F1B24A;
        }

        .profile-btn {
            width: 50%;
            height: 50;
            background: transparent;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .profile-btn img {
            width: 200%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            background-color: #003631;
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

        .dropdown-content {
            display: none;
            position: absolute;
            left: 0;
            top: 150%;
            width: 100vw;
            background-color: #D9D9D9;
            padding: 1.5rem 0;
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
            z-index: 99;
            text-align: center;
            transform: translateX(-50%);
            left: 100%;
            gap: 10rem;
        }

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

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #003631 0%, #002a26 100%);
            padding: 8rem 5% 4rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
            min-height: 50vh;
        }

        .hero-content h1 {
            color: #F1B24A;
            font-size: 5rem;
            margin-bottom: 1.5rem;
        }

        .hero-content p {
            color: rgba(255,255,255,0.9);
            font-size: 1.05rem;
            line-height: 1.7;
            margin-bottom: 2rem;
            margin-top: 1.5rem;
            max-width: 500px;
        }

        .hero-apply {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-apply {
            background: #F1B24A;
            color: #003631;
            padding: 0.9rem 2rem;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-apply:hover {
            background: #e0a03a;
            transform: translateY(-2px);
        }

        .hero-image {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .credit-card-display {
            width: 530px;
            height: 330px;
            background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%);
            border-radius: 15px;
            position: relative;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            transform: rotate(-5deg);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: rotate(-5deg) translateY(0); }
            50% { transform: rotate(-5deg) translateY(-10px); }
        }

        .card-chip {
            width: 45px;
            height: 35px;
            background: linear-gradient(135deg, #ffd700 0%, #F1B24A 100%);
            border-radius: 5px;
            position: absolute;
            left: 25px;
            top: 60px;
        }

        .card-logo {
            position: absolute;
            right: 25px;
            top: 25px;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .card-number {
            position: absolute;
            bottom: 50px;
            left: 25px;
            color: white;
            font-size: 1rem;
            letter-spacing: 3px;
        }

        .card-holder {
            position: absolute;
            bottom: 20px;
            left: 25px;
            color: rgba(255,255,255,0.8);
            font-size: 0.8rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 auto;
        }

        .points-section {
            background: linear-gradient(135deg, #0d4d4d 0%, #1a5f5f 100%);
            border-radius: 16px;
            padding: 40px;
            display: flex;
            gap: 40px;
            margin-bottom: 60px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
        }

        .points-display {
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 10%;
        }

        .points-label {
            color: #d4af37;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .points-number {
            font-size: 72px;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 20px;
        }

        .points-description {
            color: #8fb3a3;
            font-size: 14px;
        }

        .missions-panel {
            flex: 2;
            background: #e8e4d9;
            border-radius: 12px;
            padding: 30px;
        }

        .tabs {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
            border-bottom: 2px solid #d4cbb8;
            padding-bottom: 10px;
            justify-content: space-between;
        }

        .tab {
            background: none;
            border: none;
            font-size: 15px;
            font-weight: 600;
            color: #666;
            cursor: pointer;
            padding: 8px 0;
            transition: color 0.3s;
        }

        .tab.active {
            color: #0d4d4d;
            border-bottom: 3px solid #0d4d4d;
            margin-bottom: -12px;
        }

        .view-all {
            float: right;
            color: #d4af37;
            font-size: 18px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .view-all:hover {
            transform: translateY(-2px);
        }

        .mission-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .mission-points {
            font-size: 28px;
            font-weight: 700;
            color: #0d4d4d;
            min-width: 60px;
        }

        .mission-points-label {
            font-size: 11px;
            color: #666;
            font-weight: 500;
        }

        .mission-details {
            flex: 1;
        }

        .mission-text {
            font-size: 14px;
            color: #333;
            line-height: 1.5;
        }

        .redeem-section {
            margin-top: 40px;
            margin-bottom: 60px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: #0d4d4d;
            margin-bottom: 30px;
        }

        .carousel-container {
            position: relative;
        }

        .carousel {
            display: flex;
            gap: 20px;
            overflow: hidden;
            padding: 20px 0;
        }

        .carousel-track {
            display: flex;
            gap: 20px;
            transition: transform 0.5s ease;
        }

        .reward-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            min-width: 300px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .reward-icon {
            width: 80px;
            height: 80px;
            background: #f0f0f0;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }

        .reward-title {
            font-size: 18px;
            font-weight: 700;
            color: #0d4d4d;
            margin-bottom: 15px;
        }

        .reward-description {
            font-size: 13px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .redeem-button {
            background: #0d4d4d;
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .redeem-button:hover {
            background: #1a5f5f;
        }

        .carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: #0d4d4d;
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            z-index: 10;
            transition: background 0.3s;
        }

        .carousel-button:hover {
            background: #1a5f5f;
        }

        .carousel-button.prev {
            left: -20px;
        }

        .carousel-button.next {
            right: -20px;
        }

        .dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #d4cbb8;
            cursor: pointer;
            transition: background 0.3s;
        }

        .dot.active {
            background: #0d4d4d;
            width: 24px;
            border-radius: 4px;
        }

        /* Discount Section */
        .discounts-section {
            background: linear-gradient(135deg, #0d4d4d 0%, #1a5f5f 100%);
            border-radius: 16px;
            padding: 60px 40px;
            margin-top: 60px;
            margin-bottom: 60px;
        }

        .discounts-title {
            color: white;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 50px;
            text-align: left;
            border-bottom: 3px solid #d4af37;
            display: inline-block;
            padding-bottom: 10px;
        }

        .discounts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
            max-width: 900px;
            margin: 0 auto 40px;
        }

        .discount-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s;
        }

        .discount-card:hover {
            transform: translateY(-5px);
        }

        .discount-header {
            background: #f5a623;
            padding: 30px 20px 20px;
            position: relative;
        }

        .zigzag {
            position: absolute;
            bottom: -10px;
            left: 0;
            right: 0;
            height: 20px;
            background: linear-gradient(135deg, #f5a623 25%, transparent 25%) -10px 0,
                        linear-gradient(225deg, #f5a623 25%, transparent 25%) -10px 0,
                        linear-gradient(315deg, #f5a623 25%, transparent 25%),
                        linear-gradient(45deg, #f5a623 25%, transparent 25%);
            background-size: 20px 20px;
            background-color: white;
        }

        .discount-percentage {
            font-size: 56px;
            font-weight: 700;
            color: #0d4d4d;
            text-align: center;
            line-height: 1;
        }

        .discount-body {
            padding: 40px 30px 30px;
            text-align: center;
        }

        .discount-label {
            font-size: 14px;
            font-weight: 700;
            color: #0d4d4d;
            letter-spacing: 1px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e0e0e0;
        }

        .discount-description {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
            min-height: 60px;
        }

        .discount-redeem-button {
            background: #0d4d4d;
            color: white;
            border: none;
            padding: 12px 40px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .discount-redeem-button:hover {
            background: #1a5f5f;
            transform: scale(1.05);
        }

        .discounts-footer {
            text-align: center;
            color: white;
            font-size: 16px;
            margin-top: 20px;
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

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hero {
                grid-template-columns: 1fr;
                padding: 6rem 5% 3rem;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .credit-card-display {
                width: 400px;
                height: 250px;
            }

            .points-section {
                flex-direction: column;
                padding: 30px;
            }

            .carousel-button {
                display: none;
            }

            .carousel {
                overflow-x: auto;
                scroll-snap-type: x mandatory;
            }

            .reward-card {
                scroll-snap-align: start;
            }

            .footer-content {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            nav {
                padding: 1rem 3%;
                flex-wrap: wrap;
            }

            .nav-links {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .nav-links a {
                margin: 0 0.5rem;
                font-size: 0.9rem;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content p {
                font-size: 0.95rem;
            }

            .credit-card-display {
                width: 100%;
                max-width: 350px;
                height: 220px;
            }

            .points-number {
                font-size: 56px;
            }

            .tabs {
                flex-wrap: wrap;
                gap: 10px;
            }

            .view-all {
                float: none;
                display: block;
                margin-top: 10px;
            }

            .mission-card {
                flex-direction: column;
                text-align: center;
            }

            .discounts-section {
                padding: 40px 20px;
            }

            .discounts-title {
                font-size: 24px;
            }

            .discounts-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }

            .footer-links {
                flex-direction: column;
                gap: 1rem;
            }
        }

        @media (max-width: 480px) {
            .hero-content h1 {
                font-size: 1.75rem;
            }

            .btn-apply {
                padding: 0.7rem 1.5rem;
                font-size: 0.9rem;
            }

            .points-section {
                padding: 20px;
            }

            .points-number {
                font-size: 48px;
            }

            .missions-panel {
                padding: 20px;
            }

            .section-title {
                font-size: 20px;
            }

            .reward-card {
                min-width: 250px;
                padding: 20px;
            }

            .discount-percentage {
                font-size: 48px;
            }

            .discount-body {
                padding: 30px 20px 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav>
        <div class="logo">
            <div class="logo-icon">
                <img src="../images/icon.png" alt="Evergreen Logo">
            </div>
            <span>
                <a href="../viewingpage.php">EVERGREEN</a>
            </span>
        </div>

        <div class="nav-links">
            <a href="../viewingpage.php">Home</a>

            <div class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown()">Cards ▼</button>
                <div class="dropdown-content" id="cardsDropdown">
                    <a href="../cards/credit.php">Credit Cards</a>
                    <a href="../cards/debit.php">Debit Cards</a>
                    <a href="../cards/prepaid.php">Prepaid Cards</a>
                    <a href="../cards/rewards.php">Card Rewards</a>
                </div>
            </div>

            <a href="#loans">Loans</a>
            <a href="/about.php">About Us</a>
        </div>

        <div class="nav-buttons">
            <a href="../login.php" class="username-profile">Username</a>
            <div class="logo-icon">
                <a href="../cards/profile.php" class="profile-btn">
                    <img src="../images/pfp.png" alt="Profile Icon">
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Cash Rewards</h1>
            <p>Earn points, cashback, and exclusive perks every time you
             use your EVERGREEN Card — making every purchase more
              rewarding.</p>
            
            <div class="hero-apply">
                <p>Need another card?</p>
                <button class="btn-apply">Apply Now</button>
            </div>
        </div>
        <div class="hero-image">
            <div class="credit-card-display">
                <div class="card-chip"></div>
                <div class="card-logo">VISA</div>
                <div class="card-number">•••• •••• •••• 4589</div>
                <div class="card-holder">CARDHOLDER NAME</div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="points-section">
            <div class="points-display">
                <div class="points-label">EVERGREEN POINTS</div>
                <div class="points-number">0.00</div>
                <div class="points-description">Collect more points to<br>enjoy exciting rewards!</div>
            </div>
            <div class="missions-panel">
                <div class="tabs">
                    <button class="tab active">Mission</button>
                    <button class="tab">Point History</button>
                    <button class="tab">Completed</button>
                    <a href="../cards/points.php" class="view-all">View All →</a>
                </div>
                <div class="mission-card">
                    <div>
                        <div class="mission-points">10</div>
                        <div class="mission-points-label">points</div>
                    </div>
                    <div class="mission-details">
                        <div class="mission-text">Spend ₱200 with your EVERGREEN Card and earn 10 reward points.</div>
                    </div>
                </div>
                <div class="mission-card">
                    <div>
                        <div class="mission-points">1.60</div>
                        <div class="mission-points-label">points</div>
                    </div>
                    <div class="mission-details">
                        <div class="mission-text">Use your card five times this week and get 50 bonus points.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="redeem-section">
            <h2 class="section-title">Redeem Rewards</h2>
            <div class="carousel-container">
                <button class="carousel-button prev" onclick="moveCarousel(-1)">‹</button>
                <div class="carousel">
                    <div class="carousel-track" id="carouselTrack">
                        <div class="reward-card">
                            <div class="reward-icon">🏠</div>
                            <div class="reward-title">Home Loans</div>
                            <div class="reward-description">Competitive mortgage rates and flexible repayment options for your dream home.</div>
                            <button class="redeem-button">Redeem</button>
                        </div>
                        <div class="reward-card">
                            <div class="reward-icon">🏠</div>
                            <div class="reward-title">Personal Loans</div>
                            <div class="reward-description">Competitive mortgage rates and flexible repayment options for your dream home.</div>
                            <button class="redeem-button">Redeem</button>
                        </div>
                        <div class="reward-card">
                            <div class="reward-icon">🏠</div>
                            <div class="reward-title">Multi-personal Loans</div>
                            <div class="reward-description">Competitive mortgage rates and flexible repayment options for your dream home.</div>
                            <button class="redeem-button">Redeem</button>
                        </div>
                        <div class="reward-card">
                            <div class="reward-icon">🏠</div>
                            <div class="reward-title">Auto Loans</div>
                            <div class="reward-description">Competitive mortgage rates and flexible repayment options for your dream home.</div>
                            <button class="redeem-button">Redeem</button>
                        </div>
                    </div>
                </div>
                <button class="carousel-button next" onclick="moveCarousel(1)">›</button>
            </div>
            <div class="dots" id="dots"></div>
        </div>

        <!-- Discount Section -->
        <div class="discounts-section">
            <h2 class="discounts-title">Redeem Discounts</h2>
            <div class="discounts-grid">
                <div class="discount-card">
                    <div class="discount-header">
                        <div class="discount-percentage">50%</div>
                        <div class="zigzag"></div>
                    </div>
                    <div class="discount-body">
                        <div class="discount-label">DISCOUNT</div>
                        <div class="discount-description">Enjoy 50% savings on your next getaway when you book with your EVERGREEN Card.</div>
                        <button class="discount-redeem-button">Redeem</button>
                    </div>
                </div>

                <div class="discount-card">
                    <div class="discount-header">
                        <div class="discount-percentage">20%</div>
                        <div class="zigzag"></div>
                    </div>
                    <div class="discount-body">
                        <div class="discount-label">DISCOUNT</div>
                        <div class="discount-description">Enjoy 20% off on your favorite meals when you dine with your EVERGREEN Card.</div>
                        <button class="discount-redeem-button">Redeem</button>
                    </div>
                </div>
            </div>
            <div class="discounts-footer">
                Discover more options designed to give you flexibility and rewards.
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-brand">
                <div class="logo">
                    <div class="logo-icon">
                        <img src="/images/icon.png" alt="Evergreen Logo">
                    </div>
                </div>
                <p>Secure. Invest. Achieve. Your trusted financial partner for a prosperous future.</p>
                <div class="social-icons">
                    <div class="social-icon">f</div>
                    <div class="social-icon">𝕏</div>
                    <div class="social-icon">in</div>
                    <div class="social-icon">📷</div>
                </div>
            </div>
            
            <div class="footer-section">
                <h4>Products</h4>
                <ul>
                    <li><a href="cards/credit.php">Credit Cards</a></li>
                    <li><a href="cards/debit.php">Debit Cards</a></li>
                    <li><a href="cards/prepaid.php">Prepaid Cards</a></li>
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
                <a href="#">Privacy Policy</a>
                <a href="#">Terms and Agreements</a>
                <a href="#">FAQS</a>
                <a href="#">About Us</a>
            </div>
        </div>
    </footer>
    <script>
        // Dropdown Toggle
        function toggleDropdown() {
            const dropdown = document.getElementById('cardsDropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                const dropdown = document.getElementById('cardsDropdown');
                if (dropdown.style.display === 'block') {
                    dropdown.style.display = 'none';
                }
            }
        }

        let currentSlide = 0;
        const track = document.getElementById('carouselTrack');
        const cards = document.querySelectorAll('.reward-card');
        const totalSlides = cards.length - 2;
        const dotsContainer = document.getElementById('dots');

        // Create dots
        for (let i = 0; i <= totalSlides; i++) {
            const dot = document.createElement('div');
            dot.className = 'dot';
            if (i === 0) dot.classList.add('active');
            dot.onclick = () => goToSlide(i);
            dotsContainer.appendChild(dot);
        }

        function moveCarousel(direction) {
            currentSlide += direction;
            if (currentSlide < 0) currentSlide = 0;
            if (currentSlide > totalSlides) currentSlide = totalSlides;
            updateCarousel();
        }

        function goToSlide(index) {
            currentSlide = index;
            updateCarousel();
        }

        function updateCarousel() {
            const offset = currentSlide * -320;
            track.style.transform = `translateX(${offset}px)`;
            
            const dots = document.querySelectorAll('.dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });
        }

        // Tab switching
        const tabs = document.querySelectorAll('.tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>