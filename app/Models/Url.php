<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class Url
{
    public static function create(string $name): int
    {
        $url = DB::table('urls')
            ->where('name', $name)
            ->first();

        if ($url === null) {
            return DB::table('urls')->insertGetId([
                'name' => $name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        return $url->id;
    }

    public static function updateUrlById(int $id): void
    {
        DB::table('urls')
            ->where('id', $id)
            ->update([
                'updated_at' => Carbon::now()
            ]);
    }

    public static function deleteById(int $id): int
    {
        return DB::table('urls')->delete($id);
    }

    public static function getLastRecord()
    {
        return DB::table('urls')->latest()->first();
    }

    public static function all(): LengthAwarePaginator
    {
        return DB::table('urls')
            ->paginate(10);
    }

    public static function findById(int $id)
    {
        return DB::table('urls')->where('id', $id)->first();
    }

    public static function normalizeUrl(string $url): string
    {
        $host = parse_url($url, PHP_URL_HOST);
        $scheme = parse_url($url, PHP_URL_SCHEME);
        return "{$scheme}://{$host}";
    }
}
