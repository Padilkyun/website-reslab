<?php
require_once __DIR__ . '/php-native/config/database.php';

$pageTitle = 'Admin Login';
$customCSS = '
.login-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
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
    background: linear-gradient(135deg, rgba(249, 115, 22, 0.15), rgba(251, 146, 60, 0.15));
    border-radius: 50%;
    filter: blur(60px);
    animation: float 25s infinite ease-in-out;
}

.shape1 { width: 400px; height: 400px; top: -10%; left: -10%; animation-delay: 0s; }
.shape2 { width: 500px; height: 500px; top: 50%; right: -15%; animation-delay: 8s; }
.shape3 { width: 350px; height: 350px; bottom: -10%; left: 40%; animation-delay: 16s; }

@keyframes float {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(40px, -40px) scale(1.1); }
    66% { transform: translate(-30px, 30px) scale(0.9); }
}

.login-card {
    position: relative;
    z-index: 10;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(30px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 24px;
    padding: 3rem 2.5rem;
    box-shadow: 0 25px 70px rgba(0, 0, 0, 0.6);
    max-width: 420px;
    width: 100%;
    transition: all 0.3s ease;
}

.login-card:hover {
    border-color: rgba(249, 115, 22, 0.3);
    box-shadow: 0 30px 80px rgba(0, 0, 0, 0.7), 0 0 40px rgba(249, 115, 22, 0.1);
}

.brand-logo {
    width: 60px;
    height: 60px;
    margin-bottom: 1.5rem;
    filter: drop-shadow(0 5px 15px rgba(249, 115, 22, 0.4));
}

.login-title {
    font-size: 2rem;
    font-weight: 700;
    background: linear-gradient(135deg, #fff 0%, #f97316 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 0.5rem;
}

.login-subtitle {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.95rem;
    font-weight: 400;
    margin-bottom: 2rem;
}

.form-control {
    background: rgba(255, 255, 255, 0.05);
    border: 1.5px solid rgba(255, 255, 255, 0.1);
    color: white;
    border-radius: 12px;
    padding: 0.85rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(249, 115, 22, 0.6);
    box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
    color: white;
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.4);
}

.form-label {
    color: rgba(255, 255, 255, 0.8);
    font-weight: 500;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.btn-login {
    background: linear-gradient(135deg, #f97316, #fb923c);
    border: none;
    padding: 0.9rem;
    font-weight: 600;
    font-size: 1rem;
    border-radius: 12px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(249, 115, 22, 0.5);
    background: linear-gradient(135deg, #fb923c, #f97316);
}

.back-link {
    color: rgba(255, 255, 255, 0.5);
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.back-link:hover {
    color: #f97316;
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
        <div class="text-center">
            <img src="<?php echo BASE_URL; ?>/public/reslabtrans.png" alt="ResLab" class="brand-logo">
            <h2 class="login-title">Admin Portal</h2>
            <p class="login-subtitle">Secure administrative access</p>
        </div>
        
        <div id="alertContainer"></div>
        
        <form id="adminLoginForm">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter your username" required autofocus>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
            </div>
            
            <button type="submit" class="btn btn-login w-100 text-white mb-3">
                Sign In
            </button>
            
            <div class="text-center">
                <a href="<?php echo BASE_URL; ?>/auth-login.php" class="back-link">
                    ← Back to User Login
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('adminLoginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value;
    const submitBtn = this.querySelector('button[type="submit"]');
    
    if (!username || !password) {
        showAlert('Please fill in all fields', 'danger');
        return;
    }
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Authenticating...';
    
    try {
        const response = await fetch('<?php echo BASE_URL; ?>/php-native/api/auth/admin-login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username, password })
        });
        
        const data = await response.json();
        
        if (response.ok && data.token) {
            const expiryDate = new Date();
            expiryDate.setDate(expiryDate.getDate() + 1);
            document.cookie = `admin_token=${data.token}; path=/; expires=${expiryDate.toUTCString()}; SameSite=Strict`;
            localStorage.setItem('admin', JSON.stringify(data.admin));
            
            showAlert('Authentication successful!', 'success');
            setTimeout(() => window.location.href = '<?php echo BASE_URL; ?>/admin/dashboard.php', 800);
        } else {
            throw new Error(data.error || 'Authentication failed');
        }
    } catch (error) {
        showAlert(error.message, 'danger');
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Sign In';
    }
});

function showAlert(message, type) {
    document.getElementById('alertContainer').innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show mb-3" role="alert" style="border-radius: 12px; border: none; background: rgba(${type === 'success' ? '34, 197, 94' : '239, 68, 68'}, 0.15); color: ${type === 'success' ? '#86efac' : '#fca5a5'};">
            ${message}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    `;
}
</script>

<?php include __DIR__ . '/php-native/includes/footer.php'; ?>
