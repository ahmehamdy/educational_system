<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AccountApprovalNotification extends Notification
{
    use Queueable;

    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        if ($this->status === 'approved') {
            return (new MailMessage)
                ->subject('✅ Account Approved')
                ->greeting('Hello ' . $notifiable->name . ',')
                ->line('Your account has been approved by the admin.')
                ->line('You can now log in and use the system.')
                ->salutation('Best regards, Admin Team');
        } else {
            return (new MailMessage)
                ->subject('❌ Account Rejected')
                ->greeting('Hello ' . $notifiable->name . ',')
                ->line('We’re sorry to inform you that your account has been rejected.')
                ->line('If you believe this was a mistake, please contact support.')
                ->salutation('Best regards, Admin Team');
        }
    }
}
