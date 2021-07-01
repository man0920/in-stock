<?php

namespace Tests\Feature;


use App\Product;
use RetailerWithProductSeeder;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_tracks_product_stock()
    {
        $this->seed(RetailerWithProductSeeder::class);
        $this->assertFalse(Product::first()->inStock());
        Http::fake(fn() => ['available' => true, 'price' => 29900]);
        $this->artisan('track')
            ->expectsOutput('All done!');
            $this->assertTrue(Product::first()->inStock());
    }
}
