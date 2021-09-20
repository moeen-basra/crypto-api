<?php


namespace App\Domains\Jobs\Auth;


use App\Domains\Jobs\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class LoginJob extends Job
{
    public function __construct(
        private array $input
    ) {
    }

    /**
     * login user and return the token
     *
     * @return array
     */
    public function handle(): array
    {
        if (!$token = Auth::attempt($this->input)) {
            throw new UnauthorizedException('Invalid Credentials', 403);
        }

        return [
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
        ];
    }
}
