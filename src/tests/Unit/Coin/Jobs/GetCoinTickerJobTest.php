<?php


namespace Test\Unit\Coin\Jobs;


use Mockery;
use Mockery\MockInterface;
use Test\Unit\Coin\CoinTestCase;
use Illuminate\Support\Facades\App;
use App\Data\Services\AlternativeMe\Service;
use App\Domains\Jobs\Coin\GetCoinTickerJob;

class GetCoinTickerJobTest extends CoinTestCase
{
    public function test_get_coin_ticker_job_handle()
    {
        $mock = Mockery::mock(Service::class, function (MockInterface $mock) {
            $mock->shouldReceive('ticker')
                ->once()
                ->andReturn($this->getCoinTickerRawData());
        });

        $expected = $this->getCoinTickerData();
        $actual = App::make(GetCoinTickerJob::class, [
            'id' => 1,
        ])->handle($mock);

        $this->assertEquals($expected, $actual);
    }
}
