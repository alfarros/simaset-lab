<?php

namespace App\Enums;

enum AssetCategory: string
{
    case HARDWARE = 'Hardware Utama';
    case PENDUKUNG = 'Perangkat Pendukung';
    case JARINGAN = 'Perangkat Jaringan';
    case FURNITUR = 'Furnitur';

    /**
     * Mengambil semua nilai (values) dari case sebagai array.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
