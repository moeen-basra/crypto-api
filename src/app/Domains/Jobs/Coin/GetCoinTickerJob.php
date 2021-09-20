<?php


namespace App\Domains\Jobs\Coin;


use App\Domains\Jobs\Job;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use App\Data\Services\AlternativeMe\Service;

class GetCoinTickerJob extends Job
{
    public function __construct(
        private int $id
    ) {
    }

    /**
     * @param \App\Data\Services\AlternativeMe\Service $service
     *
     * @return array
     */
    public function handle(Service $service)
    {
        // get the coin tickers from service
        $data = $service->ticker($this->id);

        return [
            'code' => Arr::get($data, 'symbol'),
            'price' => Arr::get($data, 'quotes.USD.price'),
            'volume' => Arr::get($data, 'quotes.USD.volume_24h'),
            'daily_change' => Arr::get($data, 'quotes.USD.percentage_change_24h'),
            'last_updated' => Carbon::now()->unix(),
        ];
    }
}
