<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Dinas Pariwisata Kabupaten Madiun</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="style2.css">
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
            padding: 20px 0;
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
            margin-bottom: 30px;
            animation: slideDown 1s ease-out;
        }

        .logo-container img {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
            transition: transform 0.3s ease;
        }

        .logo-container img:hover {
            transform: scale(1.05) rotate(2deg);
        }

        .logo-container h2 {
            color: #2c3e50;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            line-height: 1.3;
        }

        .page-title {
            color: #667eea;
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 15px;
            animation: slideDown 1s ease-out 0.3s both;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .page-title i {
            font-size: 28px;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 30px;
            animation: slideDown 1s ease-out 0.4s both;
            line-height: 1.6;
        }

        /* Alert Messages */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: slideDown 1s ease-out 0.5s both;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border-color: #ffeaa7;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
            animation: slideUp 1s ease-out 0.6s both;
            text-align: left;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
            font-size: 14px;
        }

        .required {
            color: #dc3545;
            margin-left: 4px;
        }

        .password-container {
            position: relative;
            display: block;
        }

        .login-input {
            width: 100%;
            padding: 18px 20px 18px 50px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
            color: #2c3e50;
            box-sizing: border-box;
        }

        .login-input:focus {
            outline: none;
            border-color: #667eea;
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
            transform: translateY(-2px);
        }

        .login-input.error {
            border-color: #dc3545;
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
        }

        .login-input::placeholder {
            color: #adb5bd;
            font-weight: 400;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 18px;
            pointer-events: none;
            transition: all 0.3s ease;
            z-index: 1;
        }

        .login-input:focus ~ .input-icon {
            color: #5a67d8;
            transform: translateY(-50%) scale(1.1);
        }

        .login-input.error ~ .input-icon {
            color: #dc3545;
        }

        .toggle-password {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #667eea;
            font-size: 16px;
            transition: all 0.3s ease;
            z-index: 2;
            padding: 8px;
            border-radius: 6px;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-password:hover {
            color: #5a67d8;
            background: rgba(102, 126, 234, 0.1);
            transform: translateY(-50%) scale(1.05);
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: none;
            animation: slideDown 0.3s ease-out;
        }

        .error-message.show {
            display: block;
        }

        .password-strength {
            margin-top: 8px;
            padding: 8px;
            background: #f8f9fa;
            border-radius: 6px;
            font-size: 12px;
        }

        .strength-meter {
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            margin: 5px 0;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            background: #dc3545;
            transition: all 0.3s ease;
        }

        .strength-fill.weak { background: #dc3545; width: 25%; }
        .strength-fill.fair { background: #ffc107; width: 50%; }
        .strength-fill.good { background: #17a2b8; width: 75%; }
        .strength-fill.strong { background: #28a745; width: 100%; }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 25px;
            animation: slideUp 1s ease-out 0.8s both;
        }

        .login-button {
            width: 100%;
            padding: 18px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
            border: 2px solid transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }

        .login-button i {
            font-size: 18px;
        }

        .login-button.primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }

        .login-button.secondary {
            background: transparent;
            color: #6c757d;
            border-color: #dee2e6;
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
        }

        .login-button.primary:hover {
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .login-button.secondary:hover {
            background: #f8f9fa;
            border-color: #667eea;
            color: #667eea;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-button:disabled {
            background: #6c757d !important;
            cursor: not-allowed !important;
            transform: none !important;
            box-shadow: none !important;
        }

        .help-text {
            margin-top: 25px;
            font-size: 14px;
            color: #6c757d;
            animation: slideUp 1s ease-out 1s both;
            line-height: 1.6;
            padding: 15px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .help-text i {
            color: #667eea;
            margin-right: 8px;
            font-size: 16px;
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

        /* Loading state */
        .login-button.loading {
            background: #6c757d !important;
            cursor: not-allowed !important;
            color: #fff !important;
        }

        .login-button.loading i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .login-container {
                padding: 30px 25px;
                margin: 20px 0;
                max-width: 400px;
            }

            .logo-container h2 {
                font-size: 18px;
            }

            .page-title {
                font-size: 20px;
            }

            .logo-container img {
                width: 60px;
                height: 60px;
            }

            .login-input {
                padding: 12px 15px 12px 40px;
                font-size: 16px;
            }

            .login-button {
                padding: 12px;
                font-size: 15px;
            }

            .travel-icon {
                font-size: 16px;
            }

            .shape {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 25px 20px;
                border-radius: 15px;
            }

            .logo-container img {
                width: 60px;
                height: 60px;
            }

            .login-container h2 {
                font-size: 18px;
                margin-bottom: 15px;
            }

            .page-title {
                font-size: 20px;
                margin-bottom: 20px;
            }

            .page-title i {
                font-size: 22px;
            }

            .login-input {
                padding: 12px 14px 12px 38px;
            }

            .input-icon {
                left: 12px;
                font-size: 14px;
            }

            .toggle-password {
                right: 12px;
                font-size: 14px;
                padding: 4px;
                width: 28px;
                height: 28px;
            }

            .login-button {
                padding: 14px;
                font-size: 15px;
            }

            .login-button i {
                font-size: 16px;
            }

            .help-text {
                padding: 12px;
                font-size: 13px;
            }

            .button-group {
                gap: 10px;
                margin-top: 20px;
            }
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

        <div class="page-title">
            <i class="fas fa-key"></i>
            Reset Password
        </div>

        <p class="page-subtitle">
            Masukkan email dan password baru untuk mengubah password Anda
        </p>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-times-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM DENGAN ACTION YANG BENAR -->
        <form method="POST" action="{{ route('forgot.password.post') }}" id="resetPasswordForm">
            @csrf
            
            <div class="form-group">
                <label class="form-label" for="email">
                    Email <span class="required">*</span>
                </label>
                <div class="password-container">
                    <input type="email" 
                           name="email" 
                           placeholder="Masukkan email Anda" 
                           class="login-input" 
                           id="email" 
                           value="{{ old('email') }}"
                           required>
                    <i class="fas fa-envelope input-icon"></i>
                </div>
                <div class="error-message" id="email-error"></div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">
                    Password Baru <span class="required">*</span>
                </label>
                <div class="password-container">
                    <input type="password" 
                           name="password" 
                           placeholder="Masukkan password baru" 
                           class="login-input" 
                           id="password" 
                           required>
                    <i class="fas fa-lock input-icon"></i>
                    <button type="button" class="toggle-password" onclick="togglePassword('password')">
                        <i class="fas fa-eye" id="toggle-password-icon"></i>
                    </button>
                </div>
                <div class="password-strength" id="password-strength" style="display: none;">
                    <div class="strength-meter">
                        <div class="strength-fill" id="strength-fill"></div>
                    </div>
                    <div class="strength-text" id="strength-text">Kekuatan password: Lemah</div>
                </div>
                <div class="error-message" id="password-error"></div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">
                    Konfirmasi Password <span class="required">*</span>
                </label>
                <div class="password-container">
                    <input type="password" 
                           name="password_confirmation" 
                           placeholder="Konfirmasi password baru" 
                           class="login-input" 
                           id="password_confirmation" 
                           required>
                    <i class="fas fa-lock input-icon"></i>
                    <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">
                        <i class="fas fa-eye" id="toggle-password-confirmation-icon"></i>
                    </button>
                </div>
                <div class="error-message" id="password-confirmation-error"></div>
            </div>

            <div class="button-group">
                <button type="submit" class="login-button primary" id="submit-button">
                    <i class="fas fa-save" id="submit-icon"></i>
                    <span id="submit-text">Ubah Password</span>
                </button>
                <a href="{{ route('user.login') }}" class="login-button secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Login
                </a>
            </div>
        </form>

        <div class="help-text">
            <i class="fas fa-info-circle"></i>
            Password harus minimal 8 karakter dan mengandung kombinasi huruf, angka, dan karakter khusus untuk keamanan maksimal.
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Debug log untuk memastikan JavaScript loaded
        console.log('Forgot Password page loaded');
        console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const toggleIcon = document.getElementById(`toggle-${fieldId}-icon`);
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            if (type === 'password') {
                toggleIcon.className = 'fas fa-eye';
            } else {
                toggleIcon.className = 'fas fa-eye-slash';
            }
        }

        // Password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;
            const strengthFill = document.getElementById('strength-fill');
            const strengthText = document.getElementById('strength-text');
            const strengthMeter = document.getElementById('password-strength');
            
            if (password.length === 0) {
                strengthMeter.style.display = 'none';
                return;
            }
            
            strengthMeter.style.display = 'block';
            
            // Length check
            if (password.length >= 8) strength += 1;
            if (password.length >= 12) strength += 1;
            
            // Character variety checks
            if (/[a-z]/.test(password)) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            
            // Update visual indicator
            strengthFill.className = 'strength-fill';
            
            if (strength <= 2) {
                strengthFill.classList.add('weak');
                strengthText.textContent = 'Kekuatan password: Lemah';
            } else if (strength <= 4) {
                strengthFill.classList.add('fair');
                strengthText.textContent = 'Kekuatan password: Sedang';
            } else if (strength <= 5) {
                strengthFill.classList.add('good');
                strengthText.textContent = 'Kekuatan password: Baik';
            } else {
                strengthFill.classList.add('strong');
                strengthText.textContent = 'Kekuatan password: Kuat';
            }
            
            return strength;
        }

        // Real-time validation
        function validateField(field, value) {
            const errorElement = document.getElementById(`${field}-error`);
            const inputElement = document.getElementById(field);
            let isValid = true;
            let errorMessage = '';

            switch (field) {
                case 'email':
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!value) {
                        errorMessage = 'Email wajib diisi.';
                        isValid = false;
                    } else if (!emailRegex.test(value)) {
                        errorMessage = 'Format email tidak valid.';
                        isValid = false;
                    }
                    break;

                case 'password':
                    if (!value) {
                        errorMessage = 'Password wajib diisi.';
                        isValid = false;
                    } else if (value.length < 8) {
                        errorMessage = 'Password minimal 8 karakter.';
                        isValid = false;
                    } else {
                        const strength = checkPasswordStrength(value);
                        if (strength < 3) {
                            errorMessage = 'Password terlalu lemah. Gunakan kombinasi huruf besar, kecil, angka, dan simbol.';
                            isValid = false;
                        }
                    }
                    break;

                case 'password_confirmation':
                    const password = document.getElementById('password').value;
                    if (!value) {
                        errorMessage = 'Konfirmasi password wajib diisi.';
                        isValid = false;
                    } else if (value !== password) {
                        errorMessage = 'Konfirmasi password tidak cocok.';
                        isValid = false;
                    }
                    break;
            }

            // Update UI
            if (isValid) {
                inputElement.classList.remove('error');
                errorElement.classList.remove('show');
            } else {
                inputElement.classList.add('error');
                errorElement.textContent = errorMessage;
                errorElement.classList.add('show');
            }

            return isValid;
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded');
            
            const form = document.getElementById('resetPasswordForm');
            const submitButton = document.getElementById('submit-button');
            const submitIcon = document.getElementById('submit-icon');
            const submitText = document.getElementById('submit-text');

            console.log('Form element:', form);
            console.log('Submit button:', submitButton);

            // Real-time validation
            ['email', 'password', 'password_confirmation'].forEach(field => {
                const input = document.getElementById(field);
                if (input) {
                    input.addEventListener('input', function() {
                        validateField(field, this.value);
                    });
                    input.addEventListener('blur', function() {
                        validateField(field, this.value);
                    });
                }
            });

            // Password strength checker
            const passwordField = document.getElementById('password');
            if (passwordField) {
                passwordField.addEventListener('input', function() {
                    checkPasswordStrength(this.value);
                    // Also revalidate password confirmation
                    const confirmPassword = document.getElementById('password_confirmation');
                    if (confirmPassword && confirmPassword.value) {
                        validateField('password_confirmation', confirmPassword.value);
                    }
                });
            }

            // Form submission
            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Form submit event triggered');
                    
                    // Get form data for logging
                    const formData = new FormData(this);
                    console.log('Form data:', {
                        email: formData.get('email'),
                        hasPassword: !!formData.get('password'),
                        hasConfirmation: !!formData.get('password_confirmation'),
                        action: this.action,
                        method: this.method
                    });
                    
                    // Validate all fields
                    const email = document.getElementById('email').value;
                    const password = document.getElementById('password').value;
                    const passwordConfirmation = document.getElementById('password_confirmation').value;
                    
                    const isEmailValid = validateField('email', email);
                    const isPasswordValid = validateField('password', password);
                    const isPasswordConfirmationValid = validateField('password_confirmation', passwordConfirmation);
                    
                    console.log('Validation results:', {
                        email: isEmailValid,
                        password: isPasswordValid,
                        confirmation: isPasswordConfirmationValid
                    });
                    
                    if (isEmailValid && isPasswordValid && isPasswordConfirmationValid) {
                        // Show loading state
                        if (submitButton) {
                            submitButton.disabled = true;
                            submitButton.classList.add('loading');
                            if (submitIcon) submitIcon.className = 'fas fa-spinner';
                            if (submitText) submitText.textContent = 'Memproses...';
                        }
                        
                        console.log('Form validation passed, submitting...');
                        // Form akan submit secara normal
                        return true;
                    } else {
                        e.preventDefault();
                        console.log('Form validation failed');
                        
                        // Focus on first invalid field
                        const firstError = document.querySelector('.login-input.error');
                        if (firstError) {
                            firstError.focus();
                            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                        return false;
                    }
                });
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

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 500);
            });
        }, 5000);
    </script>
</body>

</html>