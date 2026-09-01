<?php

namespace App\Notifications;

use App\Models\Village;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VillageRejectedNotification extends Notification
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
            ->subject('Pendaftaran Desa Perlu Revisi')
            ->greeting('Halo, '.$notifiable->name)
            ->line('Mohon maaf, pendaftaran untuk '.$this->village->name.' belum dapat kami setujui saat ini.')
            ->line('Catatan dari Admin Provinsi:')
            ->line('"'.$this->village->rejection_reason.'"')
            ->line('Anda dapat memperbaiki data sesuai catatan di atas dan mengirim ulang pendaftaran melalui dashboard Anda.')
            ->action('Lihat Dashboard', route('dashboard'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'village_id' => $this->village->id,
            'message' => 'Pendaftaran '.$this->village->name.' ditolak. Alasan: '.$this->village->rejection_reason,
            'type' => 'error',
        ];
    }
}
