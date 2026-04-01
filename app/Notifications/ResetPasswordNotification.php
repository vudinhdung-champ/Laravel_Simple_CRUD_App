<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;   // Khai báo hàng đợi //
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;


    public $token;
    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels. (depend on each users, some likes to get notification through mails, other wants to get from the website)
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array   
    {
        $channels = ['mail'];
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $frontendUrl = env('FRONTEND_URL') . '/reset_password?token=' . $this->token . '&email=' . $notifiable->email;
        return (new MailMessage)
            ->subject('Yêu cầu cấp lại mật khẩu')
            ->greeting('Chào bạn!')
            ->line('Chúng tôi nhận được yêu cầu cấp lại mật khẩu cho tài khoản của bạn')
            ->action('Bấm vào đây để đổi mật khẩu', $frontendUrl)
            ->line('Đường link này sẽ hết hạn trong vòng 15 phút')
            ->line('Nếu bạn không yêu cầu, vui lòng bỏ qua email này!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
