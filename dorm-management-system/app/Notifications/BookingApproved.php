<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingApproved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $room;

    public function __construct($room)
    {
        $this->room = $room;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Ваша заявка одобрена!')
            ->line('Поздравляем! Ваша заявка на проживание была одобрена.')
            ->line('Комната: ' . $this->room->room_number . ', этаж: ' . $this->room->floor . ', корпус: ' . $this->room->building->name)
            ->action('Перейти в личный кабинет', url('/student/dashboard'))
            ->line('Ждём вас на заселении!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Заявка одобрена!',
            'message' => 'Ваша заявка на заселение в комнату ' . $this->room->room_number . ' была одобрена.',
            'url' => '/student/dashboard',
        ];
    }
}
