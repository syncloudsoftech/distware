<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('bytes_to_str')) {
    function bytes_to_str(float|int $size, int $precision = 2): string
    {
        static $suffixes = ['bytes', 'KB', 'MB', 'GB', 'TB'];

        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);

            return round(pow(1024, $base - floor($base)), $precision).' '.$suffixes[floor($base)];
        } else {
            return $size;
        }
    }
}

if (! function_exists('cdn_url')) {
    function cdn_url(string $path, ?string $disk = null): string
    {
        if (empty($disk)) {
            $disk = config('filesystems.local');
        }

        if ($cdn = config('app.cdn_url')) {
            return rtrim($cdn, '/').'/'.ltrim($path, '/');
        }

        if ($disk === 'public') {
            return Storage::disk($disk)->url($path);
        }

        return Storage::disk($disk)->temporaryUrl($path, now()->addWeek());
    }
}

if (! function_exists('generate_key')) {
    function generate_key(
        int $chars = 10,
        int $section = 5,
        string $charset = '0123456789abcdefghijklmnopqrstuvwxyz'
    ): string {
        return implode('-', str_split(substr(str_shuffle($charset), 0, $chars), $section));
    }
}
