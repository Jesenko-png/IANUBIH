<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AnalyticsDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_administrators_can_open_analytics_and_missing_setup_is_explained(): void
    {
        config()->set('services.ga4.property_id', null);
        Http::fake();

        $this->get(route('admin.analytics.index'))->assertRedirect(route('login'));

        $reader = User::factory()->create(['role' => User::ROLE_MEMBER]);
        $this->actingAs($reader)->get(route('admin.analytics.index'))->assertForbidden();

        $administrator = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($administrator)
            ->get(route('admin.analytics.index', ['locale' => 'bs']))
            ->assertOk()
            ->assertSeeText('Povežite GA4 izvještaje')
            ->assertSeeText('Nedostaje brojčani GA4 Property ID');

        Http::assertNothingSent();
    }

    public function test_configured_dashboard_shows_google_reports_without_exposing_credentials(): void
    {
        $this->configureServiceAccount();
        Http::fake([
            'https://oauth2.googleapis.com/token' => Http::response(['access_token' => 'private-test-token'], 200),
            'https://analyticsdata.googleapis.com/*' => Http::response([
                'reports' => [
                    ['rows' => [['metricValues' => [['value' => '24'], ['value' => '35'], ['value' => '81']]]]],
                    ['rows' => [['dimensionValues' => [['value' => '20260929']], 'metricValues' => [['value' => '9']]]]],
                    ['rows' => [['dimensionValues' => [['value' => '/bs']], 'metricValues' => [['value' => '42']]]]],
                    ['rows' => [['dimensionValues' => [['value' => 'Bosnia and Herzegovina']], 'metricValues' => [['value' => '19']]]]],
                ],
            ], 200),
        ]);

        $administrator = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($administrator)
            ->get(route('admin.analytics.index', ['locale' => 'en']))
            ->assertOk()
            ->assertSeeText('Traffic overview')
            ->assertSeeText('24')
            ->assertSeeText('35')
            ->assertSeeText('81')
            ->assertSeeText('/bs')
            ->assertSeeText('Bosnia and Herzegovina')
            ->assertDontSee('private-test-token');

        $this->get(route('admin.analytics.index', ['locale' => 'en']))->assertOk();
        Http::assertSentCount(2);
        Http::assertSent(function ($request) {
            return str_contains($request->url(), '123456789:batchRunReports')
                && count($request['requests']) === 4
                && $request->hasHeader('Authorization', 'Bearer private-test-token');
        });
    }

    public function test_failed_google_request_shows_safe_error_instead_of_fake_numbers(): void
    {
        $this->configureServiceAccount();
        Http::fake([
            'https://oauth2.googleapis.com/token' => Http::response(['access_token' => 'private-test-token'], 200),
            'https://analyticsdata.googleapis.com/*' => Http::response(['error' => ['message' => 'Permission denied']], 403),
        ]);

        $administrator = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($administrator)
            ->get(route('admin.analytics.index', ['locale' => 'bs']))
            ->assertOk()
            ->assertSeeText('Podatke trenutno nije moguće učitati')
            ->assertDontSee('private-test-token');
    }

    private function configureServiceAccount(): void
    {
        config()->set('services.ga4.property_id', '123456789');
        config()->set('cache.default', 'array');
        Storage::fake('local');

        $keyOptions = ['private_key_bits' => 2048];
        $localOpenSslConfig = dirname(PHP_BINARY).'/extras/ssl/openssl.cnf';

        if (is_file($localOpenSslConfig)) {
            $keyOptions['config'] = $localOpenSslConfig;
        }

        $key = openssl_pkey_new($keyOptions);
        $this->assertNotFalse($key);
        $this->assertTrue(openssl_pkey_export($key, $privateKey, null, $keyOptions));

        Storage::disk('local')->put('ga4-service-account.json', json_encode([
            'type' => 'service_account',
            'client_email' => 'dashboard-test@example.iam.gserviceaccount.com',
            'private_key' => $privateKey,
        ]));

        config()->set('services.ga4.credentials_path', Storage::disk('local')->path('ga4-service-account.json'));
    }
}
