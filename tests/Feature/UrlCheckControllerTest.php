<?php

namespace Tests\Feature;

use App\Models\Url;
use App\Models\UrlCheck;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UrlCheckControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testStore(): void
    {
        $id = Url::create(UrlCheck::FAKE_URL);
        $response = $this->post(route('checks.store', $id));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }
}
