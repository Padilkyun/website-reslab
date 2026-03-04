<?php
require_once __DIR__ . '/php-native/config/database.php';

if (!isset($_GET['id'])) {
    header('Location: ' . BASE_URL . '/berita.php');
    exit;
}

$beritaId = (int)$_GET['id'];

$pageTitle = 'Detail Berita';
include __DIR__ . '/php-native/includes/header.php';
include __DIR__ . '/php-native/includes/navbar.php';
?>

<div class="min-vh-100 py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div id="beritaDetailContainer">
                    <div class="text-center">
                        <div class="spinner-border text-light" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="<?php echo BASE_URL; ?>/berita.php" class="btn btn-outline-light">
                        ← Kembali ke Berita
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function loadBeritaDetail() {
    const container = document.getElementById('beritaDetailContainer');
    
    try {
        const response = await fetch(`<?php echo BASE_URL; ?>/php-native/api/berita/detail.php?id=<?php echo $beritaId; ?>`);
        const berita = await response.json();
        
        if (response.ok) {
            container.innerHTML = `
                <article class="glassmorphism-card text-white">
                    ${berita.image ? `<img src="<?php echo BASE_URL; ?>/public/uploads/${berita.image}" class="img-fluid rounded mb-4" alt="${berita.title}">` : ''}
                    <h1 class="display-5 mb-3">${berita.title}</h1>
                    <p class="text-muted mb-4">${formatDate(berita.date)}</p>
                    <div class="content">
                        ${berita.content}
                    </div>
                </article>
            `;
        } else {
            container.innerHTML = `
                <div class="alert alert-danger">
                    Berita tidak ditemukan
                </div>
            `;
        }
    } catch (error) {
        console.error('Error loading berita:', error);
        container.innerHTML = `
            <div class="alert alert-danger">
                Error loading berita
            </div>
        `;
    }
}

document.addEventListener('DOMContentLoaded', loadBeritaDetail);
</script>

<?php include __DIR__ . '/php-native/includes/footer.php'; ?>
