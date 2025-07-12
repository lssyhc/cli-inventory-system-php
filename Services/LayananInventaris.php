<?php

declare(strict_types=1);

require_once __DIR__ . '/../Models/Produk.php';
require_once __DIR__ . '/../Enums/StatusProduk.php';

class LayananInventaris
{
    private array $daftarProduk = [];

    public function tambahProduk(Produk $produk): void
    {
        $this->daftarProduk[] = $produk;
        $produk->catatAktivitas("Produk '{$produk->nama}' (SKU: {$produk->sku}) ditambahkan ke inventaris.");
    }

    public function tampilkanDaftarProduk(): void
    {
        if (empty($this->daftarProduk)) {
            echo 'Inventaris kosong.' . PHP_EOL;
            return;
        }

        echo "==================================================================================================\n";
        printf(
            "| %-15s | %-25s | %-15s | %-10s | %-12s | %-12s |\n",
            'SKU',
            'Nama Produk',
            'Tipe Produk',
            'Stok',
            'Status',
            'Warna Status'
        );
        echo "==================================================================================================\n";
        foreach ($this->daftarProduk as $produk) {
            printf(
                "| %-15s | %-25s | %-15s | %-10s | %-12s | %-12s |\n",
                $produk->sku,
                $produk->nama,
                $produk->getTipeProduk(),
                $produk->stok,
                $produk->status->value,
                $produk->status->warna()
            );
        }
        echo "==================================================================================================\n";
    }

    public function cariProduk(string $sku): ?Produk
    {
        foreach ($this->daftarProduk as $produk) {
            if (trim(strtolower($this->$produk->sku)) === trim(strtolower($sku))) {
                return $produk;
            }
        }
        return null;
    }

    public function tambahStok(string $sku, int $jumlah): bool
    {
        $produk = $this->cariProduk($sku);

        if (!$produk) {
            echo "Error: Produk dengan SKU '$sku' tidak ditemukan\n";
            return false;
        }

        if (0 >= $jumlah) {
            echo "Error: Jumlah penambahan stok harus positif\n";
            return false;
        }

        $stokLama = $produk->stok;
        $produk->stok += $jumlah;

        if ($produk->status === StatusProduk::Habis) {
            $produk->status = StatusProduk::Tersedia;
        }

        $produk->catatAktivitas("Stok untuk '{$produk->nama}' berhasil diperbarui dari $stokLama menjadi {$produk->stok}");
        return true;
    }
}
