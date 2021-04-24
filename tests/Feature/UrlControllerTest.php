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

    public function testCreate()
    {
        $response = $this->get(route('home'));
        $response->assertOk();
    }

    public function testShow()
    {
        $id = Url::create('https://ru.test-test1.io');
        $response = $this->get(route('urls.show', $id));
        $response->assertOk();
    }

    public function testIndex()
    {
        $id = Url::create('https://ru.test-test1.io');
        UrlCheck::create($id, 200);
        $response = $this->get(route('urls.index'));
        $response->assertOk();
    }

    public function testStore()
    {
        Url::create('https://ru.test-test.io');
        $currentUrl = Url::getLastRecord();
        $data = Arr::only((array) $currentUrl, ['name']);
        $response = $this->post(route('urls.store'), ['url' => $data]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function testCheck()
    {
        $id = Url::create(UrlCheck::FAKE_URL);
        $response = $this->post(route('urls.checks', $id));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }
}
