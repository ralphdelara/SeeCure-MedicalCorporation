<?php

namespace App\Console\Commands;

use App\Models\Barangay;
use App\Models\City;
use App\Models\Patient;
use App\Models\Province;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

#[Signature('patient-addresses:import')]
#[Description('Imports patient addresses')]
class ImportPatientAddressesCsv extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $filePath = base_path('database/data/missing-patient-addresses.csv');

        if (! file_exists($filePath)) {
            $this->error("File not found at: {$filePath}");

            return self::FAILURE;
        }

        $this->info("Starting Patient Address import from: {$filePath}");

        $csvArray = array_map('str_getcsv', file($filePath));
        unset($csvArray[0]); // removes the header

        $bar = $this->output->createProgressBar(count($csvArray));
        $bar->setMessage('Loading address list...');
        $bar->start();

        $warning = [
            'title'   => 'Loading Patient Addresses',
            'current' => 0,
            'total'   => count($csvArray),
            'msg'     => 'Please sit back and relax while the system is performing data migration.',
        ];
        Cache::put('warning', $warning);

        $provinceList = array_column(Province::all()->toArray(), 'id', 'name');
        $cityList = array_column(City::all()->toArray(), 'id', 'name');
        $barangayList = array_column(Barangay::all()->toArray(), 'id', 'name');

        $provincePatientIds = [];
        $cityPatientIds = [];
        $barangayPatientIds = [];

        foreach ($csvArray as $key => $row) {
            $oldPatientId = $row[0];
            $barangayName = $row[1];
            $cityName = $row[2];
            $provinceName = $row[3];

            // checks and add old patient id to the province id
            if (array_key_exists($provinceName, $provinceList)) {
                $provincePatientIds[$provinceList[$provinceName]][] = $oldPatientId;
            }

            // checks and add old patient id to the city id
            if (array_key_exists($cityName, $cityList)) {
                $cityPatientIds[$cityList[$cityName]][] = $oldPatientId;
            }

            // checks and add old patient id to the baranggay id
            if (array_key_exists($barangayName, $barangayList)) {
                $barangayPatientIds[$barangayList[$barangayName]][] = $oldPatientId;
            }

            $bar->advance();

            $warning['current'] = $key;
            Cache::put('warning', $warning);
        }
        $bar->finish();

        $totalCount = count($provincePatientIds) + count($cityPatientIds) + count($barangayPatientIds);
        $bar = $this->output->createProgressBar($totalCount);
        $current = 0;
        $warning['title'] = 'Patient Address Migration in progress';
        $warning['current'] = $current;
        $warning['total'] = $totalCount;
        Cache::put('warning', $warning);

        foreach ($provincePatientIds as $provinceId => $patientIds) {
            $current++;
            Patient::whereIn('old_patient_id', $patientIds)->update([
                'province_id' => $provinceId,
            ]);
            $bar->advance();

            $warning['current'] = $current;
            Cache::put('warning', $warning);
        }

        foreach ($cityPatientIds as $cityId => $patientIds) {
            $current++;
            Patient::whereIn('old_patient_id', $patientIds)->update([
                'city_id' => $cityId,
            ]);
            $bar->advance();

            $warning['current'] = $current;
            Cache::put('warning', $warning);
        }

        foreach ($barangayPatientIds as $barangayId => $patientIds) {
            $current++;
            Patient::whereIn('old_patient_id', $patientIds)->update([
                'barangay_id' => $barangayId,
            ]);
            $bar->advance();

            $warning['current'] = $current;
            Cache::put('warning', $warning);
        }

        $bar->finish();
        Cache::delete('warning');
        $this->info("\nPatient Address migration completed!");

        return self::SUCCESS;
    }
}
