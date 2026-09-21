<?php

namespace Database\Seeders;

use App\Models\Village;
use App\Models\VillageDemographic;
use Illuminate\Database\Seeder;

class DemographicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $village = Village::where('slug', 'pujon-kidul')->first();

        if (! $village) {
            $village = Village::published()->first();
        }

        if (! $village) {
            $this->command->warn('No published village found. Skipping demographic seeder.');

            return;
        }

        // Jenis Kelamin
        VillageDemographic::updateOrCreate(['village_id' => $village->id, 'type' => 'gender', 'label' => 'Laki-laki'], ['count' => 2145]);
        VillageDemographic::updateOrCreate(['village_id' => $village->id, 'type' => 'gender', 'label' => 'Perempuan'], ['count' => 2210]);

        // Usia
        VillageDemographic::updateOrCreate(['village_id' => $village->id, 'type' => 'age', 'label' => '0 - 14 Tahun'], ['count' => 845]);
        VillageDemographic::updateOrCreate(['village_id' => $village->id, 'type' => 'age', 'label' => '15 - 64 Tahun'], ['count' => 2950]);
        VillageDemographic::updateOrCreate(['village_id' => $village->id, 'type' => 'age', 'label' => '> 65 Tahun'], ['count' => 560]);

        // Agama
        VillageDemographic::updateOrCreate(['village_id' => $village->id, 'type' => 'religion', 'label' => 'Islam'], ['count' => 4200]);
        VillageDemographic::updateOrCreate(['village_id' => $village->id, 'type' => 'religion', 'label' => 'Kristen'], ['count' => 120]);
        VillageDemographic::updateOrCreate(['village_id' => $village->id, 'type' => 'religion', 'label' => 'Katolik'], ['count' => 35]);

        $this->command->info("Data demografi berhasil ditambahkan untuk desa: {$village->name}");
    }
}
