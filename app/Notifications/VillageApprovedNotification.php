<?php

namespace App\Notifications;

use App\Models\Village;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VillageApprovedNotification extends Notification
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
            ->subject('Selamat! Halaman Desa Anda Telah Tayang')
            ->greeting('Halo, '.$notifiable->name)
            ->line('Kabar gembira! Pendaftaran untuk '.$this->village->name.' telah disetujui oleh Admin Provinsi.')
            ->line('Halaman publik desa Anda kini sudah dapat diakses oleh masyarakat umum.')
            ->action('Lihat Halaman Desa', url('/desa/'.$this->village->slug))
            ->line('Anda dapat memperbarui profil, daftar perangkat, maupun berita kapan saja melalui dashboard.')
            ->line('Terima kasih telah bergabung di Portal Desa.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'village_id' => $this->village->id,
            'message' => 'Selamat! Pendaftaran desa '.$this->village->name.' telah disetujui dan halaman Anda sudah tayang.',
            'type' => 'success',
        ];
    }
}
