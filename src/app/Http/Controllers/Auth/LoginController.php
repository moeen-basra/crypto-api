<?php


namespace App\Http\Controllers\Auth;


use Illuminate\Http\JsonResponse;
use App\Features\Auth\LoginFeature;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * login user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(): JsonResponse
    {
        return $this->serve(LoginFeature::class);
    }
}
