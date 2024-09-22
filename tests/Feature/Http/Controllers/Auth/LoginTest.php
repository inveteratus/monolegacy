<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[Group('auth')]
class LoginTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function pageLoads(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertViewIs('auth.login');
    }

    #[Test]
    public function requestValidationPasses(): void
    {
        $input = ['email' => 'test@example.com', 'password' => 'password'];
        $request = new LoginRequest();
        $validator = Validator::make($input, $request->rules());

        $this->assertTrue($validator->passes());
    }

    #[Test, DataProvider('requestValidationFailsProvider')]
    public function requestValidationFails(array $input): void
    {
        $request = new LoginRequest();
        $validator = Validator::make($input, $request->rules());

        $this->assertTrue($validator->fails());
    }

    public static function requestValidationFailsProvider(): array
    {
        return [
            'missing password' => [['email' => 'test@example.com']],
            'missing email' => [['password' => 'password']],
            'bad email' => [['email' => 'bad', 'password' => 'password']],
            'no input' => [['email' => 'test@example.com']],
        ];
    }

    #[Test]
    public function redirectOnBadInput(): void
    {
        $this->from(route('login'))
            ->post(route('login'))
            ->assertRedirectToRoute('login')
            ->assertSessionHasErrors([
                'email' => 'The email field is required.',
                'password' => 'The password field is required.',
            ]);
    }

    #[Test]
    public function cannotLoginWithInvalidCredentials(): void
    {
        $this->from(route('login'))
            ->post(route('login'), ['email' => 'test@example.com', 'password' => 'password'])
            ->assertRedirectToRoute('login')
            ->assertSessionHasErrors([
                'email' => 'Invalid credentials.',
            ]);
    }

    #[Test]
    public function canLoginWithCorrectCredentials(): void
    {
        User::factory()->create(['email' => 'test@example.com', 'password' => 'password']);

        $this->from(route('login'))
            ->post(route('login'), ['email' => 'test@example.com', 'password' => 'password'])
            ->assertRedirectToRoute('home');
    }
}
