<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UrlCheck
{
    public static function create(int $urlId): bool
    {
        return DB::table('url_checks')->insert([
            'url_id' => $urlId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    public static function findByUrlId(int $urlId): Collection
    {
        return DB::table('url_checks')
            ->where('url_id', $urlId)
            ->get();
    }
}
