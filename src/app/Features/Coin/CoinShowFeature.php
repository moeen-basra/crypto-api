<?php


namespace App\Features\Coin;


use App\Features\Feature;
use Illuminate\Http\JsonResponse;
use App\Exceptions\MessageException;
use Photon\Domains\Http\Jobs\JsonResponseJob;
use App\Operations\Coin\GetCoinsListOperation;
use App\Operations\Coin\GetCoinTickerWithCoinOperation;

class CoinShowFeature extends Feature
{
    public function __construct(
        private string $coin_code
    ) {
    }

    public function handle()
    {
        // get the coins list
        $coins = $this->run(GetCoinsListOperation::class);

        // select the coin based on the coin code
        $coin = collect($coins)->first(function ($coin) {
            return $coin['code'] === $this->coin_code;
        });

        // if no coin found throw the exception
        if (!$coin) {
            throw new MessageException(
                sprintf('Invalid coin code %s', $this->coin_code)
            );
        }

        // get the coin ticker
        $content = $this->run(GetCoinTickerWithCoinOperation::class, compact('coin'));

        return $this->run(JsonResponseJob::class, compact('content'));
    }
}
