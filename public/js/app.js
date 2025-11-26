// ===== FUNCIONES GLOBALES =====

// Inicializar tooltips de Bootstrap
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Animación de contadores
function animateCounter(element, target, duration = 2000) {
    let start = 0;
    const increment = target / (duration / 16);
    const timer = setInterval(() => {
        start += increment;
        if (start >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(start);
        }
    }, 16);
}

// Inicializar contadores en las tarjetas de estadísticas
function initializeCounters() {
    const counterElements = document.querySelectorAll('[data-counter]');
    counterElements.forEach(element => {
        const target = parseInt(element.getAttribute('data-counter'));
        if (!isNaN(target)) {
            animateCounter(element, target);
        }
    });
}

// Efecto de carga suave para las tarjetas
function initializeCardAnimations() {
    const cards = document.querySelectorAll('.card-custom');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
}

// Manejo de errores de imágenes
function handleImageErrors() {
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('error', function() {
            this.style.display = 'none';
            const placeholder = this.nextElementSibling;
            if (placeholder && placeholder.classList.contains('image-placeholder')) {
                placeholder.style.display = 'flex';
            }
        });
    });
}

// Confirmación para acciones destructivas
function initializeConfirmations() {
    const deleteButtons = document.querySelectorAll('[data-confirm]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const message = this.getAttribute('data-confirm') || '¿Estás seguro de que quieres realizar esta acción?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
}

// Filtrado de tablas
function initializeTableFilters() {
    const filterInputs = document.querySelectorAll('[data-table-filter]');
    filterInputs.forEach(input => {
        input.addEventListener('input', function() {
            const filterValue = this.value.toLowerCase();
            const tableId = this.getAttribute('data-table-filter');
            const table = document.getElementById(tableId);
            if (table) {
                const rows = table.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(filterValue) ? '' : 'none';
                });
            }
        });
    });
}

// Actualización de badges de estado en tiempo real
function updateStatusBadges() {
    const badges = document.querySelectorAll('.badge-reporte');
    badges.forEach(badge => {
        const status = badge.textContent.trim().toLowerCase();
        badge.className = 'badge badge-reporte'; // Reset classes
        
        switch(status) {
            case 'pendiente':
                badge.classList.add('badge-warning');
                break;
            case 'completado':
                badge.classList.add('badge-success');
                break;
            case 'credencial':
                badge.classList.add('badge-credencial');
                break;
            case 'uniforme':
                badge.classList.add('badge-uniforme');
                break;
            case 'cabello':
                badge.classList.add('badge-cabello');
                break;
            case 'otro':
                badge.classList.add('badge-otro');
                break;
        }
    });
}

// Notificaciones toast personalizadas
function showToast(message, type = 'info') {
    const toastContainer = document.getElementById('toast-container') || createToastContainer();
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} alert-custom fade-in-up`;
    toast.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
            <span>${message}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 5000);
}

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
    `;
    document.body.appendChild(container);
    return container;
}

// ===== INICIALIZACIÓN AL CARGAR EL DOCUMENTO =====
document.addEventListener('DOMContentLoaded', function() {
    initializeTooltips();
    initializeCounters();
    initializeCardAnimations();
    handleImageErrors();
    initializeConfirmations();
    initializeTableFilters();
    updateStatusBadges();
    
    console.log('✅ Sistema de alumnos inicializado correctamente');
});

// ===== FUNCIONES GLOBALES PARA USO EN VISTAS =====
window.App = {
    showToast,
    animateCounter,
    updateStatusBadges
};