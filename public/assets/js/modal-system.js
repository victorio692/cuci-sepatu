/**
 * Custom Modal System
 * Replaces browser alert() and confirm() with modern, professional modals
 */

class ModalSystem {
    constructor() {
        this.modal = null;
        this.overlay = null;
        this.init();
    }

    init() {
        // Get or create modal elements
        this.modal = document.getElementById('globalModal');
        this.overlay = document.getElementById('globalModalOverlay');
        
        if (!this.modal || !this.overlay) {
            console.warn('Modal elements not found in DOM');
            return;
        }

        // Close on overlay click
        this.overlay.addEventListener('click', () => this.close());
        
        // Close on X button click
        const closeBtn = document.getElementById('modalCloseBtn');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => this.close());
        }

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen()) {
                this.close();
            }
        });
    }

    isOpen() {
        return this.modal && !this.modal.classList.contains('hidden');
    }

    close() {
        if (!this.modal) return;
        
        this.modal.classList.add('hidden');
        this.modal.classList.remove('flex');
        this.overlay.classList.add('hidden');
        this.overlay.classList.remove('opacity-100');
        
        // Reset state
        this.modal.dataset.type = '';
        this.modal.dataset.callback = null;
    }

    show(content, title = '', type = 'info', buttons = {}) {
        if (!this.modal || !this.overlay) {
            console.error('Modal elements not found');
            return;
        }

        // Set modal type
        this.modal.dataset.type = type;

        // Get modal parts
        const titleEl = this.modal.querySelector('.modal-title');
        const contentEl = this.modal.querySelector('.modal-content');
        const iconEl = this.modal.querySelector('.modal-icon');
        const buttonsEl = this.modal.querySelector('.modal-buttons');

        // Update title
        if (titleEl) titleEl.textContent = title;

        // Update content
        if (contentEl) contentEl.textContent = content;

        // Update icon based on type
        if (iconEl) {
            iconEl.className = 'modal-icon w-16 h-16 rounded-full flex items-center justify-center mb-4';
            
            switch(type) {
                case 'success':
                    iconEl.innerHTML = '<i class="fas fa-check text-2xl text-white"></i>';
                    iconEl.classList.add('bg-green-500');
                    break;
                case 'error':
                case 'danger':
                    iconEl.innerHTML = '<i class="fas fa-exclamation-circle text-2xl text-white"></i>';
                    iconEl.classList.add('bg-red-500');
                    break;
                case 'warning':
                    iconEl.innerHTML = '<i class="fas fa-exclamation-triangle text-2xl text-white"></i>';
                    iconEl.classList.add('bg-yellow-500');
                    break;
                case 'info':
                default:
                    iconEl.innerHTML = '<i class="fas fa-info-circle text-2xl text-white"></i>';
                    iconEl.classList.add('bg-blue-500');
                    break;
            }
        }

        // Update buttons
        if (buttonsEl) {
            buttonsEl.innerHTML = '';
            Object.entries(buttons).forEach(([key, config]) => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = config.class || 'px-3 sm:px-5 py-2 sm:py-2.5 rounded-lg font-semibold transition text-xs sm:text-sm whitespace-nowrap';
                btn.textContent = config.text || key;
                // Add explicit inline styles to ensure visibility
                btn.style.display = 'inline-block';
                btn.style.cursor = 'pointer';
                btn.style.border = 'none';
                btn.style.outline = 'none';
                btn.onclick = (e) => {
                    e.preventDefault();
                    if (config.callback) config.callback();
                    if (config.autoClose !== false) this.close();
                };
                buttonsEl.appendChild(btn);
            });
        }

        // Show modal with animation
        this.modal.classList.remove('hidden');
        this.modal.classList.add('flex');
        this.overlay.classList.remove('hidden');
        
        // Trigger animation
        setTimeout(() => {
            this.overlay.classList.add('opacity-100');
            this.modal.querySelector('.modal-content-wrapper')?.classList.remove('scale-95', 'opacity-0');
            this.modal.querySelector('.modal-content-wrapper')?.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    alert(message, title = 'Informasi', callback = null) {
        this.show(message, title, 'info', {
            confirm: {
                text: 'OK',
                class: 'px-6 sm:px-8 py-2.5 sm:py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 hover:shadow-md transition text-xs sm:text-sm border-0',
                callback: callback,
                autoClose: true
            }
        });
    }

    success(message, title = 'Berhasil', callback = null) {
        this.show(message, title, 'success', {
            confirm: {
                text: 'OK',
                class: 'px-6 sm:px-8 py-2.5 sm:py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 hover:shadow-md transition text-xs sm:text-sm border-0',
                callback: callback,
                autoClose: true
            }
        });
    }

    error(message, title = 'Error', callback = null) {
        this.show(message, title, 'error', {
            confirm: {
                text: 'OK',
                class: 'px-6 sm:px-8 py-2.5 sm:py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 hover:shadow-md transition text-xs sm:text-sm border-0',
                callback: callback,
                autoClose: true
            }
        });
    }

    warning(message, title = 'Perhatian', callback = null) {
        this.show(message, title, 'warning', {
            confirm: {
                text: 'OK',
                class: 'px-6 sm:px-8 py-2.5 sm:py-3 bg-amber-500 text-white rounded-lg font-semibold hover:bg-amber-600 hover:shadow-md transition text-xs sm:text-sm border-0',
                callback: callback,
                autoClose: true
            }
        });
    }

    confirm(message, onConfirm, onCancel = null, title = 'Konfirmasi') {
        this.show(message, title, 'warning', {
            confirm: {
                text: 'Ya, Lanjutkan',
                class: 'bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition border-0',
                callback: onConfirm,
                autoClose: true
            }
        });
    }

    danger(message, onConfirm, onCancel = null, title = 'Konfirmasi Penghapusan') {
        this.show(message, title, 'danger', {
            confirm: {
                text: 'Ya, Hapus',
                class: 'bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition border-0',
                callback: onConfirm,
                autoClose: true
            }
        });
    }
}

// Initialize modal system globally
let Modal = null;

function initializeModal() {
    Modal = new ModalSystem();
}

// Check if DOM is already loaded
if (document.readyState === 'loading') {
    // DOM is still loading, wait for DOMContentLoaded
    document.addEventListener('DOMContentLoaded', initializeModal);
} else {
    // DOM is already loaded, initialize immediately
    initializeModal();
}

// Override window alert and confirm for backward compatibility (optional)
// Uncomment if you want to automatically intercept all alert/confirm calls
/*
window.alert = function(message) {
    if (Modal) {
        Modal.alert(message);
    } else {
        console.warn('Modal system not initialized:', message);
    }
};

window.confirm = function(message) {
    if (Modal) {
        return new Promise((resolve) => {
            Modal.confirm(message, () => resolve(true), () => resolve(false));
        });
    }
    return false;
};
*/
