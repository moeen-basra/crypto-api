<?php


namespace Test\Unit\Coin\Operations;


use Closure;
use Test\Unit\Coin\CoinTestCase;
use Illuminate\Support\Facades\Cache;
use App\Operations\Coin\GetCoinsListOperation;

class GetCoinsListOperationTest extends CoinTestCase
{
    public function test_get_coin_list_operation_handle()
    {
        $sort = 'ASC';
        $expected = $this->getCoinListData($sort);

        Cache::shouldReceive('remember')
            ->once()
            ->with('coins', (5 * 60), Closure::class)
            ->andReturn($expected);

        $request = request()->merge([
            'sort' => $sort,
        ]);

        $actual = (new GetCoinsListOperation())->handle($request);

        $this->assertEquals($expected, $actual);;
    }
}
