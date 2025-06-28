# 🏛️ Sistem Pariwisata Kabupaten Madiun

<p align="center">
<img src="https://img.shields.io/badge/Laravel-11.x-red?style=for-the-badge&logo=laravel" alt="Laravel">
<img src="https://img.shields.io/badge/PHP-8.2+-blue?style=for-the-badge&logo=php" alt="PHP">
<img src="https://img.shields.io/badge/MySQL-8.0+-orange?style=for-the-badge&logo=mysql" alt="MySQL">
<img src="https://img.shields.io/badge/Bootstrap-5.3-purple?style=for-the-badge&logo=bootstrap" alt="Bootstrap">
</p>

## 📖 Tentang Proyek

**Sistem Pariwisata Kabupaten Madiun** adalah aplikasi web yang dirancang untuk memudahkan wisatawan dalam menjelajahi dan memesan destinasi wisata di Kabupaten Madiun. Sistem ini menyediakan platform terintegrasi untuk booking tiket, manajemen destinasi wisata, dan layanan terkait pariwisata.

### ✨ Fitur Utama

- 🎫 **Sistem Booking Online** - Pemesanan tiket destinasi wisata dengan pembayaran digital
- 💳 **Integrasi Midtrans** - Payment gateway untuk transaksi yang aman
- 📱 **QR Code Tiket** - Tiket digital dengan QR code untuk validasi masuk
- ⭐ **Review & Rating** - Sistem ulasan dan rating untuk destinasi wisata
- 🔍 **Smart Search** - Pencarian destinasi dengan fuzzy search algorithm
- 📊 **Dashboard Admin** - Panel administrasi untuk manajemen data
- 📈 **Laporan Analytics** - Laporan pengunjung dan revenue analytics
- 🗺️ **Maps Integration** - Integrasi peta untuk lokasi destinasi
- 📱 **Responsive Design** - Tampilan yang optimal di semua perangkat

## 🛠️ Teknologi yang Digunakan

### Backend
- **Laravel 11.x** - PHP Framework
- **MySQL** - Database Management System
- **Eloquent ORM** - Database abstraction layer

### Frontend
- **HTML5 & CSS3** - Markup & Styling
- **JavaScript ES6+** - Interactive functionality
- **Bootstrap 5** - CSS Framework
- **Font Awesome** - Icon library

### Integrasi Third-Party
- **Midtrans** - Payment Gateway
- **QR Code Generator** - Untuk tiket digital
- **Google Maps API** - Integrasi peta (opsional)

## 🚀 Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL >= 8.0
- Web Server (Apache/Nginx)

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone https://github.com/Adhitya-02/DPM-Website.git
cd DPM-Website
```

2. **Install Dependencies**
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

3. **Environment Setup**
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

4. **Database Configuration**
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_pariwisata
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Midtrans Configuration**
Tambahkan konfigurasi Midtrans di `.env`:
```env
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
```

6. **Database Migration**
```bash
# Run migrations
php artisan migrate

# Seed initial data (optional)
php artisan db:seed
```

7. **Storage Link**
```bash
php artisan storage:link
```

8. **Compile Assets**
```bash
npm run build
```

9. **Start Development Server**
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 📁 Struktur Proyek

```
DPM-Website/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/              # Eloquent Models
│   └── Providers/           # Service Providers
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   ├── views/              # Blade templates
│   └── assets/             # CSS, JS, images
├── routes/
│   └── web.php             # Web routes
├── public/                 # Public assets
└── storage/               # File storage
```

## 🎯 Cara Penggunaan

### Untuk Pengunjung/Wisatawan:
1. **Browse Destinasi** - Jelajahi berbagai destinasi wisata yang tersedia
2. **Search & Filter** - Gunakan fitur pencarian untuk menemukan destinasi favorit
3. **Booking Tiket** - Pesan tiket dengan mudah melalui sistem online
4. **Pembayaran** - Lakukan pembayaran aman melalui Midtrans
5. **QR Code Tiket** - Dapatkan tiket digital dengan QR code
6. **Review** - Berikan ulasan dan rating setelah berkunjung

### Untuk Administrator:
1. **Login Admin** - Akses panel admin di `/admin/login`
2. **Manajemen Destinasi** - Tambah, edit, hapus destinasi wisata
3. **Manajemen User** - Kelola data pengguna dan tenant
4. **Monitor Booking** - Pantau pemesanan dan transaksi
5. **Laporan** - Lihat analytics dan laporan keuangan

## 🧪 Testing

```bash
# Run PHPUnit tests
php artisan test

# Run specific test file
php artisan test tests/Feature/BookingTest.php
```

## 📊 Database Schema

### Tabel Utama:
- `users` - Data pengguna
- `tenant` - Data destinasi wisata
- `tipe_tenant` - Kategori destinasi (wisata, hotel, restoran)
- `user_tenant_booking` - Data booking/pemesanan
- `user_tenant_rating` - Rating dari pengguna
- `ulasan_tenant` - Ulasan/review
- `gambar_tenant` - Gambar destinasi

## 🔧 Konfigurasi Tambahan

### SSL Configuration (Development)
Jika mengalami masalah SSL dengan Midtrans:
```env
CURL_CA_BUNDLE_PATH=
SSL_VERIFY_PEER=false
SSL_VERIFY_HOST=false
```

### File Upload Limits
Sesuaikan `php.ini` untuk upload gambar:
```ini
upload_max_filesize = 10M
post_max_size = 10M
```

## 🤝 Kontribusi

Kami menyambut kontribusi dari komunitas! Silakan ikuti langkah berikut:

1. Fork repository ini
2. Buat branch feature (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📝 Changelog

### v1.0.0 (2024)
- ✅ Sistem booking online
- ✅ Integrasi Midtrans payment
- ✅ QR Code tiket digital
- ✅ Review & rating system
- ✅ Admin dashboard
- ✅ Responsive design

## 🐛 Bug Reports & Feature Requests

Jika Anda menemukan bug atau ingin mengusulkan fitur baru, silakan buat issue di [GitHub Issues](https://github.com/Adhitya-02/DPM-Website/issues).

## 📄 License

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

## 👨‍💻 Developer

- **Shenia** - *Backend Developer* - [@shenialusi](https://github.com/shenialusi)
- **Adhitya** - *Frontend Developer* - [@Adhitya-02](https://github.com/Adhitya-02)

## 📞 Kontak

- **Email**: -
- **GitHub**: [@Adhitya-02](https://github.com/Adhitya-02)
- **Repository**: [DPM-Website](https://github.com/Adhitya-02/DPM-Website)

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP Framework for Web Artisans
- [Midtrans](https://midtrans.com) - Payment Gateway Indonesia
- [Bootstrap](https://getbootstrap.com) - CSS Framework
- [Font Awesome](https://fontawesome.com) - Icon Library

---

<p align="center">
Dibuat dengan ❤️ untuk memajukan pariwisata Kabupaten Madiun
</p>