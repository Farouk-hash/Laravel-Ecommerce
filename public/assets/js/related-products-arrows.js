
// related-products.js
let currentRelatedPage = 0;
let itemsPerPage = 3; // Show 3 products at a time
let totalRelatedProducts = 0;
let maxPages = 0;

function initializeRelatedProductsNavigation() {
    // Get total products from data attribute
    const container = document.getElementById('relatedProductsContainer');
    if (container) {
        totalRelatedProducts = parseInt(container.dataset.totalProducts) || 0;
    }
    
    // Adjust items per page based on screen size
    if (window.innerWidth < 768) {
        itemsPerPage = 1;
    } else if (window.innerWidth < 992) {
        itemsPerPage = 2;
    } else {
        itemsPerPage = 3;
    }
    
    maxPages = Math.ceil(totalRelatedProducts / itemsPerPage);
    
    // Generate pagination dots
    generatePaginationDots();
    
    // Update navigation
    updateRelatedProductsView();
    updateNavigationButtons();
}

function navigateRelatedProducts(direction) {
    if (direction === 'next' && currentRelatedPage < maxPages - 1) {
        currentRelatedPage++;
    } else if (direction === 'prev' && currentRelatedPage > 0) {
        currentRelatedPage--;
    }
    
    updateRelatedProductsView();
    updateNavigationButtons();
    updatePaginationDots();
}

function goToRelatedPage(pageIndex) {
    currentRelatedPage = pageIndex;
    updateRelatedProductsView();
    updateNavigationButtons();
    updatePaginationDots();
}

function updateRelatedProductsView() {
    // Show/hide products based on current page
    const allProducts = document.querySelectorAll('.related-product-item');
    
    allProducts.forEach((product, index) => {
        const startIndex = currentRelatedPage * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        
        if (index >= startIndex && index < endIndex) {
            product.style.display = 'block';
            product.style.opacity = '1';
            product.style.visibility = 'visible';
        } else {
            product.style.display = 'none';
            product.style.opacity = '0';
            product.style.visibility = 'hidden';
        }
    });
    
    // Optional: Add smooth transition effect
    const container = document.getElementById('relatedProductsSlider');
    if (container) {
        container.style.transition = 'opacity 0.3s ease-in-out';
        container.style.opacity = '0';
        
        setTimeout(() => {
            container.style.opacity = '1';
        }, 50);
    }
}

function updateNavigationButtons() {
    const prevBtn = document.getElementById('prevRelatedBtn');
    const nextBtn = document.getElementById('nextRelatedBtn');
    
    if (prevBtn && nextBtn) {
        prevBtn.disabled = currentRelatedPage === 0;
        nextBtn.disabled = currentRelatedPage === maxPages - 1;
        
        // Hide navigation if only one page
        if (maxPages <= 1) {
            prevBtn.style.display = 'none';
            nextBtn.style.display = 'none';
        } else {
            prevBtn.style.display = 'block';
            nextBtn.style.display = 'block';
        }
    }
}

function generatePaginationDots() {
    const dotsContainer = document.getElementById('relatedProductsDots');
    if (!dotsContainer) return;
    
    dotsContainer.innerHTML = '';
    
    if (maxPages <= 1) return;
    
    for (let i = 0; i < maxPages; i++) {
        const dot = document.createElement('span');
        dot.className = 'dot';
        dot.onclick = () => goToRelatedPage(i);
        dotsContainer.appendChild(dot);
    }
}

function updatePaginationDots() {
    const dots = document.querySelectorAll('.related-products-dots .dot');
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentRelatedPage);
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Add a small delay to ensure DOM is fully loaded
    setTimeout(() => {
        initializeRelatedProductsNavigation();
    }, 100);
});

// Re-initialize on window resize
window.addEventListener('resize', function() {
    clearTimeout(window.resizeTimer);
    window.resizeTimer = setTimeout(() => {
        initializeRelatedProductsNavigation();
    }, 250);
});

// Keyboard navigation for related products
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey) { // Only when Ctrl is pressed to avoid conflicts
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            navigateRelatedProducts('prev');
        }
        if (e.key === 'ArrowRight') {
            e.preventDefault();
            navigateRelatedProducts('next');
        }
    }
});
