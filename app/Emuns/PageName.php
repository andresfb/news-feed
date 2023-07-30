<?php

namespace App\Emuns;

enum PageName: string
{
    case AllNews = 'all_news';
    case Grouped = 'grouped';
    case Provider = 'provider';
    case Archive = 'archive';

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }
}
