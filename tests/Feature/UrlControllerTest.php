<?php

namespace Tests\Feature;

use App\Models\Url;
use App\Models\UrlCheck;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Arr;
use Tests\TestCase;

class UrlControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testCreate(): void
    {
        $response = $this->get(route('home'));
        $response->assertOk();
    }

    public function testShow(): void
    {
        $id = Url::create('https://ru.test-test1.io');
        $response = $this->get(route('urls.show', $id));
        $response->assertOk();
    }

    public function testIndex(): void
    {
        $id = Url::create('https://ru.test-test1.io');
        $params = [
            'status' => 200
        ];
        UrlCheck::create($id, $params);
        $response = $this->get(route('urls.index'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        Url::create('https://ru.test-test.io');
        $currentUrl = Url::getLastRecord();
        $data = Arr::only((array) $currentUrl, ['name']);
        $response = $this->post(route('urls.store'), ['url' => $data]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }
}
