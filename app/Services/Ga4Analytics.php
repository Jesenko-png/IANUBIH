<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class Ga4Analytics
{
    private const TOKEN_URL = 'https://oauth2.googleapis.com/token';

    private const SCOPE = 'https://www.googleapis.com/auth/analytics.readonly';

    public function setupIssue(): ?string
    {
        if (! preg_match('/^[0-9]+$/', (string) config('services.ga4.property_id'))) {
            return 'property';
        }

        if (! is_file((string) config('services.ga4.credentials_path'))) {
            return 'credentials';
        }

        if (! extension_loaded('openssl')) {
            return 'openssl';
        }

        return null;
    }

    public function dashboard(): array
    {
        if ($this->setupIssue() !== null) {
            throw new RuntimeException('GA4 configuration is incomplete.');
        }

        $propertyId = (string) config('services.ga4.property_id');

        return Cache::remember('ga4_dashboard_'.$propertyId, now()->addMinutes(20), function () use ($propertyId): array {
            $token = $this->accessToken();
            $response = Http::withToken($token)
                ->acceptJson()
                ->timeout(15)
                ->post("https://analyticsdata.googleapis.com/v1beta/properties/{$propertyId}:batchRunReports", [
                    'requests' => $this->reportRequests(),
                ])
                ->throw();

            $reports = $response->json('reports');

            if (! is_array($reports) || count($reports) !== 4) {
                throw new RuntimeException('GA4 returned an incomplete report batch.');
            }

            $summary = $reports[0]['rows'][0]['metricValues'] ?? [];
            $trend = [];

            foreach ($reports[1]['rows'] ?? [] as $row) {
                $date = $row['dimensionValues'][0]['value'] ?? '';

                if (preg_match('/^[0-9]{8}$/', $date)) {
                    $trend[] = [
                        'date' => substr($date, 6, 2).'.'.substr($date, 4, 2).'.',
                        'users' => $this->metricValue($row['metricValues'] ?? [], 0),
                    ];
                }
            }

            $pages = [];

            foreach ($reports[2]['rows'] ?? [] as $row) {
                $pages[] = [
                    'path' => $row['dimensionValues'][0]['value'] ?? '/',
                    'views' => $this->metricValue($row['metricValues'] ?? [], 0),
                ];
            }

            $countries = [];

            foreach ($reports[3]['rows'] ?? [] as $row) {
                $countries[] = [
                    'country' => $row['dimensionValues'][0]['value'] ?? '',
                    'users' => $this->metricValue($row['metricValues'] ?? [], 0),
                ];
            }

            return [
                'active_users' => $this->metricValue($summary, 0),
                'sessions' => $this->metricValue($summary, 1),
                'page_views' => $this->metricValue($summary, 2),
                'trend' => $trend,
                'pages' => $pages,
                'countries' => $countries,
                'updated_at' => now()->toIso8601String(),
            ];
        });
    }

    private function reportRequests(): array
    {
        $last30Days = [['startDate' => '29daysAgo', 'endDate' => 'today']];

        return [
            [
                'dateRanges' => $last30Days,
                'metrics' => [
                    ['name' => 'activeUsers'],
                    ['name' => 'sessions'],
                    ['name' => 'screenPageViews'],
                ],
            ],
            [
                'dateRanges' => [['startDate' => '13daysAgo', 'endDate' => 'today']],
                'dimensions' => [['name' => 'date']],
                'metrics' => [['name' => 'activeUsers']],
                'orderBys' => [['dimension' => ['dimensionName' => 'date']]],
                'limit' => '14',
            ],
            [
                'dateRanges' => $last30Days,
                'dimensions' => [['name' => 'pagePath']],
                'metrics' => [['name' => 'screenPageViews']],
                'orderBys' => [['metric' => ['metricName' => 'screenPageViews'], 'desc' => true]],
                'limit' => '10',
            ],
            [
                'dateRanges' => $last30Days,
                'dimensions' => [['name' => 'country']],
                'metrics' => [['name' => 'activeUsers']],
                'orderBys' => [['metric' => ['metricName' => 'activeUsers'], 'desc' => true]],
                'limit' => '8',
            ],
        ];
    }

    private function accessToken(): string
    {
        $credentials = json_decode(
            file_get_contents((string) config('services.ga4.credentials_path')) ?: '',
            true,
        );

        if (! is_array($credentials)
            || ($credentials['type'] ?? null) !== 'service_account'
            || ! is_string($credentials['client_email'] ?? null)
            || ! is_string($credentials['private_key'] ?? null)) {
            throw new RuntimeException('GA4 service account credentials are invalid.');
        }

        $issuedAt = time();
        $header = $this->base64Url(json_encode(['alg' => 'RS256', 'typ' => 'JWT'], JSON_THROW_ON_ERROR));
        $claims = $this->base64Url(json_encode([
            'iss' => $credentials['client_email'],
            'scope' => self::SCOPE,
            'aud' => self::TOKEN_URL,
            'iat' => $issuedAt - 30,
            'exp' => $issuedAt + 3300,
        ], JSON_THROW_ON_ERROR));
        $payload = $header.'.'.$claims;

        if (! openssl_sign($payload, $signature, $credentials['private_key'], OPENSSL_ALGO_SHA256)) {
            throw new RuntimeException('GA4 service account signature could not be created.');
        }

        $response = Http::asForm()
            ->acceptJson()
            ->timeout(10)
            ->post(self::TOKEN_URL, [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $payload.'.'.$this->base64Url($signature),
            ])
            ->throw();

        $token = $response->json('access_token');

        if (! is_string($token) || $token === '') {
            throw new RuntimeException('GA4 access token was not returned.');
        }

        return $token;
    }

    private function metricValue(array $values, int $index): int
    {
        return (int) ($values[$index]['value'] ?? 0);
    }

    private function base64Url(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
