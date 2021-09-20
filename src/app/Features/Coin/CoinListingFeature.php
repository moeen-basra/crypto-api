<?php


namespace App\Features\Coin;


use App\Features\Feature;
use Illuminate\Support\Arr;
use Photon\Domains\Http\Jobs\JsonResponseJob;
use App\Operations\Coin\GetCoinsListOperation;

class CoinListingFeature extends Feature
{
    public function handle()
    {
        // get the coins list
        $content = $this->run(GetCoinsListOperation::class);

        // get the name and code fields from data
        $content = array_map(function ($coin) {
            return Arr::only($coin, ['name', 'code']);
        }, $content ?? []);

        return $this->run(JsonResponseJob::class, compact('content'));
    }
}
