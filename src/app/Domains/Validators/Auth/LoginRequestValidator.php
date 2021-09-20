<?php


namespace App\Domains\Validators\Auth;


use Illuminate\Http\Request;
use App\Domains\Validators\Validator;

class LoginRequestValidator extends Validator
{
    /**
     * validate and return the valid data
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function handle(Request $request)
    {
        return $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
    }
}
