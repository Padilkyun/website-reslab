<?php
require_once __DIR__ . '/php-native/config/database.php';

$pageTitle = 'Login';
$customCSS = '
.login-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
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

.login-card {
    position: relative;
    z-index: 10;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 24px;
    padding: 3rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    max-width: 450px;
    width: 100%;
}

/* Dark Form Controls */
.login-card .form-control {
    background: rgba(255, 255, 255, 0.1) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: white !important;
    border-radius: 12px;
}

.login-card .form-control:focus {
    background: rgba(255, 255, 255, 0.15) !important;
    border-color: #f97316 !important;
    color: white !important;
    box-shadow: 0 0 0 0.25rem rgba(249, 115, 22, 0.25) !important;
}

.login-card .form-control::placeholder {
    color: rgba(255, 255, 255, 0.5) !important;
}

.login-card .form-check-input {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.login-card .form-check-input:checked {
    background-color: #f97316;
    border-color: #f97316;
}
';

include __DIR__ . '/php-native/includes/header.php';
?>

<div class="login-container">
    <div class="floating-shapes">
        <div class="shape shape1"></div>
        <div class="shape shape2"></div>
        <div class="shape shape3"></div>
    </div>
    
    <div class="login-card">
        <div class="text-center mb-4">
            <img src="<?php echo BASE_URL; ?>/public/reslabtrans.png" alt="ResLab" style="width: 80px; height: 80px; margin-bottom: 1rem;">
            <h2 class="text-white fw-bold mb-2">Welcome Back</h2>
            <p class="text-white-50">Login to your ResLab account</p>
        </div>
        
        <div id="alertContainer"></div>
        
        <form id="loginForm">
            <div class="mb-4">
                <label class="form-label text-white">
                    <i class="bi bi-envelope me-2"></i> Email Address
                </label>
                <input type="email" class="form-control" id="email" placeholder="your.email@example.com" required autofocus>
            </div>
            
            <div class="mb-4">
                <label class="form-label text-white">
                    <i class="bi bi-lock me-2"></i> Password
                </label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
            </div>
            
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="remember">
                <label class="form-check-label text-white-50 small" for="remember">
                    Remember me
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 py-3 mb-3">
                <i class="bi bi-box-arrow-in-right me-2"></i> Login
            </button>
            
            <div class="text-center">
                <p class="text-white-50 small mb-2">
                    Don't have an account? 
                    <a href="<?php echo BASE_URL; ?>/auth-signup.php" class="text-warning text-decoration-none fw-semibold">Sign Up</a>
                </p>
                <p class="text-white-50 small">
                    <a href="<?php echo BASE_URL; ?>/admin-login.php" class="text-warning text-decoration-none">
                        <i class="bi bi-shield-lock me-1"></i> Admin Login
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const alertContainer = document.getElementById('alertContainer');
    const submitBtn = this.querySelector('button[type="submit"]');
    
    // Validation
    if (!email || !password) {
        showAlert('Please fill in all fields', 'danger');
        return;
    }
    
    // Disable button
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Logging in...';
    
    try {
        const response = await fetch('<?php echo BASE_URL; ?>/php-native/api/auth/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });
        
        const data = await response.json();
        
        if (response.ok && data.token) {
            // Store token in cookie (1 day expiry)
            const expiryDate = new Date();
            expiryDate.setDate(expiryDate.getDate() + 1);
            document.cookie = `auth_token=${data.token}; path=/; expires=${expiryDate.toUTCString()}; SameSite=Strict`;
            
            // Store user info in localStorage
            localStorage.setItem('user', JSON.stringify(data.user));
            
            showAlert('Login successful! Redirecting...', 'success');
            
            // Redirect after delay
            setTimeout(() => {
                const urlParams = new URLSearchParams(window.location.search);
                const redirect = urlParams.get('redirect');
                window.location.href = redirect ? `<?php echo BASE_URL; ?>/${redirect}.php` : '<?php echo BASE_URL; ?>/index.php';
            }, 1000);
        } else {
            throw new Error(data.error || 'Login failed');
        }
    } catch (error) {
        showAlert(error.message, 'danger');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i> Login';
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
}
</script>

<?php include __DIR__ . '/php-native/includes/footer.php'; ?>
