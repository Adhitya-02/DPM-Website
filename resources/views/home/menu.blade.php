<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dinas Pariwisata Kabupaten Madiun</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="icon" href="{{ asset('dist/img/logo_KabMadiun.gif') }}" type="image/gif" sizes="16x16">
    <style>
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
            background-color: #f8f9fa;
        }
        .content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 8px 32px 8px;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
        }
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
        }
        @media (max-width: 600px) {
            .navbar {
                padding: 10px 16px;
            }
            .content {
                padding: 12px 2vw 12px 6vw;
            }
            .navbar > div:last-child {
                gap: 10px;
                padding: 20px;
            }
        }
        @media (max-width: 400px) {
            .navbar {
                padding: 8px 12px;
            }
            .content {
                padding: 6px 1vw 6px 2vw;
            }
            .navbar > div:last-child {
                gap: 10px;
                padding: 16px;
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
            <a href="{{ route('home')}}">Beranda</a>
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

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const burger = document.querySelector('.menu-burger');
            const nav = document.querySelector('.navbar > div:last-child');

            // Burger menu
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

            // Add active class to current page
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.navbar a');
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath || 
                    (currentPath.includes('pariwisata') && link.getAttribute('href').includes('pariwisata')) ||
                    (currentPath.includes('booking') && link.getAttribute('href').includes('booking')) ||
                    (currentPath === '/' && link.getAttribute('href').includes('home'))) {
                    link.classList.add('active');
                }
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