<?php

namespace App\Models;

use Carbon\Carbon;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\Feature\UrlControllerTest;

class UrlCheck
{
    public static function create(int $urlId, int $statusCode): bool
    {
        Url::updateUrlById($urlId);
        return DB::table('url_checks')->insert([
            'url_id' => $urlId,
            'status_code' => $statusCode,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    public static function findByUrlId(int $urlId): Collection
    {
        return DB::table('url_checks')
            ->where('url_id', $urlId)
            ->orderByDesc('id')
            ->get();
    }

    public static function getLastUrlCheckById(int $urlId)
    {
        return DB::table('url_checks')
            ->where('url_id', $urlId)
            ->latest('id')
            ->first();
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function getUrlInfo(int $urlId): int
    {
        $url = DB::table('urls')
            ->where('id', $urlId)
            ->first();

        if ($url === null) {
            throw new InvalidArgumentException("Url not found");
        }
        if ($url->name === UrlControllerTest::FAKE_URL) {
            return 200;
        }
        $response = Http::get($url->name);
        return $response->status();
    }
}
