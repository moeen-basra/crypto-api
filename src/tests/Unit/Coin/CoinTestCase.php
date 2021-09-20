<?php


namespace Test\Unit\Coin;


use Tests\TestCase;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

abstract class CoinTestCase extends TestCase
{

    protected function getCoin(): array
    {
        return [
            'id' => 1,
            'code' => 'BTC',
            'name' => 'Bitcoin',
        ];
    }

    protected function getCoinListData(string $sort = 'ASC'): array
    {
        $collection = collect($this->getCoinListRawData())
            ->map(function ($coin) {
                return [
                    'id' => $coin['id'],
                    'name' => $coin['name'],
                    'code' => $coin['symbol'],
                ];
            })
            ->keyBy('code');

        if ($sort === 'ASC') {
            $collection = $collection->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);
        } else {
            $collection = $collection->sortByDesc('name', SORT_NATURAL | SORT_FLAG_CASE);
        }
        return $collection->all();
    }

    protected function getCoinTickerData(): array
    {
        $data = $this->getCoinTickerRawData();

        return [
            'code' => Arr::get($data, 'symbol'),
            'price' => Arr::get($data, 'quotes.USD.price'),
            'volume' => Arr::get($data, 'quotes.USD.volume_24h'),
            'daily_change' => Arr::get($data, 'quotes.USD.percentage_change_24h'),
            'last_updated' => Carbon::now()->unix(),
        ];
    }

    protected function getCoinTickerRawData(): array
    {
        return [
            "id" => 1,
            "name" => "Bitcoin",
            "symbol" => "BTC",
            "website_slug" => "bitcoin",
            "rank" => 1,
            "circulating_supply" => 18820668,
            "total_supply" => 18820668,
            "max_supply" => 21000000,
            "quotes" => [
                "USD" => [
                    "price" => 47714,
                    "volume_24h" => 26470129079,
                    "market_cap" => 898391098703,
                    "percentage_change_1h" => -0.42634604166721,
                    "percentage_change_24h" => -1.1227673976012,
                    "percentage_change_7d" => 5.5703870886898,
                    "percent_change_1h" => -0.42634604166721,
                    "percent_change_24h" => -1.1227673976012,
                    "percent_change_7d" => 5.5703870886898,
                ],
            ],
            "last_updated" => 1632080379,
        ];
    }

    protected function getCoinListRawData(): array
    {
        return [
            [
                "id" => "1",
                "name" => "Bitcoin",
                "symbol" => "BTC",
                "website_slug" => "bitcoin",
            ],
            [
                "id" => "2",
                "name" => "Litecoin",
                "symbol" => "LTC",
                "website_slug" => "litecoin",
            ],
            [
                "id" => "3",
                "name" => "Namecoin",
                "symbol" => "NMC",
                "website_slug" => "namecoin",
            ],
            [
                "id" => "4",
                "name" => "Terracoin",
                "symbol" => "TRC",
                "website_slug" => "terracoin",
            ],
        ];
    }
}
