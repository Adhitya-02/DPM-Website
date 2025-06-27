<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dinas Pariwisata Kabupaten Madiun</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="icon" href="{{ asset('dist/img/logo_KabMadiun.gif') }}" type="image/gif" sizes="16x16">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-width: 0;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: #f8f9fa;
        }

        /* MENU STYLES - Updated to match menu.blade.php */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 24px;
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            position: relative;
        }

        .logo-kab {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo_text h3 {
            margin: 0;
            font-size: 1.2rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .navbar > div:last-child {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .navbar a {
            text-decoration: none;
            color: #2c3e50;
            font-weight: 500;
            padding: 10px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 1rem;
            position: relative;
        }

        .navbar a:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            color: #667eea;
            transform: translateY(-1px);
        }

        .navbar a.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 220px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            border-radius: 12px;
            z-index: 1000;
            left: 0;
            top: 100%;
            border: 1px solid rgba(102, 126, 234, 0.2);
            padding: 8px 0;
            margin-top: 8px;
            backdrop-filter: blur(10px);
        }

        .dropdown:hover .dropdown-content {
            display: block;
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

        .dropdown-content a {
            display: block;
            padding: 12px 18px;
            white-space: nowrap;
            transition: all 0.3s ease;
            font-size: 1rem;
            text-align: left;
            color: #2c3e50;
            border-radius: 8px;
            margin: 0 8px;
        }

        .dropdown-content a:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            color: #667eea;
            transform: translateX(4px);
        }

        .button {
            color: #667eea !important;
            padding: 10px 20px !important;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%) !important;
            transition: all 0.3s ease !important;
            border-radius: 8px !important;
            text-decoration: none !important;
            font-weight: 600 !important;
            font-size: 1rem !important;
            border: 2px solid rgba(102, 126, 234, 0.2) !important;
        }

        .button:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3) !important;
            border-color: transparent !important;
        }

        .profile-icon {
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            font-size: 1rem;
            padding: 8px 12px;
            border-radius: 8px;
            color: #2c3e50;
            font-weight: 500;
        }

        .profile-icon:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            color: #667eea;
            transform: translateY(-1px);
        }

        .profile-icon img {
            height: 32px;
            width: 32px;
            border-radius: 50%;
            border: 2px solid rgba(102, 126, 234, 0.2);
            transition: all 0.3s ease;
        }

        .profile-icon:hover img {
            border-color: #667eea;
        }

        .menu-burger {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .menu-burger:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        }

        .menu-burger span {
            display: block;
            width: 25px;
            height: 3px;
            margin: 5px 0;
            background-color: #2c3e50;
            transition: 0.3s;
            border-radius: 2px;
        }

        /* Removed pariwisata-menu styles as no longer needed */

        /* Hero Section - Enhanced similar to pariwisata.blade.php */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 20px;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
            min-height: 500px;
            display: flex;
            align-items: center;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="0,0 0,100 1000,100"/></svg>');
            background-size: cover;
        }

        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 30px;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: rgba(255,255,255,0.95);
            max-width: 800px;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .hero-description {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.9);
            max-width: 900px;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .hero-btn {
            background: rgba(255,255,255,0.9);
            color: #667eea;
            padding: 15px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 200px;
            justify-content: center;
        }

        .hero-btn:hover {
            background: white;
            color: #5a67d8;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .hero-btn.secondary {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .hero-btn.secondary:hover {
            background: rgba(255,255,255,0.9);
            color: #667eea;
            border-color: rgba(255,255,255,0.9);
        }

        /* Features Section */
        .features-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #6c757d;
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.15);
        }

        .feature-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 20px;
        }

        .feature-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .feature-description {
            font-size: 1rem;
            color: #6c757d;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 60px 20px;
            margin: 60px 0;
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            text-align: center;
        }

        .stat-item {
            background: white;
            padding: 30px 20px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.05);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.1rem;
            color: #6c757d;
            font-weight: 500;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 20px;
            text-align: center;
            margin: 60px 0 0 0;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="0,0 0,100 1000,100"/></svg>');
            background-size: cover;
        }

        .cta-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 15px;
        }

        .cta-subtitle {
            font-size: 1.2rem;
            color: rgba(255,255,255,0.9);
            margin-bottom: 30px;
        }

        .cta-button {
            background: white;
            color: #667eea;
            padding: 18px 40px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            background: #f8f9fa;
        }

        /* UPDATED FOOTER - Modern & Consistent Theme */
        footer {
            width: 100%;
            box-sizing: border-box;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 40px 20px 20px;
            font-size: 1rem;
            border-top: 4px solid #667eea;
            position: relative;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.05"><polygon points="0,0 0,100 1000,100"/></svg>');
            background-size: cover;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .footer-main {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 30px;
        }

        .footer-section h4 {
            color: #667eea;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-section p, .footer-section a {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-section a:hover {
            color: #667eea;
            transform: translateX(4px);
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .footer-links a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 0;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255, 255, 255, 0.8);
        }

        .contact-item i {
            color: #667eea;
            width: 20px;
            flex-shrink: 0;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(102, 126, 234, 0.3);
            color: rgba(255, 255, 255, 0.7);
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
        }

        .footer-logo img {
            height: 50px;
            width: auto;
        }

        .footer-logo-text h4 {
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }

        /* Mobile Responsive for Navbar */
        @media (max-width: 900px) {
            .menu-burger {
                display: block;
            }

            .navbar > div:last-child {
                display: none;
                position: fixed;
                top: 110px;
                left: 50%;
                transform: translateX(-50%);
                background: white;
                flex-direction: column;
                padding: 24px;
                box-shadow: 0 8px 32px rgba(0,0,0,0.12);
                z-index: 1000;
                width: 90%;
                max-width: 400px;
                border-radius: 12px;
                border: 1px solid rgba(102, 126, 234, 0.2);
                box-sizing: border-box;
                backdrop-filter: blur(10px);
            }

            .navbar > div:last-child.active {
                display: flex;
                animation: slideDown 0.3s ease;
            }

            .navbar a {
                width: 100%;
                text-align: left;
                padding: 12px 16px;
                border-bottom: 1px solid rgba(102, 126, 234, 0.1);
                color: #2c3e50;
                transition: all 0.3s ease;
                font-size: 1rem;
                box-sizing: border-box;
                border-radius: 8px;
                margin-bottom: 4px;
            }

            .navbar a:last-child {
                border-bottom: none;
                margin-bottom: 0;
            }

            .dropdown {
                width: 100%;
            }

            .dropdown-content {
                position: static;
                width: 100%;
                box-shadow: none;
                border: none;
                background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
                border-radius: 8px;
                margin-top: 8px;
                padding: 8px;
                display: none;
            }

            .dropdown.active .dropdown-content {
                display: block;
            }

            .dropdown-content a {
                padding: 10px 12px;
                border-bottom: 1px solid rgba(102, 126, 234, 0.1);
                width: 100%;
                text-align: left;
                margin: 0;
                border-radius: 6px;
            }

            .dropdown-content a:last-child {
                border-bottom: none;
            }

            .dropdown::after {
                content: '▼';
                font-size: 12px;
                margin-left: 8px;
                float: right;
                color: #667eea;
                transition: all 0.3s ease;
            }

            .dropdown.active::after {
                content: '▲';
                transform: rotate(180deg);
            }

            .button {
                width: 100%;
                text-align: center !important;
                padding: 12px 16px !important;
                margin-top: 8px !important;
            }

            .profile-icon {
                width: 100%;
                text-align: left;
                padding: 12px 16px;
                border-bottom: 1px solid rgba(102, 126, 234, 0.1);
                border-radius: 8px;
                margin-bottom: 4px;
            }

            .profile-icon img {
                margin-right: 8px;
            }
            /* Removed mobile pariwisata-menu styles as no longer needed */

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .hero-description {
                font-size: 1rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .hero-btn {
                width: 100%;
                max-width: 300px;
            }

            .section-title {
                font-size: 2rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }

            .cta-title {
                font-size: 2rem;
            }

            .footer-main {
                grid-template-columns: 1fr;
                gap: 25px;
                text-align: center;
            }
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 10px 16px;
            }

            .hero-section {
                padding: 40px 15px;
                min-height: 400px;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .features-section {
                padding: 40px 15px;
            }

            .feature-card {
                padding: 20px;
            }

            .stats-section {
                padding: 40px 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .stat-number {
                font-size: 2.5rem;
            }

            .cta-section {
                padding: 40px 15px;
            }

            .cta-title {
                font-size: 1.8rem;
            }

            footer {
                padding: 30px 15px 15px;
            }
        }

        @media (max-width: 400px) {
            .navbar {
                padding: 8px 12px;
            }

            .hero-title {
                font-size: 1.8rem;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .cta-title {
                font-size: 1.6rem;
            }
        }
    </style>
</head>

<body style="margin:0; padding:0;">
    <div class="navbar">
        <div class="logo-kab">
            <img src="{{ asset('dist/img/logo_KabMadiun.gif') }}" alt="Logo Kabupaten Madiun" style="height: 80px; width: auto;">
            <div class="logo_text">
                <h3>Dinas Pariwisata</h3>
                <h3>Kabupaten Madiun</h3>
            </div>
        </div>
        <button class="menu-burger">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div>
            <a href="{{ route('home')}}" class="active">Beranda</a>
            <a href="{{ route('pariwisata')}}?tipe_tenant_id=1">Pariwisata</a>
            <a href="{{ route('booking') }}">Booking</a>
            @if (Auth::check())
            <div class="dropdown">
                <a href="#" class="profile-icon">
                    <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/5a0c291740e33c1234eec5d0e989c09d0cb05c5efa31a4a966350ac43da9107f?apiKey=4145af5148824e19896d3bb670093406&" alt="User Profile" style="height: 40px; width: 40px; border-radius: 50%;">
                    {{ explode(' ', Auth::user()->nama)[0] }}
                </a>
                <div class="dropdown-content">
                    <a href="{{ route('forgot_password') }}">Ubah Password</a>
                    <a href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
            @else
            <a href="{{ route('user.login') }}" class="button">Login</a>
            @endif
        </div>
    </div>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Selamat Datang di Dinas Pariwisata Kabupaten Madiun</h1>
            <p class="hero-subtitle">Jelajahi Keindahan dan Kekayaan Budaya Kabupaten Madiun</p>
            <p class="hero-description">
                Platform ini menyediakan informasi lengkap seputar destinasi wisata, rumah makan, serta hotel yang tersedia di
                Kabupaten Madiun. Jelajahi tempat-tempat menarik, temukan rumah makan terbaik, dan pilih penginapan yang tepat
                untuk mendukung perjalanan wisata Anda yang tak terlupakan.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('pariwisata') }}" class="hero-btn">
                    <i class="fas fa-compass"></i>
                    Jelajahi Wisata
                </a>
                <a href="{{ route('booking') }}" class="hero-btn secondary">
                    <i class="fas fa-ticket-alt"></i>
                    Booking Tiket
                </a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="features-section">
        <div class="section-header">
            <h2 class="section-title">Layanan Kami</h2>
            <p class="section-subtitle">Nikmati kemudahan dalam merencanakan liburan Anda dengan berbagai fitur unggulan yang kami sediakan</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <h3 class="feature-title">Destinasi Wisata</h3>
                <p class="feature-description">
                    Temukan berbagai destinasi wisata menarik di Kabupaten Madiun dengan informasi lengkap dan terpercaya.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <h3 class="feature-title">Rumah Makan</h3>
                <p class="feature-description">
                    Jelajahi kuliner khas Madiun dan temukan rumah makan terbaik dengan cita rasa yang autentik.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-hotel"></i>
                </div>
                <h3 class="feature-title">Penginapan</h3>
                <p class="feature-description">
                    Pilih penginapan yang nyaman dan strategis untuk mendukung perjalanan wisata Anda.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-qrcode"></i>
                </div>
                <h3 class="feature-title">Tiket Digital</h3>
                <p class="feature-description">
                    Sistem pemesanan tiket QR Code yang modern dan praktis untuk destinasi wisata pilihan Anda.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-route"></i>
                </div>
                <h3 class="feature-title">Rekomendasi</h3>
                <p class="feature-description">
                    Dapatkan rekomendasi rumah makan dan hotel terdekat dari lokasi wisata yang Anda kunjungi.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3 class="feature-title">User Friendly</h3>
                <p class="feature-description">
                    Interface yang mudah digunakan dan responsif untuk kemudahan akses di berbagai perangkat.
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-section">
        <div class="stats-container">
            <div class="section-header">
                <h2 class="section-title">Kabupaten Madiun dalam Angka</h2>
            </div>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Destinasi Wisata</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Rumah Makan</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">25+</div>
                    <div class="stat-label">Hotel & Penginapan</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Wisatawan Senang</div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="cta-section">
        <div class="cta-content">
            <h2 class="cta-title">Mulai Petualangan Anda</h2>
            <p class="cta-subtitle">
                Jangan tunggu lagi! Rencanakan liburan impian Anda di Kabupaten Madiun sekarang juga.
            </p>
            <a href="{{ route('pariwisata') }}" class="cta-button">
                <i class="fas fa-paper-plane"></i>
                Mulai Eksplorasi
            </a>
        </div>
    </div>

    <!-- Enhanced Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-main">
                <div class="footer-section">
                    <div class="footer-logo">
                        <img src="{{ asset('dist/img/logo_KabMadiun.gif') }}" alt="Logo Kabupaten Madiun">
                        <div class="footer-logo-text">
                            <h4>Dinas Pariwisata</h4>
                            <h4>Kabupaten Madiun</h4>
                        </div>
                    </div>
                    <p>Platform digital terpercaya untuk menjelajahi keindahan dan kekayaan budaya Kabupaten Madiun. Temukan destinasi wisata, kuliner, dan penginapan terbaik.</p>
                </div>

                <div class="footer-section">
                    <h4><i class="fas fa-sitemap"></i> Menu Utama</h4>
                    <div class="footer-links">
                        <a href="{{ route('home') }}"><i class="fas fa-home"></i> Beranda</a>
                        <a href="{{ route('pariwisata') }}"><i class="fas fa-map-marked-alt"></i> Pariwisata</a>
                        <a href="{{ route('booking') }}"><i class="fas fa-ticket-alt"></i> Booking Tiket</a>
                        @if (Auth::check())
                            <a href="{{ route('riwayat_pemesanan') }}"><i class="fas fa-history"></i> Riwayat Pemesanan</a>
                        @else
                            <a href="{{ route('user.login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
                            <a href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Daftar</a>
                        @endif
                    </div>
                </div>

                <div class="footer-section">
                    <h4><i class="fas fa-compass"></i> Kategori Wisata</h4>
                    <div class="footer-links">
                        <a href="{{ route('pariwisata') }}?tipe_tenant_id=1"><i class="fas fa-mountain"></i> Destinasi Wisata</a>
                        <a href="{{ route('pariwisata') }}?tipe_tenant_id=2"><i class="fas fa-utensils"></i> Rumah Makan</a>
                        <a href="{{ route('pariwisata') }}?tipe_tenant_id=3"><i class="fas fa-hotel"></i> Hotel & Penginapan</a>
                    </div>
                </div>

                <div class="footer-section">
                    <h4><i class="fas fa-phone"></i> Hubungi Kami</h4>
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span>120-240-9600 / +62 822-3489-4199</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>Disparpora@madiunkab.com</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Jl. Singoludro, Kronggahan, Mejayan, Kec. Mejayan, Kabupaten Madiun, Jawa Timur 63153</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 Dinas Pariwisata Kabupaten Madiun. All rights reserved. | Dikembangkan dengan ❤️ untuk Pariwisata Madiun</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const burger = document.querySelector('.menu-burger');
            const nav = document.querySelector('.navbar > div:last-child');

            // Burger menu with enhanced functionality
            if (burger && nav) {
                burger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    nav.classList.toggle('active');
                    
                    // Animate burger menu
                    burger.classList.toggle('active');
                });

                // Close menu when clicking outside
                document.addEventListener('click', (e) => {
                    if (!burger.contains(e.target) && !nav.contains(e.target)) {
                        nav.classList.remove('active');
                        burger.classList.remove('active');
                    }
                });
            }

            // Handle dropdown in mobile
            const dropdowns = document.querySelectorAll('.dropdown');
            dropdowns.forEach(dropdown => {
                dropdown.addEventListener('click', (e) => {
                    if (window.innerWidth <= 900) {
                        e.preventDefault();
                        dropdown.classList.toggle('active');
                    }
                });
            });

            // Smooth scrolling for internal links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Add animation on scroll for feature cards
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

            // Apply animation to feature cards
            document.querySelectorAll('.feature-card').forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                observer.observe(card);
            });

            // Counter animation for stats
            const animateCounter = (element) => {
                const target = parseInt(element.textContent.replace(/\D/g, ''));
                let current = 0;
                const increment = target / 100;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    element.textContent = Math.floor(current) + '+';
                }, 20);
            };

            // Observe stat numbers for animation
            document.querySelectorAll('.stat-number').forEach(stat => {
                observer.observe(stat);
                stat.addEventListener('animationstart', () => {
                    animateCounter(stat);
                }, { once: true });
            });

            // Smooth hover transitions
            const hoverElements = document.querySelectorAll('.navbar a, .button, .profile-icon');
            hoverElements.forEach(element => {
                element.addEventListener('mouseenter', function() {
                    this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                });
            });
        });
    </script>
</body>

</html>