<?php


namespace Test\Unit\Coin\Operations;


use Closure;
use Test\Unit\Coin\CoinTestCase;
use Illuminate\Support\Facades\Cache;
use App\Operations\Coin\GetCoinTickerWithCoinOperation;

class GetCoinTickerWithCoinOperationTest extends CoinTestCase
{
    public function test_get_coin_ticker_with_coin_operation_handle()
    {
        $coin = $this->getCoin();

        Cache::shouldReceive('remember')
            ->with($coin['code'], (5 * 60), Closure::class)
            ->once()
            ->andReturn([]);

        $actual = (new GetCoinTickerWithCoinOperation($coin))->handle();

        $this->assertEquals([], $actual);;
    }


}
