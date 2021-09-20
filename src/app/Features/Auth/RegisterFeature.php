<?php

namespace App\Features\Auth;

use App\Features\Feature;
use Illuminate\Http\JsonResponse;
use App\Domains\Jobs\Auth\RegisterJob;
use Photon\Domains\Http\Jobs\JsonResponseJob;
use App\Domains\Validators\Auth\RegisterRequestValidator;

/**
 * Class RegisterFeature
 *
 * @package App\Features\Auth
 */
class RegisterFeature extends Feature
{
    public function handle()
    {
        // validate and get the request input
        $input = $this->run(RegisterRequestValidator::class);

        // register the user with login input
        $user = $this->run(RegisterJob::class, compact('input'));

        // return the registered user
        return $this->run(JsonResponseJob::class, [
            'content' => [
                'user' => $user
            ]
        ]);
    }
}
