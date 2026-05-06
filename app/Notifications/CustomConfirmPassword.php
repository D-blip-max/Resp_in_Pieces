<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;

class CustomConfirmPassword extends VerifyEmailNotification
{
    use Queueable;

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Confirmar contraseña')
            ->view('emails.confirm-password', [
                'user' => $notifiable,
                'actionUrl' => route('password.confirm'),
            ]);
    }
}
