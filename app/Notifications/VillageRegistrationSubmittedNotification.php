<?php

namespace App\Notifications;

use App\Models\Village;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VillageRegistrationSubmittedNotification extends Notification
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
            ->subject('Pendaftaran Desa Berhasil Dikirim')
            ->greeting('Halo, '.$notifiable->name)
            ->line('Pendaftaran untuk desa '.$this->village->name.' telah berhasil kami terima.')
            ->line('Saat ini pendaftaran Anda sedang dalam antrean untuk ditinjau oleh Admin Provinsi. Kami akan memberi tahu Anda melalui email apabila pendaftaran telah disetujui atau jika ada yang perlu direvisi.')
            ->action('Lihat Dashboard', route('dashboard'))
            ->line('Terima kasih telah menggunakan Portal Desa!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'village_id' => $this->village->id,
            'message' => 'Pendaftaran '.$this->village->name.' berhasil dikirim dan sedang menunggu review admin.',
            'type' => 'info',
        ];
    }
}
