<?php


namespace App\Features\Auth;


use App\Features\Feature;
use Illuminate\Http\JsonResponse;
use App\Domains\Jobs\Auth\LoginJob;
use Photon\Domains\Http\Jobs\JsonResponseJob;
use App\Domains\Validators\Auth\LoginRequestValidator;

/**
 * Class LoginFeature
 *
 * @package App\Features\Auth
 */
class LoginFeature extends Feature
{
    public function handle()
    {
        // validate and get the request input
        $input = $this->run(LoginRequestValidator::class);

        // login user using the validated input
        $content = $this->run(LoginJob::class, compact('input'));

        // return json response
        return $this->run(JsonResponseJob::class, compact('content'));
    }
}
