<?php


namespace Test\Unit\Coin\Features;


use Mockery;
use Test\Unit\Coin\CoinTestCase;
use App\Features\Coin\CoinShowFeature;
use Photon\Domains\Http\Jobs\JsonResponseJob;
use App\Operations\Coin\GetCoinsListOperation;
use App\Operations\Coin\GetCoinTickerWithCoinOperation;

class CoinShowFeatureTest extends CoinTestCase
{
    public function test_coin_show_feature_handle()
    {
        // create operation mock instance
        $feature = Mockery::mock(CoinShowFeature::class, ['BTC'], function (Mockery\MockInterface $mock) {
            $mock->shouldReceive('run')
                ->with(GetCoinsListOperation::class)
                ->andReturn($this->getCoinListData());

            $mock->shouldReceive('run')
                ->with(GetCoinTickerWithCoinOperation::class, [
                    'coin' => $this->getCoin(),
                ])
                ->andReturn($this->getCoinTickerData());

            $mock->shouldReceive('run')
                ->with(JsonResponseJob::class, [
                    'content' => $this->getCoinTickerData()
                ])
                ->andReturn([
                    'status' => 200,
                    'data' => $this->getCoinTickerData()
                ]);
        })->makePartial();

        $actual = $feature->handle();

        $this->assertTrue(200 === $actual['status']);
        $this->assertEquals($this->getCoinTickerData(), $actual['data']);
    }
}
