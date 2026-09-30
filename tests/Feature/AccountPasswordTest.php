<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AccountPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_every_signed_in_user_can_see_a_bilingual_password_change_form(): void
    {
        $this->put(route('account.password.update'))->assertRedirect(route('login'));

        foreach ([User::ROLE_MEMBER, User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN] as $role) {
            $user = User::factory()->create(['role' => $role]);

            $this->actingAs($user)
                ->get(route('account.show', ['locale' => 'bs']))
                ->assertOk()
                ->assertSeeText('Promjena lozinke')
                ->assertSee(route('account.password.update'));

            $this->get(route('account.show', ['locale' => 'en']))
                ->assertOk()
                ->assertSeeText('Change password');
        }
    }

    public function test_password_change_requires_the_current_password_and_a_strong_confirmed_new_password(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_MEMBER]);

        $this->actingAs($user)
            ->put(route('account.password.update'), [
                'locale' => 'bs',
                'current_password' => 'wrong-password',
                'password' => 'NewStrongPassword2026',
                'password_confirmation' => 'NewStrongPassword2026',
            ])
            ->assertSessionHasErrors(['current_password']);

        $this->put(route('account.password.update'), [
            'locale' => 'bs',
            'current_password' => 'password',
            'password' => 'weak',
            'password_confirmation' => 'different',
        ])->assertSessionHasErrors(['password']);

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function test_signed_in_user_can_change_password_and_remain_signed_in(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($user)
            ->put(route('account.password.update'), [
                'locale' => 'en',
                'current_password' => 'password',
                'password' => 'NewStrongPassword2026',
                'password_confirmation' => 'NewStrongPassword2026',
            ])
            ->assertRedirect(route('account.show', ['locale' => 'en']))
            ->assertSessionHas('status');

        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Hash::check('NewStrongPassword2026', $user->fresh()->password));
        $this->assertFalse(Hash::check('password', $user->fresh()->password));
    }

    public function test_forgot_password_does_not_claim_mail_was_sent_with_log_mailer(): void
    {
        config()->set('mail.default', 'log');
        Notification::fake();
        $user = User::factory()->create();

        $this->get(route('login', ['locale' => 'bs']))
            ->assertOk()
            ->assertSee(route('password.request', ['locale' => 'bs']));

        $this->post(route('password.email'), [
            'locale' => 'bs',
            'email' => $user->email,
        ])->assertSessionHasErrors(['email']);

        Notification::assertNothingSent();
    }
}
