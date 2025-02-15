<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Producto;

class StockDisponibleNotification extends Notification
{
    use Queueable;

    public $producto;

    public function __construct(Producto $producto)
    {
        $this->producto = $producto;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('¡Stock Disponible en Tu Lista de Deseos!')
            ->greeting('Hola ' . $notifiable->user->name . ',')
            ->line('El producto "' . $this->producto->nombre . '" ya está disponible en stock.')
            ->action('Ver Producto', url('/lista-deseos'))
            ->line('¡No pierdas la oportunidad de comprarlo!');
    }
}
