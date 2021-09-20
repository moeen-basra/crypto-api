<?php

namespace Tests\Unit\Auth\Login;

use Tests\TestCase;
use Illuminate\Validation\ValidationException;
use App\Domains\Validators\Auth\LoginRequestValidator;

class LoginRequestValidatorTest extends TestCase
{
    public function test_login_request_validator_has_valid_data()
    {
        $input = [
            'email' => 'm.basra@live.com',
            'password' => 'secret123',
        ];

        $request = request()->merge($input);

        $data = (new LoginRequestValidator())->handle($request);

        $this->assertEquals($input, $data);
    }

    public function test_login_request_validator_has_invalid_email()
    {
        $input = [
            'email' => 'm.basra',
            'password' => 'secret123',
        ];

        $request = request()->merge($input);

        try {
            (new LoginRequestValidator())->handle($request);
        } catch (\Throwable $e) {
            $this->assertTrue($e instanceof ValidationException);
            $this->assertArrayHasKey('email', $e->errors());
        }
    }

    public function test_login_request_validator_has_invalid_password()
    {
        $input = [
            'email' => 'm.basra@live.com',
            'password' => 'secret',
        ];

        $request = request()->merge($input);

        try {
            (new LoginRequestValidator())->handle($request);
        } catch (\Throwable $e) {
            $this->assertTrue($e instanceof ValidationException);
            $this->assertArrayHasKey('password', $e->errors());
        }
    }
}
