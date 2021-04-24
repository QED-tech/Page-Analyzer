<?php

namespace App\Http\Controllers;

use App\Models\UrlCheck;
use Illuminate\Http\RedirectResponse;

class UrlCheckController extends Controller
{

    public function store(int $id): RedirectResponse
    {
        $info = UrlCheck::getUrlInfo($id);
        UrlCheck::create($id, $info);
        flash('Страница успешно проверена')
            ->info();
        return redirect()
            ->route('urls.show', $id);
    }
}
