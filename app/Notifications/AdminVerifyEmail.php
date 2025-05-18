<?php
namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class AdminVerifyEmail extends VerifyEmail
{
    /**
     * Get the verification email notification mail message for the admin.
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verify Your Admin Email Address')
            ->greeting('Hello Admin,')
            ->line('Please click the button below to verify your email address.')
            ->action('Verify Email Address', $verificationUrl)
            ->line('If you did not create an admin account, no further action is required.');
    }

    /**
     * Generate the verification URL for admin guard.
     */
    protected function verificationUrl($notifiable)
    {
        $appUrl = config('app.url');

        return URL::temporarySignedRoute(
            'admin.verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}

