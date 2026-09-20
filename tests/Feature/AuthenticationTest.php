<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_see_login_and_protected_route_redirects_to_login(): void
    {
        $this->get('/login')->assertOk();
        $this->get('/dashboard')->assertRedirect(route('login'));
    }

    public function test_user_can_login_and_logout(): void
    {
        $user = User::factory()->create(['password' => 'password-with-12-chars']);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password-with-12-chars',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
        $this->post(route('logout'))->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_existing_user_can_request_password_reset(): void
    {
        Notification::fake();
        $user = User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email])
            ->assertSessionHas('status');

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_local_password_reset_request_exposes_the_reset_link_in_the_browser_console(): void
    {
        Notification::fake();
        $this->app['env'] = 'local';
        $this->withoutMiddleware(ValidateCsrfToken::class);
        $user = User::factory()->create();

        $response = $this->from(route('password.request'))->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $response->assertRedirect(route('password.request'));
        $response->assertSessionHas('password_reset_url', function (string $url): bool {
            return str_contains($url, '/redefinir-senha/');
        });
        Notification::assertSentTo($user, ResetPassword::class);

        $this->get(route('password.request'))
            ->assertSee('Link local para redefinição de senha')
            ->assertSee('redefinir-senha');
    }

    public function test_non_local_password_reset_request_does_not_expose_the_reset_link(): void
    {
        Notification::fake();
        $this->app['env'] = 'production';
        $this->withoutMiddleware(ValidateCsrfToken::class);
        $user = User::factory()->create();

        $response = $this->from(route('password.request'))->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $response->assertRedirect(route('password.request'));
        $response->assertSessionMissing('password_reset_url');
        Notification::assertSentTo($user, ResetPassword::class);

        $this->get(route('password.request'))
            ->assertDontSee('Link local para redefinição de senha');
    }

    public function test_reset_password_requires_at_least_eight_characters(): void
    {
        $response = $this->post(route('password.update'), [
            'token' => 'test-token',
            'email' => 'keila@bplprodutos.com.br',
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'O campo senha deve ter pelo menos 8 caracteres.',
        ]);
    }

    public function test_reset_password_form_limits_password_fields_to_eight_characters(): void
    {
        $this->get(route('password.reset', ['token' => 'test-token']))
            ->assertOk()
            ->assertSee('Use uma senha com pelo menos 8 caracteres.')
            ->assertSee('minlength="8"', false);
    }
}
