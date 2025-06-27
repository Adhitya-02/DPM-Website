<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin SIPETA</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    
    <style>
        /* Admin Green Theme */
        body {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            min-height: 100vh;
            font-family: 'Source Sans Pro', sans-serif;
        }
        
        .login-page {
            background: transparent;
        }
        
        .login-box {
            width: 400px;
            margin: 5% auto;
        }
        
        .login-logo a {
            color: white;
            font-size: 2rem;
            font-weight: bold;
            text-decoration: none;
        }
        
        .card {
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: none;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .login-card-body {
            padding: 2.5rem;
            border-radius: 20px;
        }
        
        .logo-container {
            background: linear-gradient(135deg, #28a745, #20c997);
            border-radius: 50%;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
        }
        
        .logo-container img {
            width: 45px;
            height: auto;
        }
        
        .text-login {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .admin-badge {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 0.3rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-block;
            margin-bottom: 1.5rem;
        }
        
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
            background: white;
        }
        
        .input-group-text {
            background: #28a745;
            border: 2px solid #28a745;
            color: white;
            border-radius: 0 12px 12px 0;
            border-left: none;
        }
        
        .input-group .form-control {
            border-right: none;
            border-radius: 12px 0 0 12px;
        }
        
        .btn-admin {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        
        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
            background: linear-gradient(135deg, #218838, #1e7e34);
        }
        
        .btn-admin:active {
            transform: translateY(0);
        }
        
        .login-box-msg {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        
        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .logo-container {
            animation: float 6s ease-in-out infinite;
        }
        
        /* Responsive */
        @media (max-width: 576px) {
            .login-box {
                width: 90%;
                margin: 10% auto;
            }
            
            .login-card-body {
                padding: 2rem 1.5rem;
            }
        }
        
        /* Loading state */
        .btn-admin:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body text-center">
                <div class="logo-container">
                    <img src="{{ asset('dist/img/logo_KabMadiun.gif') }}" alt="Logo">
                </div>
                
                <h4 class="text-login">Dinas Pariwisata Kabupaten Madiun</h4>
                <div class="admin-badge">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Admin Panel
                </div>
                <p class="login-box-msg">Masuk ke panel administrasi untuk mengelola sistem pariwisata</p>

                <form action="{{route('login.store')}}" method="post" id="loginForm">
                    @csrf
                    <div class="input-group mb-3">
                        <input name="email" type="email" class="form-control" placeholder="Email Administrator" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="input-group mb-4">
                        <input name="password" type="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-admin w-100" id="loginBtn">
                            <span class="btn-text">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Masuk ke Admin Panel
                            </span>
                            <span class="btn-loading d-none">
                                <span class="spinner-border spinner-border-sm mr-2"></span>
                                Memproses...
                            </span>
                        </button>
                    </div>
                </form>
                
                <div class="mt-4">
                    <small class="text-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        Akses terbatas untuk administrator sistem
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    
    <script>
        // Form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            const btnText = btn.querySelector('.btn-text');
            const btnLoading = btn.querySelector('.btn-loading');
            
            btn.disabled = true;
            btnText.classList.add('d-none');
            btnLoading.classList.remove('d-none');
        });
        
        // Add some interactive effects
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
    </script>
</body>
</html>