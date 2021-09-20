<?php


namespace Tests\Unit\Auth\Register;


use Tests\TestCase;
use App\Data\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Domains\Jobs\Auth\RegisterJob;
use Illuminate\Database\QueryException;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RegisterJobTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function test_register_successful()
    {
        $input = [
            'name' => 'Moeen Basra',
            'email' => 'm.basra@live.com',
            'password' => 'secret123',
        ];

        $user = (new RegisterJob($input))->handle();

        $expected = Arr::only($input, ['name', 'email']);
        $actual = Arr::only($user->toArray(), ['name', 'email']);

        $this->assertEquals($expected, $actual);
    }

    public function test_register_failed_due_to_missing_database_required_field()
    {
        try {
            (new RegisterJob([
                'email' => 'm.basra@live.com',
                'password' => 'secret',
            ]))->handle();
        } catch (\Throwable $e) {
            // as transaction mode trait is added so we have to rollback transaction before assertion
            DB::rollBack();
            $this->assertTrue($e instanceof QueryException);
        }
    }

    public function test_register_failed_due_to_unique_email()
    {
        $this->getUser();
        try {
            (new RegisterJob([
                'name' => 'm.basra@live.com',
                'email' => 'm.basra@live.com',
                'password' => 'secret',
            ]))->handle();
        } catch (\Throwable $e) {
            // as transaction mode trait is added so we have to rollback transaction before assertion
            DB::rollBack();
            $this->assertTrue($e instanceof QueryException);
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
