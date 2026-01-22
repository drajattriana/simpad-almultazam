<?php
// Aktifkan semua laporan error untuk melihat masalah sekecil apapun
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Tes Diagnostik GD Library untuk PNG</h1>";
echo "Mencoba membuat gambar PNG sederhana dari nol...<br><br>";

// Tentukan path untuk menyimpan file hasil tes
$outputFile = __DIR__ . '/upload/test_hasil.png';

// Buat resource gambar kosong berukuran 100x50 piksel
$image = @imagecreatetruecolor(100, 50);

if ($image === false) {
    die("<strong>GAGAL FATAL:</strong> Fungsi <code>imagecreatetruecolor()</code> gagal. Instalasi GD Anda rusak parah. Tidak perlu melanjutkan.");
}

// Siapkan warna (latar belakang biru, tulisan putih)
$backgroundColor = imagecolorallocate($image, 25, 118, 210); // Biru
$textColor = imagecolorallocate($image, 255, 255, 255); // Putih

// Isi latar belakang dengan warna biru
imagefill($image, 0, 0, $backgroundColor);

// Tulis teks "OK" di gambar
imagestring($image, 5, 38, 15, 'OK', $textColor);

// Coba simpan gambar sebagai file PNG
$simpanBerhasil = @imagepng($image, $outputFile);

// Hancurkan resource gambar untuk membebaskan memori
imagedestroy($image);

// Periksa hasil dan berikan laporan
if ($simpanBerhasil) {
    echo "<strong>HASIL: SUKSES!</strong><br>";
    echo "File <code>test_hasil.png</code> berhasil dibuat di folder <code>public/upload/</code>.<br>";
    echo "Ini membuktikan bahwa GD Library Anda BISA membuat file PNG.<br>";
    echo "Masalahnya sangat spesifik pada saat MEMBACA file PNG yang ada.";
} else {
    echo "<strong>HASIL: GAGAL!</strong><br>";
    echo "Fungsi <code>imagepng()</code> gagal menyimpan file.<br>";
    echo "Ini membuktikan 100% bahwa ada masalah fundamental dengan konfigurasi GD/libpng di XAMPP Anda.<br>";
    echo "<strong>Solusi:</strong> Anda perlu memperbaiki instalasi XAMPP/PHP Anda.";
}

echo "<hr>";
// Verifikasi akhir dengan memeriksa apakah file benar-benar ada
if (file_exists($outputFile)) {
    echo "Verifikasi: File <code>test_hasil.png</code> ditemukan di server. <br>";
    echo '<img src="/upload/test_hasil.png" alt="Gambar Hasil Tes">';
} else {
    echo "Verifikasi: File <code>test_hasil.png</code> TIDAK ditemukan di server.";
}
?>
