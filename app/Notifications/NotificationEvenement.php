<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationEvenement extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    // protected $evenement;

    public function __construct(protected $evenement , protected $eleve)
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $subject = $this->evenement->libelle;
        $greeting = $this->isMorning() ? 'Bonjour' : 'Bonsoir';
        $dateEvenement = $this->evenement->date_evenement;
        $eleve = $this->eleve;
        return (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->line("$eleve")
            ->line("Il y a un nouvel événement : $subject")
            ->line("Date de l'événement : $dateEvenement");
    }

    protected function isMorning()
    {
        $hour = now()->hour;
        return $hour >= 6 && $hour < 12;
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
