<?php

declare(strict_types=1);

require_once __DIR__ . '/../Traits/DapatDicatat.php';
require_once __DIR__ . '/../Enums/StatusProduk.php';

abstract class Produk
{
    use DapatDicatat;

    public function __construct(
        public readonly string $sku,
        public string $nama,
        public int|float $harga,
        public int $stok,
        public StatusProduk $status = StatusProduk::Tersedia
    ) {
    }

    abstract public function getTipeProduk(): string;
}
