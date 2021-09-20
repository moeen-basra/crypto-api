<?php


namespace App\Domains\Jobs\Coin;


use App\Domains\Jobs\Job;
use App\Data\Services\AlternativeMe\Service;

class GetCoinsListJob extends Job
{
    /**
     * get the coins list from api service
     *
     * @param \App\Data\Services\AlternativeMe\Service $service
     *
     * @return array
     */
    public function handle(Service $service): array
    {
        return collect($service->getListing())
            ->map(function ($coin) {
                return [
                    'id' => $coin['id'],
                    'name' => $coin['name'],
                    'code' => $coin['symbol'],
                ];
            })
            ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->keyBy('code')
            ->all();
    }
}
