<?php


namespace Tests\Unit\Auth\Login;


use Tests\TestCase;
use App\Data\Models\User;
use App\Domains\Jobs\Auth\LoginJob;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Validation\UnauthorizedException;

class LoginJobTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function test_login_successful()
    {
        $user = $this->getUser();

        $token = (new LoginJob([
            'email' => 'm.basra@live.com',
            'password' => 'secret123',
        ]))->handle();

        $this->assertArrayHasKey('token', $token);
        $this->assertEquals($user->toArray(), Auth::user()->toArray());
    }

    public function test_login_failed()
    {
        try {
            (new LoginJob([
                'email' => 'm.basra@live.com',
                'password' => 'secret',
            ]))->handle();
        } catch (UnauthorizedException $e) {
            $this->assertEquals('Invalid Credentials', $e->getMessage());
        }
    }

    private function getUser(): User
    {
        return User::factory()->create([
            'name' => 'Moeen Basra',
            'email' => 'm.basra@live.com',
            'password' => Hash::make('secret123'),
        ]);
    }
}
