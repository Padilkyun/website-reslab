<?php
require_once __DIR__ . '/php-native/config/database.php';

if (!isset($_GET['id'])) {
    header('Location: ' . BASE_URL . '/project.php');
    exit;
}

$projectId = (int)$_GET['id'];

$pageTitle = 'Detail Project';
include __DIR__ . '/php-native/includes/header.php';
include __DIR__ . '/php-native/includes/navbar.php';
?>

<div class="min-vh-100 py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div id="projectDetailContainer">
                    <div class="text-center">
                        <div class="spinner-border text-light" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="<?php echo BASE_URL; ?>/project.php" class="btn btn-outline-light">
                        ← Kembali ke Project
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function loadProjectDetail() {
    const container = document.getElementById('projectDetailContainer');
    
    try {
        const response = await fetch(`<?php echo BASE_URL; ?>/php-native/api/projects/detail.php?id=<?php echo $projectId; ?>`);
        const project = await response.json();
        
        if (response.ok) {
            container.innerHTML = `
                <article class="glassmorphism-card text-white">
                    ${project.image ? `<img src="<?php echo BASE_URL; ?>/public/uploads/${project.image}" class="img-fluid rounded mb-4" alt="${project.title}">` : ''}
                    <h1 class="display-5 mb-3">${project.title}</h1>
                    <div class="mb-3">
                        <span class="badge bg-primary me-2">${project.type}</span>
                        <span class="text-muted">${formatDate(project.date)}</span>
                    </div>
                    <div class="content">
                        ${project.description}
                    </div>
                </article>
            `;
        } else {
            container.innerHTML = `
                <div class="alert alert-danger">
                    Project tidak ditemukan
                </div>
            `;
        }
    } catch (error) {
        console.error('Error loading project:', error);
        container.innerHTML = `
            <div class="alert alert-danger">
                Error loading project
            </div>
        `;
    }
}

document.addEventListener('DOMContentLoaded', loadProjectDetail);
</script>

<?php include __DIR__ . '/php-native/includes/footer.php'; ?>
