<?php


namespace Test\Unit\Coin\Features;


use Mockery;
use Tests\TestCase;
use Illuminate\Support\Arr;
use Test\Unit\Coin\CoinTestCase;
use App\Features\Coin\CoinListingFeature;
use Photon\Domains\Http\Jobs\JsonResponseJob;
use App\Operations\Coin\GetCoinsListOperation;

class CoinListingFeatureTest extends CoinTestCase
{
    public function test_coin_listing_feature_handle()
    {
        $feature = Mockery::mock(CoinListingFeature::class, function(Mockery\MockInterface $mock) {
            $mock->shouldReceive('run')
                ->with(GetCoinsListOperation::class)
                ->andReturn($this->getCoinListData());

            $mock->shouldReceive('run')
                ->with(JsonResponseJob::class, [
                    'content' => $this->parseSampleCoins()
                ])
                ->andReturn([
                    'data' => $this->parseSampleCoins(),
                    'status' => 200
                ]);
        })->makePartial();

        $actual = $feature->handle();

        $this->assertTrue(200 === $actual['status']);
        $this->assertEquals($this->parseSampleCoins(), $actual['data']);
    }

    private function parseSampleCoins(): array
    {
        $coins = $this->getCoinListData();

        return array_map(function($coin) {
            return Arr::only($coin, ['name', 'code']);
        }, $coins);
    }
}
