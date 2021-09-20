<?php


namespace Test\Unit\Coin\Jobs;


use Mockery;
use Mockery\MockInterface;
use Test\Unit\Coin\CoinTestCase;
use Illuminate\Support\Facades\App;
use App\Data\Services\AlternativeMe\Service;
use App\Domains\Jobs\Coin\GetCoinsListJob;

class GetCoinsListJobTest extends CoinTestCase
{
    public function test_get_coin_list_job_handle()
    {
        $mock = Mockery::mock(Service::class, function (MockInterface $mock) {
            $mock->shouldReceive('getListing')
                ->once()
                ->andReturn($this->getCoinListRawData());
        });

        $expected = $this->getCoinListData();
        $actual = App::make(GetCoinsListJob::class)->handle($mock);

        $this->assertEquals($expected, $actual);
    }
}
