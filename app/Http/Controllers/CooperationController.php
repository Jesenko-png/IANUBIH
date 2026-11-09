<?php

namespace App\Http\Controllers;

use App\Mail\CooperationInquiry as CooperationInquiryMail;
use App\Models\CooperationInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class CooperationController extends Controller
{
    private const PARTNER_TYPES = [
        'institution',
        'donor',
        'researcher',
        'young_scientist',
        'media',
        'other',
    ];

    public function show(): View
    {
        return view('pages.cooperation');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->filled('website')) {
            return $this->successRedirect();
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:190'],
            'organization' => ['nullable', 'string', 'max:190'],
            'partner_type' => ['required', Rule::in(self::PARTNER_TYPES)],
            'initiative_title' => ['required', 'string', 'max:190'],
            'message' => ['required', 'string', 'min:30', 'max:5000'],
            'consent' => ['accepted'],
        ], __('cooperation.form.validation'));

        unset($validated['consent']);
        $validated['organization'] ??= null;

        $locale = app()->getLocale();

        try {
            Mail::mailer(config(
                'mail.cooperation.mailer',
                app()->environment('production') ? 'sendmail' : config('mail.default'),
            ))
                ->to(
                    config('mail.cooperation.to.address', 'info@iasabih.ba'),
                    config('mail.cooperation.to.name', 'IASABIH'),
                )
                ->send(new CooperationInquiryMail($validated, $locale));
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('cooperation_error', __('cooperation.form.error'));
        }

        try {
            CooperationInquiry::create([
                ...$validated,
                'locale' => $locale,
            ]);
        } catch (Throwable $exception) {
            // E-mail je primarni kanal. Ne prikazuj grešku pošiljaocu ako je
            // poruka uspješno poslana, ali zabilježi problem sa arhiviranjem.
            report($exception);
        }

        return $this->successRedirect();
    }

    private function successRedirect(): RedirectResponse
    {
        return redirect(route('cooperation', ['locale' => app()->getLocale()]).'#cooperation-form')
            ->with('cooperation_success', __('cooperation.form.success'));
    }
}
