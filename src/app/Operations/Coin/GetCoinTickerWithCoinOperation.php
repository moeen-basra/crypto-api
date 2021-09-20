<?php


namespace App\Operations\Coin;


use App\Operations\Operation;
use Illuminate\Support\Facades\Cache;
use App\Domains\Jobs\Coin\GetCoinTickerJob;

class GetCoinTickerWithCoinOperation extends Operation
{
    public function __construct(
        private array $coin
    )
    {
    }

    public function handle(): array
    {
        // return if ticker data either from cache or load the new
        return Cache::remember($this->coin['code'], (5 * 60), function () {
            return $this->run(GetCoinTickerJob::class, [
                'id' => $this->coin['id']
            ]);
        });
    }
}
