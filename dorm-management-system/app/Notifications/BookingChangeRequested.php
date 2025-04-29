<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingChangeRequested extends Notification implements ShouldQueue
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
            ->subject('Заявка на смену комнаты отправлена')
            ->line('Ваша заявка на смену комнаты была отправлена.')
            ->line('Новая комната: ' . $this->room->room_number . ', этаж: ' . $this->room->floor . ', корпус: ' . $this->room->building->name)
            ->line('Ожидайте решения администратора.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Заявка на смену комнаты',
            'message' => 'Ваша заявка на смену комнаты ' . $this->room->room_number . ' отправлена на рассмотрение.',
            'url' => '/student/personal',
        ];
    }
}
