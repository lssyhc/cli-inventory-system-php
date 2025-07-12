<?php

declare(strict_types=1);

trait DapatDicatat
{
    public function catatAktivitas(string $pesan): void
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $pesan . PHP_EOL;
    }
}
