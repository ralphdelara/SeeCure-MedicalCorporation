<?php

namespace App\Console\Commands;

use App\Models\Barangay;
use App\Models\City;
use App\Models\Province;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

#[Signature('patient-consultation:import')]
#[Description('Imports patient consultation data')]
class ImportPatientConsultationDataCsv extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $filePath = base_path('database/data/addresses-upto-zamboanga-sibugay.csv');

        if (! file_exists($filePath)) {
            $this->error("File not found at: {$filePath}");

            return self::FAILURE;
        }

        $this->barangayUpdates();

        $this->info("Starting Address import from: {$filePath}");

        $csvArray = array_map('str_getcsv', file($filePath));
        unset($csvArray[0]); // removes the header

        $bar = $this->output->createProgressBar(count($csvArray));
        $bar->setMessage('Loading address list...');
        $bar->start();

        $warning = [
            'title'   => 'Address Migration in progress',
            'current' => 0,
            'total'   => count($csvArray),
            'msg'     => 'Please sit back and relax while the system is performing data migration.',
        ];
        Cache::put('warning', $warning);

        $tmpCityName = '';
        $tmpProvinceName = '';

        $barangayList = [];
        $cityList = [];
        $cityId = City::count(); // this will ensure the inserted id will continue
        $provinceList = [];
        $provinceId = Province::count(); // this will ensure the inserted id will continue

        foreach ($csvArray as $key => $row) {
            if ($row[2] != $tmpProvinceName) {
                // increment provinceId
                $provinceId++;

                $tmpProvinceName = $row[2];
                $provinceList[] = [
                    'id'   => $provinceId,
                    'name' => $row[2],
                ];
            }

            if ($row[1] != $tmpCityName) {
                // increment cityId
                $cityId++;

                $tmpCityName = $row[1];
                $cityList[] = [
                    'id'          => $cityId,
                    'province_id' => $provinceId,
                    'name'        => $row[1],
                ];
            }

            if (! in_array($row[0], [null, 'NULL', '.', ''])) {

                $barangayList[] = [
                    'province_id' => $provinceId,
                    'city_id'     => $cityId,
                    'name'        => $row[0],
                ];
            }

            $bar->advance();

            $warning['current'] = $key;
            Cache::put('warning', $warning);
        }

        // province first because province id is defined in city and barangay
        Province::fillAndInsert($provinceList);
        City::fillAndInsert($cityList);
        Barangay::fillAndInsert($barangayList);

        $bar->finish();
        Cache::delete('warning');

        return self::SUCCESS;
    }

    public function barangayUpdates(): void
    {
        Barangay::findOrFail(311)->update([
            'name' => 'Aliputos', // replaces "there is no missing"
        ]);

        $newMakatoBarangay = [
            'Agbalogo', 'Aglucay', 'Alibagon', 'Bagong Barrio', 'Baybay',
            'Cabatanga', 'Cajilo', 'Calangcang', 'Calimbajan', 'Castillo', 'Cayangwan', 'Dumga',
            'Libang', 'Mantiguib', 'Poblacion', 'Tibiawan', 'Tina', 'Tugas',
        ];

        $makatoBrgUpdate = Barangay::where('city_id', 11)->get();
        foreach ($makatoBrgUpdate as $key => $brg) {
            Barangay::findOrFail($brg->id)->update([
                'name' => $newMakatoBarangay[$key],
            ]);
        }
    }
}
