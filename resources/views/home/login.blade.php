<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dinas Pariwisata Kabupaten Madiun</title>
    <link rel="stylesheet" href="style2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for professional icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background Elements */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="0,0 0,100 1000,100"/></svg>');
            background-size: cover;
            z-index: 1;
        }

        /* Floating shapes for interactive background */
        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            left: 80%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 80%;
            left: 20%;
            animation-delay: 4s;
        }

        .shape:nth-child(4) {
            width: 100px;
            height: 100px;
            top: 30%;
            right: 15%;
            animation-delay: 1s;
        }

        .shape:nth-child(5) {
            width: 90px;
            height: 90px;
            top: 70%;
            right: 40%;
            animation-delay: 3s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
                opacity: 0.1;
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
                opacity: 0.2;
            }
        }

        /* Travel icons background */
        .travel-icons {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        .travel-icon {
            position: absolute;
            font-size: 20px;
            color: rgba(255, 255, 255, 0.15);
            animation: drift 8s linear infinite;
        }

        .travel-icon:nth-child(1) { top: 15%; left: 5%; animation-delay: 0s; }
        .travel-icon:nth-child(2) { top: 25%; right: 10%; animation-delay: 2s; }
        .travel-icon:nth-child(3) { bottom: 20%; left: 15%; animation-delay: 4s; }
        .travel-icon:nth-child(4) { bottom: 30%; right: 20%; animation-delay: 6s; }

        @keyframes drift {
            0% { transform: translateX(0px) rotate(0deg); }
            25% { transform: translateX(10px) rotate(90deg); }
            50% { transform: translateX(0px) rotate(180deg); }
            75% { transform: translateX(-10px) rotate(270deg); }
            100% { transform: translateX(0px) rotate(360deg); }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 90%;
            max-width: 450px;
            position: relative;
            z-index: 10;
            transition: all 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .logo-container {
            margin-bottom: 20px;
            animation: slideDown 1s ease-out;
        }

        .logo-container img {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
            transition: transform 0.3s ease;
        }

        .logo-container img:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .login-container h2 {
            color: #2c3e50;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
            animation: slideDown 1s ease-out 0.2s both;
        }

        .form-group {
            margin-bottom: 15px;
            position: relative;
            animation: slideUp 1s ease-out 0.4s both;
        }

        .login-input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
            color: #2c3e50;
        }

        .login-input:focus {
            outline: none;
            border-color: #667eea;
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .login-input::placeholder {
            color: #adb5bd;
        }

        .password-container {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            color: #667eea;
            font-size: 16px;
            pointer-events: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            z-index: 1;
        }

        .login-input.with-icon {
            padding-left: 45px;
        }

        .login-input:focus + .input-icon,
        .login-input:focus ~ .input-icon {
            color: #5a67d8;
        }

        .input-container {
            position: relative;
            display: block;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #667eea;
            font-weight: 500;
            font-size: 16px;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .toggle-password:hover {
            color: #5a67d8;
            transform: translateY(-50%) scale(1.1);
        }

        .login-button {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: 2px solid transparent;
            padding: 15px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
            position: relative;
            overflow: hidden;
            animation: slideUp 1s ease-out 0.6s both;
            box-sizing: border-box;
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .login-button:hover::before {
            left: 100%;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .register-link {
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
            animation: slideUp 1s ease-out 0.8s both;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .register-link a:hover {
            color: #5a67d8;
            text-decoration: underline;
        }

        .alert {
            border-radius: 12px;
            margin-bottom: 20px;
            border: none;
            animation: slideDown 1s ease-out 0.3s both;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .close {
            float: right;
            font-size: 20px;
            font-weight: bold;
            color: inherit;
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Animations */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 20px;
            }

            .login-container {
                padding: 30px 25px;
                margin: 20px 0;
            }

            .login-container h2 {
                font-size: 20px;
            }

            .logo-container img {
                width: 60px;
                height: 60px;
            }

            .login-input {
                padding: 12px 15px;
                font-size: 16px; /* Prevents zoom on iOS */
            }

            .login-button {
                padding: 12px;
                font-size: 15px;
            }

            .travel-icon {
                font-size: 16px;
            }

            .shape {
                display: none; /* Hide floating shapes on mobile for performance */
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 25px 20px;
                border-radius: 15px;
            }

            .login-container h2 {
                font-size: 18px;
                margin-bottom: 25px;
            }

            .login-input {
                padding: 10px 12px;
            }

            .toggle-password {
                right: 12px;
                font-size: 12px;
            }
        }

        /* Loading state */
        .login-button.loading {
            background: #6c757d;
            cursor: not-allowed;
        }

        .login-button.loading::after {
            content: "Memuat...";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Focus trap for accessibility */
        .login-container:focus-within {
            box-shadow: 0 25px 50px rgba(102, 126, 234, 0.2);
        }
    </style>
</head>

<body>
    <!-- Animated Background Elements -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <!-- Travel Icons Background -->
    <div class="travel-icons">
        <div class="travel-icon"><i class="fas fa-mountain"></i></div>
        <div class="travel-icon"><i class="fas fa-umbrella-beach"></i></div>
        <div class="travel-icon"><i class="fas fa-map-marked-alt"></i></div>
        <div class="travel-icon"><i class="fas fa-camera-retro"></i></div>
    </div>

    <div class="login-container">
        <div class="logo-container">
            <img src="{{ asset('dist/img/logo_KabMadiun.gif') }}" alt="Logo Kabupaten Madiun">
            <h2>Dinas Pariwisata Kabupaten Madiun</h2>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="fas fa-check-circle"></i> Berhasil!</h5>
                {{ session('success') }}
            </div>
        @endif

        @if (session('message'))
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="fas fa-info-circle"></i> {{ session('message') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong><i class="fas fa-exclamation-triangle"></i> Terjadi Kesalahan:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="login-form" method="POST" action="{{ route('login.store') }}" id="loginForm">
            @csrf
            <div class="form-group">
                <div style="position: relative;">
                    <input type="email" 
                           name="email" 
                           placeholder="Masukkan email Anda" 
                           class="login-input with-icon" 
                           value="{{ old('email') }}"
                           required>
                    <i class="fas fa-envelope input-icon"></i>
                </div>
            </div>

            <div class="form-group password-container">
                <div style="position: relative;">
                    <input type="password" 
                           name="password" 
                           placeholder="Masukkan password Anda" 
                           class="login-input with-icon" 
                           id="password" 
                           required>
                    <i class="fas fa-lock input-icon"></i>
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <i class="fas fa-eye" id="toggle-password-icon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="login-button" id="loginBtn">
                <i class="fas fa-sign-in-alt"></i> Masuk
            </button>

            <div class="register-link">
                Belum Punya Akun? <a href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Daftar Sekarang</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggle-password-icon');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            if (type === 'password') {
                toggleIcon.className = 'fas fa-eye';
            } else {
                toggleIcon.className = 'fas fa-eye-slash';
            }
        }

        // Form submission handling
        document.getElementById('loginForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('loginBtn');
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        });

        // Auto-dismiss alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);

        // Close button functionality
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('close')) {
                const alert = e.target.closest('.alert');
                alert.style.transition = 'opacity 0.3s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            }
        });

        // Add subtle parallax effect to floating shapes
        document.addEventListener('mousemove', function(e) {
            const shapes = document.querySelectorAll('.shape');
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;

            shapes.forEach((shape, index) => {
                const speed = (index + 1) * 0.02;
                const translateX = (x - 0.5) * speed * 50;
                const translateY = (y - 0.5) * speed * 50;
                shape.style.transform = `translate(${translateX}px, ${translateY}px)`;
            });
        });
    </script>
</body>

</html>