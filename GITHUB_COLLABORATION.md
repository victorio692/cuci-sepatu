# 🚀 CARA KOLABORASI PROYEK CUCI SEPATU DI GITHUB

## ✅ Status: Repository sudah terhubung ke GitHub
- Remote: `https://github.com/victorio692/cuci-sepatu.git`
- Branch aktif: `feature/booking-system`

---

## 📝 WORKFLOW KOLABORASI

### 1️⃣ SEBELUM MULAI CODING (Setiap Hari)

```bash
# Pull perubahan terbaru dari main
git checkout main
git pull origin main

# Kembali ke branch fitur Anda atau buat baru
git checkout feature/booking-system

# Merge perubahan dari main ke branch Anda
git merge main
```

**Kenapa?** Agar branch Anda selalu update dengan kode terbaru dari teman.

---

### 2️⃣ SAAT CODING

**Commit Sering (Setiap Progress Kecil):**

```bash
# Cek file yang berubah
git status

# Tambahkan file yang ingin di-commit
git add .

# Commit dengan pesan jelas
git commit -m "Implementasi sistem booking lengkap dengan admin dashboard"

# Push ke GitHub
git push origin feature/booking-system
```

**Pesan Commit yang Baik:**
```
✅ BAIK:
- "Tambah form login dengan validasi"
- "Fix bug di booking controller"
- "Update tampilan dashboard admin"

❌ BURUK:
- "update"
- "fix"
- "test"
```

---

### 3️⃣ SETELAH SELESAI FITUR

**Buat Pull Request (PR) di GitHub:**

1. Buka: `https://github.com/victorio692/cuci-sepatu`
2. Klik **"Compare & pull request"** (muncul otomatis setelah push)
3. Tulis deskripsi:
   ```
   ## Fitur Baru: Sistem Booking Lengkap
   
   ### Yang Ditambahkan:
   - Sistem auth (login, register, logout)
   - Dashboard admin dengan sidebar
   - Kelola layanan, booking, pelanggan
   - Dashboard pelanggan dengan navbar
   - Fitur booking cuci sepatu
   
   ### Testing:
   - Login admin: admin / admin123
   - Register pelanggan sudah dicoba
   - Booking flow sudah jalan
   ```
4. Request review dari teman
5. Tunggu approval
6. **Merge** ke main

---

### 4️⃣ HANDLE KONFLIK (Jika Ada)

**Konflik terjadi jika:**
- Kamu dan teman edit file yang sama
- Di line yang sama

**Cara Handle:**

```bash
# Pull perubahan terbaru
git pull origin main

# Git akan show conflict:
# <<<<<<< HEAD
# Kode kamu
# =======
# Kode teman
# >>>>>>> main

# Edit file, pilih kode yang benar atau gabungkan
# Hapus marker <<<<<<, =======, >>>>>>>

# Setelah selesai:
git add .
git commit -m "Resolve merge conflict"
git push origin feature/booking-system
```

**Tips Hindari Konflik:**
- Komunikasi siapa ngerjain file apa
- Jangan edit file yang sama secara bersamaan
- Pull sering dari main

---

## 🎯 STRATEGI BRANCH

### Main Branch
- Branch utama yang **stable**
- Hanya code yang sudah di-review
- Production-ready

### Feature Branch
- Buat branch baru untuk setiap fitur:
  ```bash
  git checkout -b feature/payment-gateway
  git checkout -b feature/email-notification
  git checkout -b fix/login-bug
  ```

- Naming convention:
  - `feature/nama-fitur` - Fitur baru
  - `fix/nama-bug` - Perbaikan bug
  - `improve/nama` - Improvement/refactor

---

## 💡 TIPS KOLABORASI

### ✅ DO (Lakukan):
1. **Pull sebelum push**
   ```bash
   git pull origin main
   git push origin feature/your-branch
   ```

2. **Commit message jelas**
   ```bash
   git commit -m "Tambah validasi email di register form"
   ```

3. **Push setiap hari** (minimal)
   - Agar teman bisa lihat progress
   - Backup code di cloud

4. **Code review**
   - Review PR teman
   - Beri feedback konstruktif

5. **Komunikasi**
   - Bilang kalau mau edit file tertentu
   - Update progress di grup

### ❌ DON'T (Jangan):
1. **Push langsung ke main**
   ```bash
   # JANGAN:
   git push origin main
   
   # LAKUKAN:
   git push origin feature/nama-fitur
   # Lalu buat PR
   ```

2. **Commit code yang error**
   - Test dulu sebelum commit
   - Jangan push code yang break aplikasi

3. **Force push tanpa koordinasi**
   ```bash
   # BERBAHAYA:
   git push -f origin main
   ```

4. **Commit file sensitive**
   - Jangan commit `.env`
   - Jangan commit database password
   - Sudah ada di `.gitignore`

---

## 📁 FILE YANG TIDAK DI-COMMIT

File berikut **JANGAN** di-commit (sudah ada di `.gitignore`):

```
vendor/          # Composer dependencies
.env             # Config database & secrets
writable/        # Cache & logs
.phpunit.result.cache
```

**Setiap anggota harus:**
1. Clone repository
2. `composer install` (install dependencies)
3. Copy `.env.example` ke `.env`
4. Edit `.env` sesuai database lokal

---

## 🔄 CONTOH WORKFLOW LENGKAP

### Scenario: Tambah Fitur Payment

```bash
# 1. Pull update terbaru
git checkout main
git pull origin main

# 2. Buat branch baru
git checkout -b feature/payment-gateway

# 3. Coding...
# (Buat controller, model, view payment)

# 4. Test di local
php spark serve
# Pastikan fitur jalan

# 5. Commit & push
git add .
git commit -m "Implementasi payment gateway dengan Midtrans"
git push origin feature/payment-gateway

# 6. Buat Pull Request di GitHub
# - Review code
# - Fix jika ada revisi
# - Merge ke main

# 7. Update branch main lokal
git checkout main
git pull origin main

# 8. Hapus branch feature (opsional)
git branch -d feature/payment-gateway
```

---

## 🆘 TROUBLESHOOTING

### 1. Error: "Your branch is behind"

```bash
git pull origin main
```

### 2. Error: "Permission denied"

- Pastikan kamu sudah jadi collaborator
- Cek token GitHub atau SSH key

### 3. Error: "Merge conflict"

```bash
# Lihat file yang conflict
git status

# Edit file, hapus marker <<< === >>>
# Save file

git add .
git commit -m "Resolve conflict"
git push
```

### 4. Salah commit, belum push

```bash
# Undo commit terakhir (keep changes)
git reset --soft HEAD~1

# Edit yang salah, commit ulang
git add .
git commit -m "Pesan yang benar"
```

### 5. Sudah push, mau undo

```bash
# Buat commit baru yang undo perubahan
git revert HEAD
git push origin feature/branch-name
```

---

## 📊 MONITOR PROGRESS

### Di GitHub:
- **Issues**: Track bugs & fitur
- **Projects**: Kanban board
- **Pull Requests**: Code review
- **Insights**: Lihat commit history

### Di Local:
```bash
# Lihat commit history
git log --oneline --graph

# Lihat perubahan file
git diff

# Lihat siapa edit file
git blame nama-file.php
```

---

## 🎓 RESOURCES

**Git Basics:**
- [Git Cheat Sheet](https://education.github.com/git-cheat-sheet-education.pdf)
- [GitHub Flow](https://docs.github.com/en/get-started/quickstart/github-flow)

**Best Practices:**
- [Commit Message Convention](https://www.conventionalcommits.org/)
- [GitFlow Workflow](https://www.atlassian.com/git/tutorials/comparing-workflows/gitflow-workflow)

---

## ✅ CHECKLIST SEBELUM PUSH

- [ ] Code sudah di-test di local
- [ ] Tidak ada error/warning
- [ ] Commit message jelas
- [ ] Pull dari main dulu
- [ ] File `.env` tidak ter-commit
- [ ] Code sudah di-review sendiri

---

## 🤝 ATURAN TIM

1. **Jangan edit file yang sedang dikerjakan teman**
2. **Pull dari main setiap hari**
3. **Commit & push minimal 1x sehari**
4. **Buat PR untuk setiap fitur besar**
5. **Review PR teman dalam 24 jam**
6. **Komunikasi aktif di grup**
7. **Backup code Anda (push ke GitHub)**

---

## 📞 KONTAK

Jika ada masalah:
1. Cek dokumentasi ini dulu
2. Google error message
3. Tanya di grup tim
4. Stack Overflow

**Happy Coding! 🚀**
