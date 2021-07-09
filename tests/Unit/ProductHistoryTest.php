<?php

namespace Tests\Unit;

use App\Stock;
use App\History;
use Tests\TestCase;
use RetailerWithProductSeeder;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductHistoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_records_history_when_a_product_is_tracked()
    {
        $this->seed(RetailerWithProductSeeder::class);

        ClientFactory::shouldReceive('make->checkAvailability')
            ->andReturn(new StockStatus($available = true, $price = 99));
        $this->assertEquals(0, History::count());

        $product->track();

        $this->assertEquals(1, History::count());

        $history = $product->history->first();
        $this->assertEquals($price, $history->price);
        $this->assertEquals($available, $history->in_stock);
        $this->assertEquals($product->stock[0]->id, $history->stock_id);
    }
    }
}
