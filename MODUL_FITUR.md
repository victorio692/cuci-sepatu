# 📚 Modul, Fitur, dan SubFitur - Proyek Cuci Sepatu (SYH Cleaning)

Dokumentasi ringkas modul → fitur → subfitur beserta deskripsi berdasarkan implementasi aplikasi ini (frontend + admin + backend dasar).

| Modul | Fitur | SubFitur | Deskripsi |
| --- | --- | --- | --- |
| Autentikasi | Login | Validasi kredensial, remember me, session | Pengguna dan admin masuk menggunakan email & password dengan sesi aman. |
| Autentikasi | Registrasi | Form register dengan validasi | Membuat akun baru, validasi email/telepon, hashing password. |
| Autentikasi | Logout | Hapus sesi | Mengakhiri sesi dan mengarahkan kembali ke halaman utama. |
| Dashboard Pengguna | Ringkasan | Statistik pesanan & pengeluaran | Menampilkan total pesanan, status, dan total pengeluaran user. |
| Dashboard Pengguna | Pesanan Terbaru | Tabel recent bookings | Daftar pesanan terakhir dengan status dan aksi cepat. |
| Booking | Form Pemesanan | Multi-step (layanan, detail sepatu, pengiriman) | Pemesanan layanan (6 opsi), pilih tipe/kondisi sepatu, jumlah, catatan, ongkir & jadwal. |
| Booking | Riwayat Pesanan | Daftar & status | Halaman `my-bookings` untuk melihat status/riwayat pesanan. |
| Booking | Detail Pesanan | Detail per pesanan | Melihat rincian lengkap pesanan tertentu. |
| Profil Pengguna | Kelola Profil | Edit data diri & alamat | Memperbarui nama, kontak, alamat, dan preferensi. |
| Profil Pengguna | Ganti Password | Modal ubah sandi | Mengganti password dengan validasi kekuatan sandi. |
| Halaman Publik | Informasi | Home, Tentang, Kontak, Privacy, Terms | Informasi bisnis, form kontak, kebijakan privasi, syarat ketentuan. |
| Admin Dashboard | Overview | Kartu statistik & grafik singkat | Total pengguna, pesanan, completed, revenue, pending. |
| Admin Pesanan | Manajemen Pesanan | List, pencarian, filter status | Admin mengelola semua pesanan dengan pencarian & filter. |
| Admin Pesanan | Update Status | Ubah status inline | Mengubah status pesanan (pending → approved → in_progress → completed/cancelled). |
| Admin Pesanan | Detail Pesanan | Timeline & detail | Detail pesanan + timeline progres, info user, biaya. |
| Admin Pengguna | Manajemen Pengguna | List & toggle status | Meninjau user, aktif/nonaktifkan akun. |
| Admin Pengguna | Detail Pengguna | Profil & riwayat | Detail user lengkap dengan riwayat pesanan. |
| Admin Layanan | Daftar Layanan | Grid layanan | Menampilkan kartu layanan (Fast/Deep/White Shoes/Coating/Dyeing/Repair). |
| Admin Layanan | Edit Harga | Modal update harga | Memperbarui harga layanan melalui modal. |
| Frontend UI/UX | Responsif & Komponen | Navbar, sidebar, cards, tables, modals | Desain responsif, animasi halus, utilitas UI siap pakai. |
| Keamanan | Proteksi | CSRF, session, auth filter | Form dilindungi CSRF, route protected untuk user/admin. |
