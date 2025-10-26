<?php
    session_start([
       'cookie_httponly' => true,
       'cookie_secure' => isset($_SERVER['HTTPS']),
       'use_strict_mode' => true
    ]);
    // Check if user is logged in
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
        header("Location: viewing.php");
    exit;
    }

    // Get user info from session
        $fullName = $_SESSION['full_name'] ?? ($_SESSION['first_name'] . ' ' . $_SESSION['last_name']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prepaid Cards - Evergreen Bank</title>
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
            color: #F1B24A;
        }

        .profile-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative; /* needed for dropdown positioning */
        }

        /* profile dropdown */
        .profile-btn {
            width: 40px;
            height: 40px;
            background: transparent;
            border: none;              /* now a button */
            padding: 0;
            cursor: pointer;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-btn img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            background-color: #003631;
            display:block;
        }

        .profile-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: #D9D9D9;
            color: #003631;
            border-radius: 8px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.12);
            min-width: 160px;
            z-index: 200;
        }

        .profile-dropdown a {
            display: block;
            padding: 0.65rem 1rem;
            color: #003631;
            text-decoration: none;
            font-weight: 600;
        }

        .profile-dropdown a:hover {
            background: rgba(0,0,0,0.04);
        }

        .profile-dropdown.show {
            display: block;
        }

        .profile-btn {
            width: 40px;
            height: 40px;
            background: transparent;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-btn img {
            width: 100%;
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

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #003631 0%, #002a26 100%);
            padding: 8rem 5% 4rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
            position: relative;
            overflow: hidden;
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
            text-decoration: none;
        }

        .btn-apply:hover {
            background: #e0a03a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(241,178,74,0.3);
        }

        .hero-image {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-hand {
            position: relative;
            width: 100%;
            max-width: 450px;
        }

        .credit-card-display {
            width: 580px;
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

        /* Why Choose Section */
        .why-choose {
            background: #f5f5f5;
            padding: 4rem 5%;
            text-align: center;
        }

        .why-choose h2 {
            color: #003631;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }

        .why-choose-subtitle {
            color: #666;
            margin-bottom: 3rem;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .benefit-card {
            background: white;
            padding: 2.5rem 2rem;
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .benefit-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .benefit-icon {
            width: 60px;
            height: 60px;
            background: #f0f0f0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.8rem;
        }

        .benefit-card h3 {
            color: #003631;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .benefit-card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .learn-more-link {
            color: #003631;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .learn-more-link:hover {
            color: #F1B24A;
        }

        /* Choose Your Card Section */
        .choose-card {
            padding: 4rem 5%;
            background: white;
        }

        .choose-card h2 {
            color: #003631;
            font-size: 2rem;
            margin-bottom: 3rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid #F1B24A;
            display: inline-block;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .card-item {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .card-image {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%);
            border-radius: 12px;
            margin-bottom: 1.5rem;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mini-card {
            width: 120px;
            height: 75px;
            background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%);
            border-radius: 8px;
            position: relative;
        }

        .mini-chip {
            width: 25px;
            height: 20px;
            background: linear-gradient(135deg, #ffd700 0%, #F1B24A 100%);
            border-radius: 3px;
            position: absolute;
            left: 12px;
            top: 25px;
        }

        .mini-logo {
            position: absolute;
            right: 12px;
            top: 12px;
            color: white;
            font-weight: bold;
            font-size: 0.7rem;
        }

        .card-item h3 {
            color: #003631;
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        .card-item p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .card-buttons {
            display: flex;
            gap: 0.8rem;
            justify-content: center;
            align-items: center;
        }

        .btn-small {
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-yellow {
            background: #F1B24A;
            color: #003631;
        }

        .btn-yellow:hover {
            background: #e0a03a;
            transform: translateY(-2px);
        }

        .btn-dark {
            background: #003631;
            color: white;
        }

        .btn-dark:hover {
            background: #002a26;
            transform: translateY(-2px);
        }

        .btn-small a {
            color: #e0a03a;
            text-decoration: none;
        }

        /* Discover More Section */
        .discover-more {
            background: linear-gradient(135deg, #003631 0%, #002a26 100%);
            padding: 4rem 5%;
        }

        .discover-more h2 {
            color: white;
            font-size: 2rem;
            margin-bottom: 3rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid #F1B24A;
            display: inline-block;
        }

        .discover-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 3rem;
            max-width: 900px;
            margin: 0 auto 3rem;
        }

        .discover-card {
            background: white;
            border-radius: 15px;
            padding: 2.5rem;
            text-align: center;
            transition: transform 0.3s;
        }

        .discover-card:hover {
            transform: translateY(-8px);
        }

        .discover-card-image {
            width: 140px;
            height: 90px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%);
            border-radius: 10px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .discover-card h3 {
            color: #003631;
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        .discover-card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .discover-footer {
            text-align: center;
            color: rgba(255,255,255,0.9);
            font-size: 1.05rem;
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

        /* Responsive */
        @media (max-width: 968px) {
            .hero {
                grid-template-columns: 1fr;
                padding: 6rem 5% 3rem;
            }

            .hero-content h1 {
                font-size: 2.2rem;
            }

            .credit-card-display {
                width: 240px;
                height: 150px;
            }

            .nav-links {
                gap: 1.5rem;
            }

            .dropdown-content {
                min-width: 400px;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .hero-content h1 {
                font-size: 1.8rem;
            }

            .benefits-grid,
            .cards-grid,
            .discover-grid {
                grid-template-columns: 1fr;
            }

            .card-buttons {
                flex-direction: column;
            }

            .nav-links {
                gap: 1rem;
            }

            .nav-links a {
                font-size: 0.9rem;
            }

            .dropdown-content {
                min-width: 300px;
            }

            .dropdown-content a {
                margin: 0.5rem 0;
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="logo">
            <div class="logo-icon">
                <img src="../images/Logo.png.png" alt="Evergreen Logo">
            </div>
            <span>
                <a href="../viewingpage.php">EVERGREEN</a>
            </span>
        </div>

        <div class="nav-links">
            <a href="../viewingpage.php">Home</a>

            <div class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown()">Cards ⏷</button>
                <div class="dropdown-content" id="cardsDropdown">
                    <a href="../cards/credit.php">Credit Cards</a>
                    <a href="../cards/debit.php">Debit Cards</a>
                    <a href="../cards/prepaid.php">Prepaid Cards</a>
                    <a href="../cards/rewards.php">Card Rewards</a>
                </div>
            </div>

            <a href="#loans">Loans</a>
            <a href="../about.php">About Us</a>
        </div>

        <div class="nav-buttons">
            <a href="#" class="username-profile"><?php echo htmlspecialchars($fullName); ?></a>

            <div class="profile-actions">
                <div class="logo-icon" style="width:40px;height:40px;">
                    <button id="profileBtn" class="profile-btn" aria-haspopup="true" aria-expanded="false" onclick="toggleProfileDropdown(event)" title="Open profile menu">
                        <img src="../images/pfp.png" alt="Profile Icon">
                    </button>
                </div>

                <div id="profileDropdown" class="profile-dropdown" role="menu" aria-labelledby="profileBtn">
                    <a href="cards/profile.php" role="menuitem">Profile</a>
                    <a href="logout.php" role="menuitem">Sign Out</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Prepaid Cards</h1>
            <p>Load, spend, and control your money with ease. The EVERGREEN Prepaid Card gives you flexibility and security without the need for a bank account.</p>
            <a href="../evergreen_form.php" class="btn-apply">Apply Now</a>
        </div>
        <div class="hero-image">
            <div class="card-hand">
                <div class="credit-card-display">
                    <div class="card-chip"></div>
                    <div class="card-logo">VISA</div>
                    <div class="card-number">•••• •••• •••• 4589</div>
                    <div class="card-holder">CARDHOLDER NAME</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Our Cards Section -->
    <section class="why-choose">
        <h2>Why Choose Our Cards?</h2>
        <p class="why-choose-subtitle">Our cards give you the freedom to spend smart and earn more.</p>
        
        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon">💰</div>
                <h3>Savings & Deposits</h3>
                <p>High-yield savings accounts and CDs to help your money grow faster.</p>
            </div>
            
            <div class="benefit-card">
                <div class="benefit-icon">📈</div>
                <h3>Investments</h3>
                <p>Personalized investment strategies aligned with your financial goals.</p>
            </div>
            
            <div class="benefit-card">
                <div class="benefit-icon">🏠</div>
                <h3>Home Loans</h3>
                <p>Competitive mortgage rates and flexible repayment options for your dream home.</p>
            </div>
        </div>
    </section>

    <!-- Choose Your Card Section -->
    <section class="choose-card">
        <h2>Choose your Card</h2>
        
        <div class="cards-grid">
            <div class="card-item">
                <div class="card-image">
                    <div class="mini-card">
                        <div class="mini-chip"></div>
                        <div class="mini-logo">VISA</div>
                    </div>
                </div>
                <h3>Home Loans</h3>
                <p>Competitive mortgage rates and flexible repayment options for your dream home.</p>
                <div class="card-buttons">
                    <button class="btn-small btn-yellow">Apply</button>
                </div>
            </div>

            <div class="card-item">
                <div class="card-image">
                    <div class="mini-card">
                        <div class="mini-chip"></div>
                        <div class="mini-logo">VISA</div>
                    </div>
                </div>
                <h3>Personal Loans</h3>
                <p>Competitive mortgage rates and flexible repayment options for your dream home.</p>
                <div class="card-buttons">
                    <button class="btn-small btn-yellow">Apply</button>
                </div>
            </div>

            <div class="card-item">
                <div class="card-image">
                    <div class="mini-card">
                        <div class="mini-chip"></div>
                        <div class="mini-logo">VISA</div>
                    </div>
                </div>
                <h3>Auto Loans</h3>
                <p>Competitive mortgage rates and flexible repayment options for your dream home.</p>
                <div class="card-buttons">
                    <button class="btn-small btn-yellow">Apply</button>
                </div>
            </div>

            <div class="card-item">
                <div class="card-image">
                    <div class="mini-card">
                        <div class="mini-chip"></div>
                        <div class="mini-logo">VISA</div>
                    </div>
                </div>
                <h3>Multipurpose Loans</h3>
                <p>Competitive mortgage rates and flexible repayment options for your dream home.</p>
                <div class="card-buttons">
                    <button class="btn-small btn-yellow">Apply</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Discover More Cards Section -->
    <section class="discover-more">
        <h2>Discover More Cards</h2>
        
        <div class="discover-grid">
            <div class="discover-card">
                <div class="discover-card-image">
                    <div class="mini-card">
                        <div class="mini-chip"></div>
                        <div class="mini-logo">VISA</div>
                    </div>
                </div>
                <h3>Credit Cards</h3>
                <p>Competitive mortgage rates and flexible repayment options for your dream home.</p>
                <button class="btn-small btn-dark">
                    <a href="credit.php">View</a>
                </button>
            </div>

            <div class="discover-card">
                <div class="discover-card-image">
                    <div class="mini-card">
                        <div class="mini-chip"></div>
                        <div class="mini-logo">VISA</div>
                    </div>
                </div>
                <h3>Debit Cards</h3>
                <p>Competitive mortgage rates and flexible repayment options for your dream home.</p>
                <button class="btn-small btn-dark">
                    <a href="debit.php">View</a>
                </button>
            </div>
        </div>

        <p class="discover-footer">Discover more options designed to give you flexibility and rewards.</p>
    </section>

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
                    <div class="social-icon">in</div>
                </div>
            </div>
            
            <div class="footer-section">
                <h4>Products</h4>
                <ul>
                    <li><a href="credit.php">Credit Cards</a></li>
                    <li><a href="debit.php">Debit Cards</a></li>
                    <li><a href="prepaid.php">Prepaid Cards</a></li>
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
        // Dropdown functionality
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

        // Smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Card hover animations
        const cards = document.querySelectorAll('.benefit-card, .card-item, .discover-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
            });
        });

        // Button click effects
        const buttons = document.querySelectorAll('button');
        buttons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });

        // Intersection Observer for scroll animations
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

        // Observe cards for animation
        document.querySelectorAll('.benefit-card, .card-item, .discover-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });

        // Parallax effect for hero card
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroCard = document.querySelector('.credit-card-display');
            if (heroCard && scrolled < 600) {
                heroCard.style.transform = `rotate(-5deg) translateY(${scrolled * 0.1}px)`;
            }
        });

        // Profile dropdown toggle
        function toggleProfileDropdown(e) {
            e.stopPropagation();
            const dd = document.getElementById('profileDropdown');
            const btn = document.getElementById('profileBtn');
            const isOpen = dd.classList.toggle('show');
            btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        }

        // close profile dropdown when clicking outside or pressing Esc
        window.addEventListener('click', function (e) {
            const dd = document.getElementById('profileDropdown');
            const btn = document.getElementById('profileBtn');
            if (!dd) return;
            if (dd.classList.contains('show') && !e.composedPath().includes(dd) && e.target !== btn) {
                dd.classList.remove('show');
                btn.setAttribute('aria-expanded', 'false');
            }
        });

        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const dd = document.getElementById('profileDropdown');
                const btn = document.getElementById('profileBtn');
                if (dd && dd.classList.contains('show')) {
                    dd.classList.remove('show');
                    btn.setAttribute('aria-expanded', 'false');
                }
            }
        });
    </script>
</body>
</html>