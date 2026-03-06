// Global logout function for all dashboard pages
function confirmLogout(e) {
    e.preventDefault();
    if (confirm('Apakah Anda yakin ingin keluar?')) {
        window.location.href = '/logout';
    }
}
