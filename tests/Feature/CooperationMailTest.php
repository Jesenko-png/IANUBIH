<?php

namespace Tests\Feature;

use App\Mail\CooperationInquiry as CooperationInquiryMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CooperationMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_collaboration_proposal_is_emailed_to_the_academy_and_archived(): void
    {
        Mail::fake();

        $this->post('/bs/cooperation', $this->validProposal())
            ->assertRedirect('/bs/cooperation#cooperation-form')
            ->assertSessionHas('cooperation_success');

        Mail::assertSent(CooperationInquiryMail::class, function (CooperationInquiryMail $mail): bool {
            return $mail->hasTo('info@iasabih.ba')
                && $mail->hasFrom('info@iasabih.ba')
                && $mail->hasReplyTo('partner@example.com');
        });

        $this->assertDatabaseHas('cooperation_inquiries', [
            'email' => 'partner@example.com',
            'initiative_title' => 'Zajednički istraživački projekat',
            'locale' => 'bs',
        ]);
    }

    public function test_email_is_still_sent_when_the_archive_table_is_not_ready(): void
    {
        Mail::fake();
        Schema::drop('cooperation_inquiries');

        $this->post('/bs/cooperation', $this->validProposal())
            ->assertRedirect('/bs/cooperation#cooperation-form')
            ->assertSessionHas('cooperation_success');

        Mail::assertSent(CooperationInquiryMail::class, 1);
    }

    public function test_public_collaboration_buttons_link_directly_to_the_form(): void
    {
        foreach (['/bs', '/bs/fields', '/bs/projects'] as $page) {
            $this->get($page)
                ->assertOk()
                ->assertSee('/bs/cooperation#cooperation-form', false);
        }
    }

    private function validProposal(): array
    {
        return [
            'name' => 'Partner Institucija',
            'email' => 'partner@example.com',
            'organization' => 'Univerzitet Sarajevo',
            'partner_type' => 'institution',
            'initiative_title' => 'Zajednički istraživački projekat',
            'message' => 'Predlažemo zajednički istraživački projekat sa jasno definisanim ciljevima i partnerima.',
            'consent' => '1',
        ];
    }
}
