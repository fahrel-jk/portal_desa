<?php

namespace App\Notifications;

use App\Models\Village;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VillageRegisteredNotification extends Notification
{
    use Queueable;

    public function __construct(public Village $village) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pendaftaran Desa Baru: '.$this->village->name)
            ->greeting('Halo Admin,')
            ->line('Terdapat pendaftaran desa baru yang masuk dan menunggu persetujuan.')
            ->line('Desa: '.$this->village->name)
            ->line('Pendaftar: '.$this->village->user->name.' ('.$this->village->user->email.')')
            ->action('Review Pendaftaran', route('admin.review', $this->village))
            ->line('Silakan lakukan peninjauan melalui dashboard admin.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'village_id' => $this->village->id,
            'message' => 'Pendaftaran baru dari '.$this->village->name.' menunggu review Anda.',
            'type' => 'warning',
        ];
    }
}
