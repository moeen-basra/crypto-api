<?php


namespace App\Operations\Coin;


use Illuminate\Http\Request;
use App\Operations\Operation;
use Illuminate\Support\Facades\Cache;
use App\Domains\Jobs\Coin\GetCoinsListJob;

class GetCoinsListOperation extends Operation
{
    public function handle(Request $request): array
    {
        $sort = $request->get('sort') === 'DESC' ? 'desc' : 'asc';

        // get the coins data from cache or api
        $content = Cache::remember('coins', (5 * 60), function () {
            return $this->run(GetCoinsListJob::class);
        });

        // if sort order is not desc return the response
        if ($sort !== 'desc') {
            return $content;
        }

        // create a new collection and sort desc
        $content = collect($content)->sortByDesc('name', SORT_NATURAL | SORT_FLAG_CASE);

        // return data as array
        return $content->toArray();
    }
}
