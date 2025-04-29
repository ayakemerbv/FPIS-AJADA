<?php

namespace App\Notifications;

use AllowDynamicProperties;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

#[AllowDynamicProperties] class UserCredentials extends Notification implements ShouldQueue
{
    use Queueable;

    protected $password;
    protected $user_id;
    protected $email;

    public function __construct($user_id,$email, $password)
    {
        $this->user_id = $user_id;
        $this->user_email=$email;
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Ваши учетные данные для входа в DMS')
            ->greeting('Здравствуйте!')
            ->line('Вы были зарегистрированы в системе DMS.')
            ->line('Ваши учетные данные для входа:')
            ->line('ID пользователя: ' . $this->user_id)
            ->line('Email: ' . $this->user_email)
            ->line('Пароль: ' . $this->password)
            ->action('Войти в систему', url('/'))
            ->line('Рекомендуем сменить пароль после первого входа.');
    }
}
