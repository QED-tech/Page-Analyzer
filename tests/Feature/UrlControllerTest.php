<?php

namespace Tests\Feature;

use App\Models\Url;
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
        Url::create('https://ru.test-test1.io');
        $currentUrl = Url::getLastRecord();
        $response = $this->get(route('urls.show', $currentUrl->id));
        $response->assertOk();
    }

    public function testIndex()
    {
        Url::create('https://ru.test-test1.io');
        Url::create('https://ru.test-test2.io');
        Url::create('https://ru.test-test3.io');
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
        Url::create('https://ru.test-test.io');
        $currentUrl = Url::getLastRecord();
        $response = $this->post(route('urls.checks', $currentUrl->id));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }
}
