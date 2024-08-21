<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL; // Import the URL facade

class VerifyEmailNotification extends Notification
{
    use Queueable;

   public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('Verify Your Email Address')
        ->greeting('Hello!')
        ->line('Welcome to My Journal! Please verify your email address.')
        ->action('Verify Email', $this->verificationUrl($notifiable))
        ->line('Thank you for using our application!')
        ->line('<img src="' . asset('images/logo.png') . '" alt="Logo" style="width: 200px; height: auto;">
')
        ->markdown('mail.notification');
}


    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->email)]
        );
    }
}
