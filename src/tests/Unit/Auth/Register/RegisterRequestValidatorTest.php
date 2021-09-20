<?php

namespace Tests\Unit\Auth\Register;

use Tests\TestCase;
use Illuminate\Support\Arr;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Validation\ValidationException;
use App\Domains\Validators\Auth\RegisterRequestValidator;

class RegisterRequestValidatorTest extends TestCase
{
    use DatabaseMigrations;

    public function test_register_request_validator_has_valid_data()
    {
        $input = [
            'name' => 'Moeen',
            'email' => 'm.basra@live.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ];

        $request = request()->merge($input);

        $data = (new RegisterRequestValidator())->handle($request);

        $this->assertEquals(Arr::except($input, 'password_confirmation'), $data);
    }

    public function test_register_request_validator_missing_name()
    {
        $input = [
            'email' => 'm.basra@live.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ];

        $request = request()->merge($input);

        try {
            (new RegisterRequestValidator())->handle($request);
        } catch (\Throwable $e) {
            $this->assertTrue($e instanceof ValidationException);
            $this->assertArrayHasKey('name', $e->errors());
            $this->assertEquals(['name' => ['The name field is required.']], Arr::only($e->errors(), 'name'));
        }
    }

    public function test_register_request_validator_has_invalid_email()
    {
        $input = [
            'name' => 'Moeen',
            'email' => 'm.basra',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ];

        $request = request()->merge($input);

        try {
            (new RegisterRequestValidator())->handle($request);
        } catch (\Throwable $e) {
            $this->assertTrue($e instanceof ValidationException);
            $this->assertArrayHasKey('email', $e->errors());
            $this->assertEquals(['email' => ['The email must be a valid email address.']], Arr::only($e->errors(), 'email'));
        }
    }

    public function test_register_request_validator_has_invalid_password()
    {
        $input = [
            'name' => 'Moeen',
            'email' => 'm.basra@live.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret124',
        ];

        $request = request()->merge($input);

        try {
            (new RegisterRequestValidator())->handle($request);
        } catch (\Throwable $e) {
            $this->assertTrue($e instanceof ValidationException);
            $this->assertArrayHasKey('password', $e->errors());
            $this->assertEquals(['password' => ['The password confirmation does not match.']], Arr::only($e->errors(), 'password'));
        }
    }
}
