<?php

namespace App\Models;

use Carbon\Carbon;
use DiDom\Document;
use DiDom\Exceptions\InvalidSelectorException;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UrlCheck
{

    /* @var string */
    public const FAKE_URL = 'for-tests';

    public static function create(int $urlId, array $info): bool
    {
        Url::updateUrlById($urlId);
        return DB::table('url_checks')->insert([
            'url_id' => $urlId,
            'status_code' => $info['status'],
            'h1' => $info['h1'] ?? null,
            'keywords' => $info['keywords'] ?? null,
            'description' => $info['description'] ?? null,
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
    public static function getUrlInfo(int $urlId): array
    {
        $url = DB::table('urls')
            ->where('id', $urlId)
            ->first();

        if ($url === null) {
            throw new InvalidArgumentException("Url not found");
        }
        if ($url->name === self::FAKE_URL) {
            return self::fakeUrlHandle();
        }
        $response = Http::get($url->name);
        $info = [
            'status' => $response->status()
        ];
        if (!$response->ok()) {
            return $info;
        }
        $document = new Document($url->name, true);

        try {
            $h1 = $document->first('h1');
            if ($h1 !== null) {
                $info['h1'] = $h1->text();
            }
            $content = $document->first('meta[name^=description]');
            if ($content !== null) {
                $info['description'] = $content->attr('content');
            }
            $keywords = $document->first('meta[name^=keywords]');
            if ($keywords !== null) {
                $info['keywords'] = $content->attr('content');
            }
        } catch (InvalidSelectorException $e) {
            return $info;
        }

        return $info;
    }

    public static function fakeUrlHandle(): array
    {
        return [
            'status' => 200
        ];
    }
}
