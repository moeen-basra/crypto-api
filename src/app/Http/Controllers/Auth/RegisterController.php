<?php


namespace App\Http\Controllers\Auth;


use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Features\Auth\RegisterFeature;

class RegisterController extends Controller
{
    public function register(): JsonResponse
    {
        return $this->serve(RegisterFeature::class);
    }
}
