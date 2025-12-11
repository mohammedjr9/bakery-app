<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Dusk\Browser;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_home_page_loads_successfully(): void
    {
        $this->browse(function (Browser $browser) {
     $browser->visit('/')
        ->assertSee('لوحة التحكم');

        });
    }
}
