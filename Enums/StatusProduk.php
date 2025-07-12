<?php

declare(strict_types=1);

enum StatusProduk: string
{
    case Tersedia = 'available';
    case Habis = 'out_of_stock';
    case Diarsipkan = 'archived';

    public function warna(): string
    {
        return match($this) {
            self::Tersedia => 'hijau',
            self::Habis => 'merah',
            self::Diarsipkan => 'kuning'
        };
    }
}
