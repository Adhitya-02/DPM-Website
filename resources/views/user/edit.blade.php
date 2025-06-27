@extends('layout')
@section('content')
<style>
    .password-requirements {
        background: #f8f9fa;
        border-left: 4px solid var(--primary-green);
        padding: 1rem;
        border-radius: 0 8px 8px 0;
        margin-top: 1rem;
    }
    
    .password-strength {
        margin-top: 0.5rem;
        font-size: 0.875rem;
    }
    
    .strength-weak { color: #dc3545; }
    .strength-medium { color: #ffc107; }
    .strength-strong { color: #28a745; }
    
    .form-control:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    
    .input-group-text {
        cursor: pointer;
        background: #f8f9fa;
        border-left: none;
        transition: all 0.3s ease;
    }
    
    .input-group-text:hover {
        background: #e9ecef;
    }
    
    .input-group .form-control {
        border-right: none;
    }
    
    .requirement-item {
        padding: 0.25rem 0;
        font-size: 0.875rem;
    }
    
    .requirement-item.valid {
        color: #28a745;
    }
    
    .requirement-item.invalid {
        color: #6c757d;
    }
    
    .user-info {
        background: linear-gradient(135deg, #e8f5e8, #f0f9f0);
        border: 1px solid #c3e6cb;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, var(--dark-green), var(--primary-green));
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }
    
    .alert {
        border-radius: 8px;
        border: none;
    }
    
    .alert-success {
        background: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }
    
    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }
</style>

<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <i class="fas fa-key mr-3"></i>
            <div>
                <h3 class="card-title mb-0">Ubah Password Admin</h3>
                <small class="text-white-50">Ganti password untuk meningkatkan keamanan akun</small>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <!-- User Info -->
        <div class="user-info">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="mb-1"><i class="fas fa-user-shield text-success mr-2"></i>Akun yang sedang login:</h6>
                    <strong>{{ auth()->user()->nama ?? 'Administrator' }} - {{ auth()->user()->email }}</strong>
                </div>
                <div class="col-md-4 text-right">
                    <span class="badge badge-success">Status: Aktif</span>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h6><i class="fas fa-check-circle mr-2"></i>Berhasil!</h6>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h6><i class="fas fa-exclamation-triangle mr-2"></i>Terjadi Kesalahan!</h6>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.update', auth()->user()->id) }}" method="POST" id="changePasswordForm">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <!-- Current Password -->
                    <div class="form-group">
                        <label for="current_password">
                            <i class="fas fa-lock mr-2"></i>Password Saat Ini
                        </label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control" 
                                   id="current_password" 
                                   name="current_password" 
                                   placeholder="Masukkan password saat ini"
                                   required>
                            <div class="input-group-append">
                                <span class="input-group-text" onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye" id="current_password_eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-key mr-2"></i>Password Baru
                        </label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Masukkan password baru"
                                   required>
                            <div class="input-group-append">
                                <span class="input-group-text" onclick="togglePassword('password')">
                                    <i class="fas fa-eye" id="password_eye"></i>
                                </span>
                            </div>
                        </div>
                        <div class="password-strength" id="passwordStrength"></div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation">
                            <i class="fas fa-check-double mr-2"></i>Konfirmasi Password Baru
                        </label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Ulangi password baru"
                                   required>
                            <div class="input-group-append">
                                <span class="input-group-text" onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye" id="password_confirmation_eye"></i>
                                </span>
                            </div>
                        </div>
                        <div id="passwordMatch" class="mt-2"></div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="form-group mt-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary mr-3" id="submitBtn">
                                <i class="fas fa-save mr-2"></i>
                                Ubah Password
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                <i class="fas fa-undo mr-2"></i>
                                Reset Form
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="password-requirements">
                        <h6><i class="fas fa-info-circle mr-2"></i>Persyaratan Password:</h6>
                        <div class="requirement-item" id="req-length">
                            <i class="fas fa-times mr-2"></i>Minimal 8 karakter
                        </div>
                        <div class="requirement-item" id="req-upper">
                            <i class="fas fa-times mr-2"></i>Mengandung huruf besar (A-Z)
                        </div>
                        <div class="requirement-item" id="req-lower">
                            <i class="fas fa-times mr-2"></i>Mengandung huruf kecil (a-z)
                        </div>
                        <div class="requirement-item" id="req-number">
                            <i class="fas fa-times mr-2"></i>Mengandung angka (0-9)
                        </div>
                        <div class="requirement-item" id="req-special">
                            <i class="fas fa-times mr-2"></i>Karakter khusus (!@#$%^&*)
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Toggle password visibility
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const eye = document.getElementById(fieldId + '_eye');
        
        if (field.type === 'password') {
            field.type = 'text';
            eye.classList.remove('fa-eye');
            eye.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            eye.classList.remove('fa-eye-slash');
            eye.classList.add('fa-eye');
        }
    }

    // Check password requirements
    function checkPasswordRequirements(password) {
        const requirements = {
            length: password.length >= 8,
            upper: /[A-Z]/.test(password),
            lower: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
        };

        // Update requirement display
        Object.keys(requirements).forEach(req => {
            const element = document.getElementById(`req-${req}`);
            const icon = element.querySelector('i');
            
            if (requirements[req]) {
                element.classList.add('valid');
                element.classList.remove('invalid');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-check');
            } else {
                element.classList.add('invalid');
                element.classList.remove('valid');
                icon.classList.remove('fa-check');
                icon.classList.add('fa-times');
            }
        });

        // Calculate strength
        const validCount = Object.values(requirements).filter(Boolean).length;
        let strengthText = '';
        
        if (validCount < 3) {
            strengthText = '<span class="strength-weak"><i class="fas fa-exclamation-triangle mr-1"></i>Lemah</span>';
        } else if (validCount < 5) {
            strengthText = '<span class="strength-medium"><i class="fas fa-exclamation-circle mr-1"></i>Sedang</span>';
        } else {
            strengthText = '<span class="strength-strong"><i class="fas fa-check-circle mr-1"></i>Kuat</span>';
        }
        
        document.getElementById('passwordStrength').innerHTML = strengthText;
        return validCount === 5;
    }

    // Check password match
    function checkPasswordMatch() {
        const newPassword = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        const matchDiv = document.getElementById('passwordMatch');
        
        if (confirmPassword.length > 0) {
            if (newPassword === confirmPassword) {
                matchDiv.innerHTML = '<small class="text-success"><i class="fas fa-check mr-1"></i>Password cocok</small>';
                return true;
            } else {
                matchDiv.innerHTML = '<small class="text-danger"><i class="fas fa-times mr-1"></i>Password tidak cocok</small>';
                return false;
            }
        } else {
            matchDiv.innerHTML = '';
            return false;
        }
    }

    // Event listeners
    document.getElementById('password').addEventListener('input', function() {
        checkPasswordRequirements(this.value);
        if (document.getElementById('password_confirmation').value) {
            checkPasswordMatch();
        }
    });

    document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);

    // Form validation
    document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
        const newPassword = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        const currentPassword = document.getElementById('current_password').value;
        
        // Check if all fields are filled
        if (!currentPassword || !newPassword || !confirmPassword) {
            e.preventDefault();
            alert('Semua field password harus diisi!');
            return;
        }
        
        // Check password match
        if (newPassword !== confirmPassword) {
            e.preventDefault();
            alert('Password baru dan konfirmasi password tidak cocok!');
            return;
        }
        
        // Check password strength
        if (!checkPasswordRequirements(newPassword)) {
            e.preventDefault();
            alert('Password baru harus memenuhi semua persyaratan!');
            return;
        }
        
        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
    });

    // Reset form function
    function resetForm() {
        document.getElementById('changePasswordForm').reset();
        document.getElementById('passwordStrength').innerHTML = '';
        document.getElementById('passwordMatch').innerHTML = '';
        
        // Reset requirements display
        ['length', 'upper', 'lower', 'number', 'special'].forEach(req => {
            const element = document.getElementById(`req-${req}`);
            const icon = element.querySelector('i');
            element.classList.remove('valid');
            element.classList.add('invalid');
            icon.classList.remove('fa-check');
            icon.classList.add('fa-times');
        });
    }
</script>
@endsection