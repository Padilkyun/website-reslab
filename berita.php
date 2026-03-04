<?php
require_once __DIR__ . '/php-native/config/database.php';

$pageTitle = 'Berita';
include __DIR__ . '/php-native/includes/header.php';
include __DIR__ . '/php-native/includes/navbar.php';
?>

<div class="min-vh-100 py-5">
    <div class="container">
        <h1 class="display-4 text-white text-center mb-5">Berita ResLab</h1>
        
        <div class="row" id="beritaContainer">
            <div class="col-12 text-center">
                <div class="spinner-border text-light" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        
        <!-- Pagination -->
        <nav class="mt-5" id="paginationContainer"></nav>
    </div>
</div>

<script>
let currentPage = 1;
const limit = 9;

async function loadBerita(page = 1) {
    const container = document.getElementById('beritaContainer');
    showLoading(container);
    
    try {
        const response = await fetch(`<?php echo BASE_URL; ?>/php-native/api/berita/index.php?page=${page}&limit=${limit}`);
        const data = await response.json();
        
        if (data.data && data.data.length > 0) {
            container.innerHTML = data.data.map(item => `
                <div class="col-md-4 mb-4">
                    <div class="card glassmorphism border-0 h-100">
                        ${item.image ? `<img src="<?php echo BASE_URL; ?>/public/uploads/${item.image}" class="card-img-top" alt="${item.title}" style="height: 200px; object-fit: cover;">` : '<div class="bg-secondary" style="height: 200px;"></div>'}
                        <div class="card-body text-white">
                            <h5 class="card-title">${item.title}</h5>
                            <p class="card-text small text-muted">${formatDate(item.date)}</p>
                            <p class="card-text">${item.content.substring(0, 100)}...</p>
                            <a href="<?php echo BASE_URL; ?>/berita-detail.php?id=${item.id}" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            `).join('');
            
            // Update pagination
            updatePagination(data.pagination);
        } else {
            container.innerHTML = '<div class="col-12 text-center text-white"><p>Tidak ada berita tersedia</p></div>';
        }
    } catch (error) {
        console.error('Error loading berita:', error);
        container.innerHTML = '<div class="col-12 text-center text-white"><p>Error loading berita</p></div>';
    }
}

function updatePagination(pagination) {
    const container = document.getElementById('paginationContainer');
    
    if (pagination.totalPages <= 1) {
        container.innerHTML = '';
        return;
    }
    
    let paginationHTML = '<ul class="pagination justify-content-center">';
    
    // Previous button
    paginationHTML += `
        <li class="page-item ${pagination.page === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadBerita(${pagination.page - 1}); return false;">Previous</a>
        </li>
    `;
    
    // Page numbers
    for (let i = 1; i <= pagination.totalPages; i++) {
        paginationHTML += `
            <li class="page-item ${i === pagination.page ? 'active' : ''}">
                <a class="page-link" href="#" onclick="loadBerita(${i}); return false;">${i}</a>
            </li>
        `;
    }
    
    // Next button
    paginationHTML += `
        <li class="page-item ${pagination.page === pagination.totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadBerita(${pagination.page + 1}); return false;">Next</a>
        </li>
    `;
    
    paginationHTML += '</ul>';
    container.innerHTML = paginationHTML;
}

// Load initial data
document.addEventListener('DOMContentLoaded', () => {
    loadBerita(currentPage);
});
</script>

<?php include __DIR__ . '/php-native/includes/footer.php'; ?>
