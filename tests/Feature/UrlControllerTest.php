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

    /* @var string */
    public const FAKE_URL = 'for-tests';

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
        $currentUrl = Url::getLastRecord();
        UrlCheck::create($currentUrl->id, 200);
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
        Url::create(self::FAKE_URL);
        $currentUrl = Url::getLastRecord();
        $response = $this->post(route('urls.checks', $currentUrl->id));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }
}
