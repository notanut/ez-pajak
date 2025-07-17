<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifikasiEmail extends Notification
{
    use Queueable;
    protected $pesan;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $pesan)
    {
        //
        $this->pesan = $pesan;
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
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Haiii')
                    ->line($this->pesan['hi'])
                    ->line($this->pesan['isi'])
                    // ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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

    // --INI CARA LAIN MISAL MAU PAKAI HTML CSS BUAT BIKIN BENTUK EMAILNYA--
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Pengingat Terjadwal Anda', // Subjek email
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     // Menentukan view mana yang akan digunakan untuk konten email
    //     return new Content(
    //         markdown: 'emails.notifikasi',
    //     );
    // }
}
