<?php
require_once __DIR__ . '/php-native/config/database.php';

$pageTitle = 'Sign Up';
$customCSS = '
.signup-container {
    min-height: 100vh;
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
}

.floating-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 0;
}

.shape {
    position: absolute;
    background: linear-gradient(135deg, rgba(249, 115, 22, 0.3), rgba(251, 146, 60, 0.3));
    border-radius: 50%;
    filter: blur(60px);
    animation: float 20s infinite ease-in-out;
}

.shape1 { width: 300px; height: 300px; top: 10%; left: 10%; animation-delay: 0s; }
.shape2 { width: 400px; height: 400px; top: 50%; right: 10%; animation-delay: 5s; }
.shape3 { width: 250px; height: 250px; bottom: 10%; left: 30%; animation-delay: 10s; }

@keyframes float {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    33% { transform: translate(30px, -30px) rotate(120deg); }
    66% { transform: translate(-20px, 20px) rotate(240deg); }
}

.signup-card {
    position: relative;
    z-index: 10;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 24px;
    padding: 3rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
}

/* Dark Form Controls */
.signup-container .form-control {
    background: rgba(255, 255, 255, 0.1) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: white !important;
    border-radius: 12px;
}

.signup-container .form-control:focus {
    background: rgba(255, 255, 255, 0.15) !important;
    border-color: #f97316 !important;
    color: white !important;
    box-shadow: 0 0 0 0.25rem rgba(249, 115, 22, 0.25) !important;
}

.signup-container .form-control::placeholder {
    color: rgba(255, 255, 255, 0.5) !important;
}

.signup-container .form-select {
    background: rgba(255, 255, 255, 0.1) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: white !important;
    border-radius: 12px;
}

.signup-container .form-select:focus {
    background: rgba(255, 255, 255, 0.15) !important;
    border-color: #f97316 !important;
    color: white !important;
    box-shadow: 0 0 0 0.25rem rgba(249, 115, 22, 0.25) !important;
}
';

include __DIR__ . '/php-native/includes/header.php';
include __DIR__ . '/php-native/includes/navbar.php';
?>

<div class="signup-container">
    <div class="floating-shapes">
        <div class="shape shape1"></div>
        <div class="shape shape2"></div>
        <div class="shape shape3"></div>
    </div>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="signup-card">
                    <div class="text-center mb-4">
                        <img src="<?php echo BASE_URL; ?>/public/reslabtrans.png" alt="ResLab" style="width: 70px; height: 70px; margin-bottom: 1rem;">
                        <h2 class="text-white fw-bold mb-2">Create Account</h2>
                        <p class="text-white-50">Join ResLab Community</p>
                    </div>
                    
                    <div id="alertContainer"></div>
                    
                    <form id="signupForm">
                        <div class="mb-3">
                            <label class="form-label text-white">
                                <i class="bi bi-envelope me-2"></i> Email
                            </label>
                            <input type="email" class="form-control" id="email" placeholder="your.email@example.com" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-white">
                                <i class="bi bi-person me-2"></i> Nama Lengkap
                            </label>
                            <input type="text" class="form-control" id="nama" placeholder="Nama lengkap Anda" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white">
                                    <i class="bi bi-credit-card me-2"></i> NIM
                                </label>
                                <input type="text" class="form-control" id="nim" placeholder="NIM" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white">
                                    <i class="bi bi-calendar me-2"></i> Angkatan
                                </label>
                                <input type="text" class="form-control" id="angkatan" placeholder="2024" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white">
                                    <i class="bi bi-123 me-2"></i> Umur
                                </label>
                                <input type="number" class="form-control" id="umur" min="17" max="50" placeholder="20" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white">
                                    <i class="bi bi-heart me-2"></i> Hobi
                                </label>
                                <input type="text" class="form-control" id="hobi" placeholder="Coding, Robotics" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-white">
                                <i class="bi bi-lock me-2"></i> Password
                            </label>
                            <input type="password" class="form-control" id="password" placeholder="Min. 6 karakter" required minlength="6">
                            <small class="text-white-50">Minimal 6 karakter</small>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label text-white">
                                <i class="bi bi-lock-fill me-2"></i> Konfirmasi Password
                            </label>
                            <input type="password" class="form-control" id="confirmPassword" placeholder="Ulangi password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-3 mb-3">
                            <i class="bi bi-person-plus me-2"></i> Sign Up
                        </button>
                        
                        <div class="text-center">
                            <p class="text-white-50 small">
                                Sudah punya akun? 
                                <a href="<?php echo BASE_URL; ?>/auth-login.php" class="text-warning text-decoration-none fw-semibold">Login</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('signupForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const alertContainer = document.getElementById('alertContainer');
    const submitBtn = this.querySelector('button[type="submit"]');
    
    // Validate password match
    if (password !== confirmPassword) {
        showAlert('Password tidak sama!', 'danger');
        return;
    }
    
    // Validate password length
    if (password.length < 6) {
        showAlert('Password minimal 6 karakter!', 'danger');
        return;
    }
    
    const formData = {
        email: document.getElementById('email').value.trim(),
        nama: document.getElementById('nama').value.trim(),
        nim: document.getElementById('nim').value.trim(),
        angkatan: document.getElementById('angkatan').value.trim(),
        umur: parseInt(document.getElementById('umur').value),
        hobi: document.getElementById('hobi').value.trim(),
        password: password
    };
    
    // Disable button
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Mendaftar...';
    
    try {
        const response = await fetch('<?php echo BASE_URL; ?>/php-native/api/auth/signup.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            showAlert(data.message || 'Registrasi berhasil! Redirecting to login...', 'success');
            
            // Reset form
            this.reset();
            
            // Redirect after delay
            setTimeout(() => {
                window.location.href = '<?php echo BASE_URL; ?>/auth-login.php';
            }, 2000);
        } else {
            throw new Error(data.error || 'Registrasi gagal');
        }
    } catch (error) {
        showAlert(error.message, 'danger');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bi bi-person-plus me-2"></i> Sign Up';
    }
});

function showAlert(message, type) {
    const alertContainer = document.getElementById('alertContainer');
    alertContainer.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="bi bi-${type === 'success' ? 'check-circle' : 'x-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Scroll to alert
    alertContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}
</script>

<?php include __DIR__ . '/php-native/includes/footer.php'; ?>
