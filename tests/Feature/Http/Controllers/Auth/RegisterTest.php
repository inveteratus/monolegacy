<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[Group('auth')]
class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function pageLoads(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertViewIs('auth.register');
    }

    #[Test]
    public function requestValidationPasses(): void
    {
        $input = ['name' => 'test', 'email' => 'test@example.com', 'password' => 'password'];
        $request = new RegisterRequest();
        $validator = Validator::make($input, $request->rules());

        $this->assertTrue($validator->passes());
    }

    #[Test, DataProvider('requestValidationFailsProvider')]
    public function requestValidationFails(array $input): void
    {
        User::factory()->create([
            'name' => 'duplicate',
            'email' => 'duplicate@example.com',
        ]);

        $request = new RegisterRequest();
        $validator = Validator::make($input, $request->rules());

        $this->assertTrue($validator->fails());
    }

    public static function requestValidationFailsProvider(): array
    {
        return [
            'no input' => [[]],
            'missing name' => [['email' => 'test@example.com', 'password' => 'password']],
            'missing email' => [['name' => 'test', 'password' => 'password']],
            'missing password' => [['name' => 'test', 'email' => 'test@example.com']],
            'bad name' => [['name' => str_repeat('a', 50), 'email' => 'test@example.com', 'password' => 'password']],
            'bad email' => [['name' => 'test', 'email' => 'bad', 'password' => 'password']],
            'bad password' => [['name' => 'test', 'email' => 'test@example.com', 'password' => 'pass']],
            'duplicate name' => [['name' => 'duplicate', 'email' => 'test@example.com', 'password' => 'password']],
            'duplicate email' => [['name' => 'test', 'email' => 'duplicate@example.com', 'password' => 'password']],
        ];
    }

    #[Test]
    public function canRegisterNewAccount(): void
    {
        $this->from(route('register'))
            ->post(route('register'), ['name' => 'test', 'email' => 'test@example.com', 'password' => 'password'])
            ->assertRedirectToRoute('home');

        $this->assertDatabaseHas('users', ['name' => 'test', 'email' => 'test@example.com']);
    }
}
