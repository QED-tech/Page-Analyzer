<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUrlRequest;
use App\Models\Url;
use App\Models\UrlCheck;
use Illuminate\Http\RedirectResponse;

class UrlController extends Controller
{

    public function index()
    {
        return view('index', [
            'urls' => Url::all()
        ]);
    }


    public function create()
    {
        return view('welcome');
    }


    public function store(StoreUrlRequest $request): RedirectResponse
    {
        $url = Url::normalizeUrl(
            $request
                ->input('url.name')
        );
        $id = Url::create($url);
        flash('Url добавлен')
            ->info();
        return redirect()
            ->route('urls.show', $id);
    }


    public function show(int $id)
    {
        return view('show', [
            'url' => Url::findById($id),
            'urlChecks' => UrlCheck::findByUrlId($id)
        ]);
    }
}
