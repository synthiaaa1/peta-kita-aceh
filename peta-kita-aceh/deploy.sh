#!/bin/bash
# ==============================================================================
# Script Deployment Server Produksi - PetaKita Aceh
# Menjalankan update aplikasi, clear cache, dan migrasi database.
# ==============================================================================

set -e # Berhenti jika ada error

echo "🚀 Memulai proses deployment PetaKita Aceh..."

# 1. Masuk ke Mode Maintenance
echo "🛠️ Mengaktifkan mode maintenance..."
php artisan down --render="errors::503" || true

# 2. Tarik kode terbaru dari repositori Git
echo "📥 Menarik pembaruan terbaru dari repositori git..."
git pull origin main

# 3. Instal / Update dependensi PHP (Composer)
echo "📦 Memperbarui paket Composer..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# 4. Instal / Update dependensi Node.js
echo "📦 Memperbarui paket NPM dan Build aset..."
npm install
npm run build

# 5. Membersihkan semua cache Laravel
echo "🧹 Membersihkan Cache, Route, dan Config..."
php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear

# 6. Membangun ulang cache untuk performa maksimal di produksi
echo "⚡ Membuat cache baru untuk Route dan Config..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Menjalankan Migrasi Database
echo "🗄️ Menjalankan migrasi database..."
php artisan migrate --force

# 8. Menghidupkan ulang (restart) antrean background (Horizon/Queue)
echo "🔄 Merestart Queue Worker..."
php artisan queue:restart || true

# 9. Keluar dari Mode Maintenance
echo "✅ Menonaktifkan mode maintenance..."
php artisan up

echo "🎉 Deployment selesai dengan sukses!"
