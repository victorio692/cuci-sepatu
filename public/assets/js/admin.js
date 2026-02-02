// Admin Panel JavaScript

// Toggle User Menu
function toggleUserMenu() {
    const menu = document.getElementById('adminUserMenu');
    if (menu) {
        menu.classList.toggle('show');
    }
}

// Close user menu when clicking outside
document.addEventListener('click', (e) => {
    const menu = document.getElementById('adminUserMenu');
    const btn = document.querySelector('.admin-user-btn');
    
    if (menu && btn && !menu.contains(e.target) && !btn.contains(e.target)) {
        menu.classList.remove('show');
    }
});

// Set active menu item
function setActiveMenuItem(pathname) {
    document.querySelectorAll('.menu-item').forEach(item => {
        if (item.getAttribute('href') === pathname) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });
}

// Initialize on load
document.addEventListener('DOMContentLoaded', () => {
    setActiveMenuItem(window.location.pathname);
});

// Booking Badge Update
function updateBookingBadge(count) {
    const badge = document.getElementById('bookingBadge');
    if (badge) {
        badge.textContent = count;
        if (count > 0) {
            badge.style.display = 'inline-block';
        } else {
            badge.style.display = 'none';
        }
    }
}

// Admin API Functions
const AdminAPI = {
    baseURL: '/admin',

    async request(endpoint, options = {}) {
        const url = `${this.baseURL}${endpoint}`;
        const defaultOptions = {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        };

        const finalOptions = { ...defaultOptions, ...options };

        try {
            const response = await fetch(url, finalOptions);
            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'An error occurred');
            }

            return data;
        } catch (error) {
            console.error('API Error:', error);
            showToast(error.message, 'danger');
            throw error;
        }
    },

    get(endpoint) {
        return this.request(endpoint, { method: 'GET' });
    },

    post(endpoint, data) {
        return this.request(endpoint, {
            method: 'POST',
            body: JSON.stringify(data),
        });
    },

    put(endpoint, data) {
        return this.request(endpoint, {
            method: 'PUT',
            body: JSON.stringify(data),
        });
    },

    delete(endpoint) {
        return this.request(endpoint, { method: 'DELETE' });
    },
};

// Admin Utilities
const AdminUtils = {
    // Format currency
    formatCurrency(value) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(value);
    },

    // Format date
    formatDate(date) {
        return new Intl.DateTimeFormat('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        }).format(new Date(date));
    },

    // Format datetime
    formatDateTime(date) {
        return new Intl.DateTimeFormat('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        }).format(new Date(date));
    },

    // Get status badge class
    getStatusBadgeClass(status) {
        const classes = {
            'pending': 'warning',
            'approved': 'info',
            'in_progress': 'info',
            'completed': 'success',
            'cancelled': 'danger',
        };
        return classes[status] || 'primary';
    },

    // Get status label
    getStatusLabel(status) {
        const labels = {
            'pending': 'Menunggu Persetujuan',
            'approved': 'Disetujui',
            'in_progress': 'Sedang Diproses',
            'completed': 'Selesai',
            'cancelled': 'Dibatalkan',
        };
        return labels[status] || status;
    },

    // Confirm action
    confirmAction(message) {
        return confirm(message);
    },

    // Export to CSV
    exportToCSV(filename, data) {
        const csv = this.convertToCSV(data);
        const link = document.createElement('a');
        link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv));
        link.setAttribute('download', filename);
        link.click();
    },

    // Convert data to CSV
    convertToCSV(data) {
        if (!data || data.length === 0) return '';

        const headers = Object.keys(data[0]);
        const csv = [headers.join(',')];

        data.forEach(row => {
            csv.push(headers.map(header => {
                const value = row[header];
                if (typeof value === 'string' && value.includes(',')) {
                    return `"${value}"`;
                }
                return value;
            }).join(','));
        });

        return csv.join('\n');
    },
};

// Print Report Function (Global untuk semua halaman admin)
function cetakLaporan() {
    // Add print date to header
    const header = document.querySelector('.admin-header');
    if (header) {
        const now = new Date();
        const printDate = now.toLocaleDateString('id-ID', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        header.setAttribute('data-print-date', printDate);
    }
    
    // Set page title for print
    const originalTitle = document.title;
    const pageName = document.querySelector('.admin-header h1')?.textContent || 'Laporan';
    document.title = `${pageName} - SYH Cleaning`;
    
    // Add print-specific class to body
    document.body.classList.add('printing');
    
    // Print
    window.print();
    
    // Restore after print
    setTimeout(() => {
        document.title = originalTitle;
        document.body.classList.remove('printing');
    }, 100);
}

// Export for global use
window.AdminAPI = AdminAPI;
window.AdminUtils = AdminUtils;
window.toggleUserMenu = toggleUserMenu;
window.updateBookingBadge = updateBookingBadge;
window.cetakLaporan = cetakLaporan;
