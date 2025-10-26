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
    <title>Evergreen Bank - Where Your Future Stays Green</title>

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
        .hero-section {
            margin-top: 80px;
            padding: 4rem 5%;
            background: #f5f5f5;
        }

        .hero-container {
            display: grid;
            grid-template-columns: 45% 55%;
            gap: 2rem;
            align-items: start;
            max-width: 1400px;
            margin: 0 auto;
        }

        .hero-left {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .hero-text h1 {
            font-size: 3.5rem;
            color: #003631;
            line-height: 1.2;
            border-left: 6px solid #F1B24A;
            padding-left: 1.5rem;
        }

        .hero-text h1 .green-text {
            color: #007A6C;
        }

        .hero-main-image {
            width: 100%;
            height: 600px;
            max-height: 150%;
            object-fit: cover;
            border-radius: 8px;
            border: 4px solid white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .hero-right {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-top: 5%;
        }

        .hero-small-images {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .hero-small-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
            border: 3px solid white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .hero-right p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #000000ff;
        }

        /* About Section */
        .about-section {
            padding: 4rem 5%;
            background: white;
        }

        .about-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .about-text p {
            font-size: 1rem;
            line-height: 1.8;
            color: #333;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 3rem;
            margin-top: 3rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 3.5rem;
            font-weight: bold;
            color: #003631;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            color: #666;
            font-weight: 600;
        }

        .badge-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .badge-icon {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
        }

        .badge-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

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

        @media (max-width: 768px) {
            .hero-container {
                grid-template-columns: 1fr;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }

            .hero-right {
                margin-top: 0;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }
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
                <button class="dropbtn" onclick="toggleDropdown()">Cards ▼</button>
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
            <a href="login.html" class="username-profile">Username</a>
            <div class="logo-icon">
                <a href="/cards/profile.html" class="profile-btn">
                    <img src="images/pfp.png" alt="Profile Icon">
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-left">
                <div class="hero-text">
                    <h1>Where Your Future <span class="green-text">Stays Green.</span></h1>
                </div>
                <img src="images/hero-main.png" alt="Business professionals meeting" class="hero-main-image">
            </div>
            <div class="hero-right">
                <div class="hero-small-images">
                    <img src="images/financial.png" alt="Financial growth chart" class="hero-small-image">
                    <img src="images/team.png" alt="Professional team" class="hero-small-image">
                </div>
                <p>Evergreen was established to provide secure and innovative financial solutions tailored to modern banking needs. Built with trust and technology at its core, Evergreen continues to help individuals and businesses grow through reliable, user-friendly digital banking services.</p>
                
                <!-- Stats in Right Column -->
                <div class="stats-container">
                    <div class="stat-item">
                        <div class="stat-number">10K+</div>
                        <div class="stat-label">Users all around<br>the world</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">8K+</div>
                        <div class="stat-label">Satisfied<br>Customer</div>
                    </div>
                    <div class="badge-item">
                        <div class="badge-icon">
                            <img src="images/bank-award.png" alt="Bank Award">
                        </div>
                        <div class="stat-label">Bank Award<br>2025</div>
                    </div>
                </div>

                <!-- Social Links in Right Column -->
                <div class="social-links">
                    <a href="#" aria-label="Facebook">f</a>
                    <a href="#" aria-label="Twitter">𝕏</a>
                    <a href="#" aria-label="Instagram">📷</a>
                    <a href="#" aria-label="LinkedIn">in</a>
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
                        <img src="images/icon.png" alt="Evergreen Logo">
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