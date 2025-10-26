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
    <title>Document</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            background-color: #e8e8e8;
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
            gap: 3rem;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
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

        .dropdown-content a {
            color: #003631;
            margin: 0 3rem;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
        }

        .dropdown-content a:hover {
            color: #F1B24A;
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
            text-decoration: none;
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

        /* Points Card */
        .points-card {
            background: linear-gradient(135deg, #0d4d3d 0%, #1a6b56 100%);
            border-radius: 20px;
            padding: 40px;
            margin: 20px auto;
            max-width: 80%;
            text-align: center;
            color: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .points-label {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #ffd700;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .points-value {
            font-size: 72px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .points-subtitle {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Tabs */
        .tabs {
            display: flex;
            max-width: 80%;
            margin: 0 auto;
            background-color: #d0d0d0;
        }

        .tab {
            flex: 1;
            padding: 15px;
            text-align: center;
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            color: #666;
            transition: all 0.3s ease;
        }

        .tab.active {
            color: #0d4d3d;
            border-bottom-color: #0d4d3d;
            background-color: #e8e8e8;
        }

        .tab-content {
            display: none;
            max-width: 80%;
            margin: 0 auto;
            padding: 20px;
            max-height: 600px;
            overflow-y: auto;
        }

        .tab-content.active {
            display: block;
        }

        /* Mission Cards */
        .mission-card {
            background: linear-gradient(135deg, #fef8e8 0%, #fdf5dc 100%);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
            position: relative;
        }

        .mission-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .mission-points {
            min-width: 100px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .mission-points-value {
            font-size: 42px;
            font-weight: 700;
            color: #0d4d3d;
            line-height: 1;
        }

        .mission-points-label {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
            font-weight: 500;
        }

        .mission-divider {
            width: 1px;
            height: 60px;
            background: linear-gradient(to bottom, transparent, #ccc, transparent);
        }

        .mission-details {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .mission-description {
            font-size: 15px;
            color: #333;
            line-height: 1.5;
            margin-bottom: 0;
            flex: 1;
        }

        .collect-btn {
            background: linear-gradient(135deg, #0d4d3d 0%, #1a6b56 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(13, 77, 61, 0.3);
            white-space: nowrap;
        }

        .collect-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(13, 77, 61, 0.4);
        }

        .collect-btn:active {
            transform: scale(0.98);
        }

        .completed-badge {
            background: linear-gradient(135deg, #0d4d3d 0%, #1a6b56 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }

        .mission-timestamp {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 12px;
            color: #999;
        }

        /* Scrollbar */
        .tab-content::-webkit-scrollbar {
            width: 8px;
        }

        .tab-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .tab-content::-webkit-scrollbar-thumb {
            background: #0d4d3d;
            border-radius: 10px;
        }

        .tab-content::-webkit-scrollbar-thumb:hover {
            background: #1a6b56;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .empty-state-text {
            font-size: 16px;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; transform: translate(-50%, -50%) scale(0.8); }
            20% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
            80% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
            100% { opacity: 0; transform: translate(-50%, -50%) scale(0.8); }
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
                <a href="../viewing.php">EVERGREEN</a>
            </span>
        </div>

        <div class="nav-links">
            <a href="../viewing.php">Home</a>

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
            <h1>Points Details</h1>
            <p>Earn points, cashback, and exclusive perks every time you<br>
               use your EVERGREEN Card — making every purchase more<br>
               rewarding.</p>
            
            <div class="hero-apply">
                <p>Need another card?</p>
                <a href="../evergreen_form.php" class="btn-apply">Apply Now</a>
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

    <!-- Points Card -->
    <div class="points-card">
        <div class="points-label">EVERGREEN POINTS</div>
        <div class="points-value" id="totalPoints">0.00</div>
        <div class="points-subtitle">Collect more points to enjoy exciting rewards!</div>
    </div>

    <!-- Tabs -->
    <div class="tabs">
        <button class="tab active" onclick="switchTab('mission')">Mission</button>
        <button class="tab" onclick="switchTab('history')">Point History</button>
        <button class="tab" onclick="switchTab('completed')">Completed</button>
    </div>

    <!-- Mission Tab -->
    <div id="mission" class="tab-content active">
        <div class="mission-card">
            <div class="mission-points">
                <div class="mission-points-value">10</div>
                <div class="mission-points-label">points</div>
            </div>
            <div class="mission-divider"></div>
            <div class="mission-details">
                <div class="mission-description">Spend ₱200 with your EVERGREEN Card and earn 10 reward points.</div>
                <button class="collect-btn" onclick="collectPoints(this, 10)">Collect</button>
            </div>
        </div>

        <div class="mission-card">
            <div class="mission-points">
                <div class="mission-points-value">1.60</div>
                <div class="mission-points-label">points</div>
            </div>
            <div class="mission-divider"></div>
            <div class="mission-details">
                <div class="mission-description">Use your card five times this week and get 50 bonus points.</div>
                <button class="collect-btn" onclick="collectPoints(this, 1.60)">Collect</button>
            </div>
        </div>

        <div class="mission-card">
            <div class="mission-points">
                <div class="mission-points-value">25</div>
                <div class="mission-points-label">points</div>
            </div>
            <div class="mission-divider"></div>
            <div class="mission-details">
                <div class="mission-description">Make a purchase of ₱500 or more in a single transaction.</div>
                <button class="collect-btn" onclick="collectPoints(this, 25)">Collect</button>
            </div>
        </div>

        <div class="mission-card">
            <div class="mission-points">
                <div class="mission-points-value">15</div>
                <div class="mission-points-label">points</div>
            </div>
            <div class="mission-divider"></div>
            <div class="mission-details">
                <div class="mission-description">Refer a friend and earn points when they make their first purchase.</div>
                <button class="collect-btn" onclick="collectPoints(this, 15)">Collect</button>
            </div>
        </div>

        <div class="mission-card">
            <div class="mission-points">
                <div class="mission-points-value">30</div>
                <div class="mission-points-label">points</div>
            </div>
            <div class="mission-divider"></div>
            <div class="mission-details">
                <div class="mission-description">Complete your profile information and verify your email address.</div>
                <button class="collect-btn" onclick="collectPoints(this, 30)">Collect</button>
            </div>
        </div>

        <div class="mission-card">
            <div class="mission-points">
                <div class="mission-points-value">20</div>
                <div class="mission-points-label">points</div>
            </div>
            <div class="mission-divider"></div>
            <div class="mission-details">
                <div class="mission-description">Shop at any partner store this weekend for bonus rewards.</div>
                <button class="collect-btn" onclick="collectPoints(this, 20)">Collect</button>
            </div>
        </div>

        <div class="mission-card">
            <div class="mission-points">
                <div class="mission-points-value">50</div>
                <div class="mission-points-label">points</div>
            </div>
            <div class="mission-divider"></div>
            <div class="mission-details">
                <div class="mission-description">Reach ₱1,000 in total spending this month for a special bonus.</div>
                <button class="collect-btn" onclick="collectPoints(this, 50)">Collect</button>
            </div>
        </div>

        <div class="mission-card">
            <div class="mission-points">
                <div class="mission-points-value">12</div>
                <div class="mission-points-label">points</div>
            </div>
            <div class="mission-divider"></div>
            <div class="mission-details">
                <div class="mission-description">Download and use the EVERGREEN mobile app for the first time.</div>
                <button class="collect-btn" onclick="collectPoints(this, 12)">Collect</button>
            </div>
        </div>

        <div class="mission-card">
            <div class="mission-points">
                <div class="mission-points-value">18</div>
                <div class="mission-points-label">points</div>
            </div>
            <div class="mission-divider"></div>
            <div class="mission-details">
                <div class="mission-description">Leave a review for any product you've purchased this month.</div>
                <button class="collect-btn" onclick="collectPoints(this, 18)">Collect</button>
            </div>
        </div>

        <div class="mission-card">
            <div class="mission-points">
                <div class="mission-points-value">40</div>
                <div class="mission-points-label">points</div>
            </div>
            <div class="mission-divider"></div>
            <div class="mission-details">
                <div class="mission-description">Celebrate your membership anniversary - special loyalty bonus!</div>
                <button class="collect-btn" onclick="collectPoints(this, 40)">Collect</button>
            </div>
        </div>
    </div>

    <!-- Point History Tab -->
    <div id="history" class="tab-content">
        <div class="empty-state">
            <div class="empty-state-icon">📊</div>
            <div class="empty-state-text">No point history yet</div>
        </div>
    </div>

    <!-- Completed Tab -->
    <div id="completed" class="tab-content">
        <div class="empty-state">
            <div class="empty-state-icon">✓</div>
            <div class="empty-state-text">No completed missions yet</div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-brand">
                <div class="logo">
                    <div class="logo-icon">
                        <img src="../images/icon.png">
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
                <a href="#">Privacy Policy</a>
                <a href="#">Terms and Agreements</a>
                <a href="#">FAQS</a>
                <a href="#">About Us</a>
            </div>
        </div>
    </footer>
</body>

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

        let totalPoints = 0.00;
        let completedMissions = [];

        function switchTab(tabName) {
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => tab.classList.remove('active'));

            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => content.classList.remove('active'));

            event.target.classList.add('active');
            document.getElementById(tabName).classList.add('active');

            if (tabName === 'completed') {
                updateCompletedTab();
            }
        }

        function formatDateTime() {
            const now = new Date();
            const options = { 
                month: 'long', 
                day: 'numeric', 
                year: 'numeric',
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            };
            return now.toLocaleString('en-US', options).replace(',', '');
        }

        function collectPoints(button, points) {
            totalPoints += points;
            document.getElementById('totalPoints').textContent = totalPoints.toFixed(2);

            const missionCard = button.closest('.mission-card');
            const missionDescription = missionCard.querySelector('.mission-description').textContent;
            const missionPoints = missionCard.querySelector('.mission-points-value').textContent;
            
            const completedMission = {
                points: missionPoints,
                description: missionDescription,
                timestamp: formatDateTime()
            };
            completedMissions.push(completedMission);

            addToPointHistory(completedMission);

            missionCard.style.transition = 'all 0.5s ease';
            missionCard.style.opacity = '0';
            missionCard.style.transform = 'scale(0.9)';

            setTimeout(() => {
                missionCard.remove();

                const missionTab = document.getElementById('mission');
                if (missionTab.children.length === 0) {
                    missionTab.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-state-icon">🎉</div>
                            <div class="empty-state-text">All missions completed!</div>
                        </div>
                    `;
                }
            }, 500);

            const successMsg = document.createElement('div');
            successMsg.textContent = `+${points} points collected!`;
            successMsg.style.cssText = `
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: linear-gradient(135deg, #0d4d3d 0%, #1a6b56 100%);
                color: white;
                padding: 20px 40px;
                border-radius: 15px;
                font-size: 20px;
                font-weight: 700;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                z-index: 1000;
                animation: fadeInOut 2s ease;
            `;
            document.body.appendChild(successMsg);

            setTimeout(() => {
                successMsg.remove();
            }, 2000);
        }

        function addToPointHistory(mission) {
            const historyTab = document.getElementById('history');
            
            const emptyState = historyTab.querySelector('.empty-state');
            if (emptyState) {
                emptyState.remove();
            }

            const historyCard = document.createElement('div');
            historyCard.className = 'mission-card';
            historyCard.innerHTML = `
                <div class="mission-timestamp">${mission.timestamp}</div>
                <div class="mission-points">
                    <div class="mission-points-value">${mission.points}</div>
                    <div class="mission-points-label">points</div>
                </div>
                <div class="mission-divider"></div>
                <div class="mission-details">
                    <div class="mission-description">${mission.description}</div>
                    <div class="completed-badge">Completed</div>
                </div>
            `;
            
            historyTab.insertBefore(historyCard, historyTab.firstChild);
        }

        function updateCompletedTab() {
            const completedTab = document.getElementById('completed');
            
            if (completedMissions.length === 0) {
                completedTab.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-state-icon">✓</div>
                        <div class="empty-state-text">No completed missions yet</div>
                    </div>
                `;
                return;
            }

            completedTab.innerHTML = '';
            
            completedMissions.forEach(mission => {
                const completedCard = document.createElement('div');
                completedCard.className = 'mission-card';
                completedCard.innerHTML = `
                    <div class="mission-timestamp">${mission.timestamp}</div>
                    <div class="mission-points">
                        <div class="mission-points-value">${mission.points}</div>
                        <div class="mission-points-label">points</div>
                    </div>
                    <div class="mission-divider"></div>
                    <div class="mission-details">
                        <div class="mission-description">${mission.description}</div>
                        <div class="completed-badge">Completed</div>
                    </div>
                `;
                completedTab.appendChild(completedCard);
            });
        }

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
</html>