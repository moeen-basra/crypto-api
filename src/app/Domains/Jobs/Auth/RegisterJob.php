<?php


namespace App\Domains\Jobs\Auth;


use App\Domains\Jobs\Job;
use App\Data\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class RegisterJob extends Job
{
    public function __construct(
        private array $input
    ) {
    }

    /**
     * Save and return the user
     *
     * @return \App\Data\Models\User
     * @throws \Exception
     */
    public function handle(): User
    {
        $user = new User();

        $user->name = Arr::get($this->input, 'name');
        $user->email = Arr::get($this->input, 'email');
        $user->password = Hash::make(Arr::get($this->input, 'password'));

        if (!$user->save()) {
            throw new \Exception('Oops, something went wrong while creating the user please contact support');
        }
        return $user;
    }
}
