<?php


namespace App\Http\Controllers\Coin;


use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Features\Coin\CoinShowFeature;
use App\Features\Coin\CoinListingFeature;

class CoinController extends Controller
{
    /**
     * Get the list of all coins
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->serve(CoinListingFeature::class);
    }

    /**
     * Get the ticks of the coin
     *
     * @param string $coin_code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $coin_code): JsonResponse
    {
        return $this->serve(CoinShowFeature::class, compact('coin_code'));
    }
}
