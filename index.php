<?php

declare(strict_types=1);

require_once __DIR__ . '/Enums/StatusProduk.php';
require_once __DIR__ . '/Traits/DapatDicatat.php';
require_once __DIR__ . '/Models/Produk.php';
require_once __DIR__ . '/Models/ProdukFisik.php';
require_once __DIR__ . '/Models/ProdukDigital.php';
require_once __DIR__ . '/Services/LayananInventaris.php';

echo "Aplikasi Manajemen Inventaris Sederhana\n";
echo "========================================\n\n";

$layananInventaris = new LayananInventaris();

$layananInventaris->tambahProduk(new ProdukDigital('BK-001', 'Buku Pemrograman PHP', 150000, 20));
$layananInventaris->tambahProduk(new ProdukFisik('LP-001', 'Laptop Ultrabook 14', 12500000, 5, StatusProduk::Diarsipkan));
$layananInventaris->tambahProduk(new ProdukDigital('EC-001', 'E-Course Belajar Laravel', 750000, 100));
$layananInventaris->tambahProduk(new ProdukFisik('KB-001', 'Keyboard Mekanikal', 850000, 0, StatusProduk::Habis));

if (isset($argv[1])) {
    if ($argv[1] === 'list') {
        $layananInventaris->tampilkanDaftarProduk();
        exit();
    }
}

while (true) {
    echo "\n--- MENU UTAMA ---\n";
    echo "1: Tampilkan Daftar Produk\n";
    echo "2: Tambah Stok Produk\n";
    echo "exit: Keluar dari Aplikasi\n";

    $perintah = trim(readline('Pilih perintah: '));
    echo PHP_EOL;

    if ($perintah === 'exit') {
        echo "Terima kasih telah menggunakan aplikasi. Sampai jumpa!\n";
        break;
    }

    $hasil = match($perintah) {
        '1' => $layananInventaris->tampilkanDaftarProduk(),
        '2' => function () use ($layananInventaris) {
            $sku = readline('Masukkan SKU produk: ');
            $jumlah = (int)readline('Jumlah stok tambahan: ');

            if (!is_numeric($jumlah)) {
                echo "Error: Jumlah harus berupa angka.\n";
                return;
            }
            $layananInventaris->tambahStok($sku, $jumlah);
        },
        default => function () {echo "Perintah tidak valid. Silakan coba lagi.\n";}
    };

    if (is_callable($hasil)) {
        $hasil();
    }
}
