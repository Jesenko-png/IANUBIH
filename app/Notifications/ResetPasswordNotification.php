<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly string $token)
    {
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $locale = in_array($this->locale, ['bs', 'en'], true) ? $this->locale : 'bs';
        $url = route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
            'locale' => $locale,
        ]);

        return (new MailMessage)
            ->subject(__('auth.reset_email.subject'))
            ->greeting(__('auth.reset_email.greeting', ['name' => $notifiable->name]))
            ->line(__('auth.reset_email.intro'))
            ->action(__('auth.reset_email.action'), $url)
            ->line(__('auth.reset_email.expiry', [
                'minutes' => config('auth.passwords.users.expire'),
            ]))
            ->line(__('auth.reset_email.ignore'));
    }
}
