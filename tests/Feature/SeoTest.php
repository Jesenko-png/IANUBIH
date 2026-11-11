<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_contains_public_localized_urls_without_private_pages(): void
    {
        $response = $this->get('/sitemap.xml')->assertOk();
        $xml = simplexml_load_string($response->getContent());
        $this->assertNotFalse($xml);
        $urls = array_map(fn ($entry) => (string) $entry->loc, iterator_to_array($xml->url, false));

        $this->assertContains(url('/bs'), $urls);
        $this->assertContains(url('/en'), $urls);
        $this->assertContains(url('/bs/projects'), $urls);
        $this->assertNotContains(url('/login'), $urls);
        $this->assertNotContains(url('/admin'), $urls);

        foreach ($urls as $url) {
            $this->assertStringNotContainsString('{', $url);
        }
    }

    public function test_homepage_exposes_valid_organization_and_website_data(): void
    {
        foreach (['bs', 'en'] as $locale) {
            $response = $this->get('/'.$locale)->assertOk();
            preg_match('~<script type="application/ld\+json">(.*?)</script>~s', $response->getContent(), $matches);
            $data = json_decode($matches[1] ?? '', true, 512, JSON_THROW_ON_ERROR);

            $this->assertSame('WebSite', $data['@graph'][0]['@type']);
            $this->assertSame('IASABIH', $data['@graph'][0]['name']);
            $this->assertSame('Organization', $data['@graph'][1]['@type']);
            $response->assertSee('hreflang="x-default"', false);
        }
    }
}
