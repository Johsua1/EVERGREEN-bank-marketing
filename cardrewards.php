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

        /* Products Section */
        .products-section {
            background: #F5F5F0;
            padding: 4rem 5%;
        }

        .products-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .products-intro {
            background: linear-gradient(135deg, #003631 0%, #004d45 100%);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            margin-bottom: 3rem;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            height: 50vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .products-intro h2 {
            color: white;
            font-size: 2rem;
            margin-bottom: 1rem;
            max-width: 800px;
        }

        .products-intro p {
            color: rgba(255,255,255,0.85);
            font-size: 1rem;
            line-height: 1.6;
            max-width: 600px;
        }

        .products-cards-section {
            background: linear-gradient(135deg, #00524a 0%, #006b5f 100%);
            border-radius: 20px;
            padding: 3rem;
            margin-bottom: 2rem;
        }

        .products-cards-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .products-cards-header h2 {
            color: white;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .products-cards-header p {
            color: rgba(255,255,255,0.85);
            font-size: 1rem;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .product-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        }

        .product-card-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .product-icon {
            width: 50px;
            height: 50px;
            background: #F1B24A;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .product-card-title-section h3 {
            color: white;
            font-size: 1.2rem;
            margin-bottom: 0.25rem;
        }

        .product-badge {
            display: inline-block;
            background: rgba(241, 178, 74, 0.2);
            color: #F1B24A;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .product-card p {
            color: rgba(255,255,255,0.8);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .product-features {
            list-style: none;
        }

        .product-features li {
            color: rgba(255,255,255,0.85);
            font-size: 0.85rem;
            padding-left: 1.5rem;
            margin-bottom: 0.5rem;
            position: relative;
        }

        .product-features li:before {
            content: '•';
            color: #F1B24A;
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        .cta-section {
            background: rgba(241, 178, 74, 0.1);
            border-radius: 15px;
            padding: 2.5rem;
            text-align: center;
            height: 30vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .cta-section h3 {
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .cta-section p {
            color: rgba(255,255,255,0.8);
            font-size: 0.95rem;
            line-height: 1.6;
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
                <img src="images/Logo.png.png" alt="Evergreen Logo">
            </div>
            <span>
                <a href="viewingpage.php">EVERGREEN</a>
            </span>
        </div>

        <div class="nav-links">
            <a href="viewingpage.php">Home</a>

            <div class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown()">Cards ⏷</button>
                <div class="dropdown-content" id="cardsDropdown">
                    <a href="cards/credit.php">Credit Cards</a>
                    <a href="cards/debit.php">Debit Cards</a>
                    <a href="cards/prepaid.php">Prepaid Cards</a>
                    <a href="cards/rewards.php">Card Rewards</a>
                </div>
            </div>

            <a href="#loans">Loans</a>
            <a href="about.php">About Us</a>
        </div>

        <div class="nav-buttons">
            <a href="#" class="username-profile"><?php echo htmlspecialchars($fullName); ?></a>

            <div class="profile-actions">
                <div class="logo-icon" style="width:40px;height:40px;">
                    <button id="profileBtn" class="profile-btn" aria-haspopup="true" aria-expanded="false" onclick="toggleProfileDropdown(event)" title="Open profile menu">
                        <img src="images/pfp.png" alt="Profile Icon">
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
            <p>Earn points, cashback, and exclusive perks every time you use your EVERGREEN Card — making every purchase more rewarding.</p>
            <button class="btn-apply">Apply Now</button>
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

    <!-- Products Section -->
    <section class="products-section">
        <div class="products-container">
            <!-- Intro Card -->
            <div class="products-intro">
                <h2>Financial Products That Reward You</h2>
                <p>From loans to lifestyle perks, we offer comprehensive financial solutions designed to support your goals</p>
            </div>

            <!-- Products Cards Section -->
            <div class="products-cards-section">
                <div class="products-cards-header">
                    <h2>Financial Products That Reward You</h2>
                    <p>From loans to lifestyle perks, we offer comprehensive financial solutions designed to support your goals</p>
                </div>

                <!-- Products Grid -->
                <div class="products-grid">
                    <!-- Card 1: Tap Your Card -->
                    <div class="product-card">
                        <div class="product-card-header">
                            <div class="product-icon">💳</div>
                            <div class="product-card-title-section">
                                <h3>Tap Your Card for Points</h3>
                                <span class="product-badge">Earn Daily | Max 5,000 pts</span>
                            </div>
                        </div>
                        <p>Freeze your card via self-competitive rates and flexible terms, but pre-approved in minutes.</p>
                        <ul class="product-features">
                            <li>No application fee</li>
                            <li>Same-day approval</li>
                            <li>Up to 24 months</li>
                        </ul>
                    </div>

                    <!-- Card 2: New Home -->
                    <div class="product-card">
                        <div class="product-card-header">
                            <div class="product-icon">🏠</div>
                            <div class="product-card-title-section">
                                <h3>New Home with Cashback</h3>
                                <span class="product-badge">Loan Points | Save ₱20k+ P/M</span>
                            </div>
                        </div>
                        <p>Make homeownership a reality with our mortgage solutions. First-time buyer programs available.</p>
                        <ul class="product-features">
                            <li>Low down payment options</li>
                            <li>Loan guidance</li>
                            <li>Fast closing</li>
                        </ul>
                    </div>

                    <!-- Card 3: Student Tuition -->
                    <div class="product-card">
                        <div class="product-card-header">
                            <div class="product-icon">🎓</div>
                            <div class="product-card-title-section">
                                <h3>Student Tuition</h3>
                                <span class="product-badge">School Points | Save from ₱400 P/M</span>
                            </div>
                        </div>
                        <p>Invest in your education with flexible student loan options and competitive interest rates.</p>
                        <ul class="product-features">
                            <li>Deferred payments</li>
                            <li>No origination fees</li>
                            <li>Cosigner release</li>
                        </ul>
                    </div>

                    <!-- Card 4: Lifestyle Perks -->
                    <div class="product-card">
                        <div class="product-card-header">
                            <div class="product-icon">🍽️</div>
                            <div class="product-card-title-section">
                                <h3>Lifestyle Perks</h3>
                                <span class="product-badge">Style ⚡ Save | Exclusive Lifestyle Benefits</span>
                            </div>
                        </div>
                        <p>Enjoy dining discounts, travel rewards, and exclusive offers at premium partner locations.</p>
                        <ul class="product-features">
                            <li>Restaurant discounts</li>
                            <li>Travel rewards</li>
                            <li>Shopping benefits</li>
                        </ul>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="cta-section">
                    <h3>Ready to Get Started?</h3>
                    <p>Apply for any of our financial products and start earning rewards today. Our team is here to help you every step of the way.</p>
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
                <a href="#">Privacy Policy</a>
                <a href="#">Terms and Agreements</a>
                <a href="#">FAQS</a>
                <a href="#">About Us</a>
            </div>
        </div>
    </footer>

    <script>
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