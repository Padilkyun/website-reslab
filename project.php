<?php
require_once __DIR__ . '/php-native/config/database.php';

$pageTitle = 'Project';
include __DIR__ . '/php-native/includes/header.php';
include __DIR__ . '/php-native/includes/navbar.php';
?>

<div class="min-vh-100 py-5">
    <div class="container">
        <h1 class="display-4 text-white text-center mb-5">Project ResLab</h1>
        
        <!-- Filter by type -->
        <div class="text-center mb-4">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-light" onclick="filterProjects('all')">All</button>
                <button type="button" class="btn btn-outline-light" onclick="filterProjects('research')">Research</button>
                <button type="button" class="btn btn-outline-light" onclick="filterProjects('pengabdian')">Pengabdian</button>
                <button type="button" class="btn btn-outline-light" onclick="filterProjects('product')">Product</button>
            </div>
        </div>
        
        <div class="row" id="projectContainer">
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
let currentFilter = 'all';
const limit = 9;

async function loadProjects(page = 1, filter = 'all') {
    const container = document.getElementById('projectContainer');
    showLoading(container);
    
    try {
        const response = await fetch(`<?php echo BASE_URL; ?>/php-native/api/projects/index.php?page=${page}&limit=${limit}`);
        const data = await response.json();
        
        if (data.data && data.data.length > 0) {
            let filteredData = data.data;
            if (filter !== 'all') {
                filteredData = data.data.filter(item => item.type.toLowerCase() === filter.toLowerCase());
            }
            
            if (filteredData.length > 0) {
                container.innerHTML = filteredData.map(item => `
                    <div class="col-md-4 mb-4">
                        <div class="card glassmorphism border-0 h-100">
                            ${item.image ? `<img src="<?php echo BASE_URL; ?>/public/uploads/${item.image}" class="card-img-top" alt="${item.title}" style="height: 200px; object-fit: cover;">` : '<div class="bg-secondary" style="height: 200px;"></div>'}
                            <div class="card-body text-white">
                                <h5 class="card-title">${item.title}</h5>
                                <span class="badge bg-primary mb-2">${item.type}</span>
                                <p class="card-text small text-muted">${formatDate(item.date)}</p>
                                <p class="card-text">${item.description.substring(0, 100)}...</p>
                                <a href="<?php echo BASE_URL; ?>/project-detail.php?id=${item.id}" class="btn btn-primary btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                `).join('');
            } else {
                container.innerHTML = '<div class="col-12 text-center text-white"><p>Tidak ada project tersedia</p></div>';
            }
            
            // Update pagination
            updatePagination(data.pagination);
        } else {
            container.innerHTML = '<div class="col-12 text-center text-white"><p>Tidak ada project tersedia</p></div>';
        }
    } catch (error) {
        console.error('Error loading projects:', error);
        container.innerHTML = '<div class="col-12 text-center text-white"><p>Error loading projects</p></div>';
    }
}

function filterProjects(type) {
    currentFilter = type;
    currentPage = 1;
    loadProjects(currentPage, currentFilter);
    
    // Update active button
    document.querySelectorAll('.btn-group button').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
}

function updatePagination(pagination) {
    const container = document.getElementById('paginationContainer');
    
    if (pagination.totalPages <= 1) {
        container.innerHTML = '';
        return;
    }
    
    let paginationHTML = '<ul class="pagination justify-content-center">';
    
    paginationHTML += `
        <li class="page-item ${pagination.page === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadProjects(${pagination.page - 1}, '${currentFilter}'); return false;">Previous</a>
        </li>
    `;
    
    for (let i = 1; i <= pagination.totalPages; i++) {
        paginationHTML += `
            <li class="page-item ${i === pagination.page ? 'active' : ''}">
                <a class="page-link" href="#" onclick="loadProjects(${i}, '${currentFilter}'); return false;">${i}</a>
            </li>
        `;
    }
    
    paginationHTML += `
        <li class="page-item ${pagination.page === pagination.totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadProjects(${pagination.page + 1}, '${currentFilter}'); return false;">Next</a>
        </li>
    `;
    
    paginationHTML += '</ul>';
    container.innerHTML = paginationHTML;
}

document.addEventListener('DOMContentLoaded', () => {
    loadProjects(currentPage, currentFilter);
});
</script>

<?php include __DIR__ . '/php-native/includes/footer.php'; ?>
