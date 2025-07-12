<?php

declare(strict_types=1);

require_once __DIR__ . '/Produk.php';

class ProdukFisik extends Produk
{
    public function getTipeProduk(): string
    {
        return 'Produk Fisik';
    }
}
