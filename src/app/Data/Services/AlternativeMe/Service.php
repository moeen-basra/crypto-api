<?php


namespace App\Data\Services\AlternativeMe;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class Service
{
    /**
     * get the list of all the coins
     *
     * @return array
     */
    public function getListing(): array
    {
        $response = Http::get('https://api.alternative.me/v2/listings');

        return $this->parseResponse($response);

    }

    /**
     * get the ticker data from the coin by its id
     *
     * @param int $id
     *
     * @return array
     */
    public function ticker(int $id): array
    {
        $response = Http::get("https://api.alternative.me/v2/ticker/{$id}/");

        return Arr::get($this->parseResponse($response), '1');
    }

    /**
     * parse the response received from the client
     *
     * @param \Illuminate\Http\Client\Response $response
     *
     * @return array
     */
    private function parseResponse(Response $response): array
    {
        $data = $response->body();

        $json = json_decode($data, true);

        if (json_last_error()) {
            $data .= '}';

            $json = json_decode($data, true);
        }

        return Arr::get($json, 'data');
    }
}
