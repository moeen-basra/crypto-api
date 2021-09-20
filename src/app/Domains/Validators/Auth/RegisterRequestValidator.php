<?php


namespace App\Domains\Validators\Auth;


use Illuminate\Http\Request;
use App\Domains\Validators\Validator;

class RegisterRequestValidator extends Validator
{
    /**
     * validate the input and return only the validated fields
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function handle(Request $request)
    {
        return $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);
    }
}
