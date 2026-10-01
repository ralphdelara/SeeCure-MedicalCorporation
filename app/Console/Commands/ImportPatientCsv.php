<?php

namespace App\Console\Commands;

use App\Enums\GenderEnum;
use App\Enums\NationalityEnum;
use App\Enums\PatientStatusEnum;
use App\Models\Patient;
use App\Services\PatientService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

#[Signature('patient:import')]
#[Description('Imports patient from csv file then save it to database and updates blind indexes')]
class ImportPatientCsv extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $filePath = base_path('database/data/old-patients.csv');

        if (! file_exists($filePath)) {
            $this->error("File not found at: {$filePath}");

            return self::FAILURE;
        }

        $this->info("Starting Patient import from: {$filePath}");

        $csvArray = array_map('str_getcsv', file($filePath));
        unset($csvArray[0]); // removes the header

        $bar = $this->output->createProgressBar(count($csvArray));
        $bar->setMessage('Loading patient list...');
        $bar->start();

        $warning = [
            'title'   => 'Patient Migration in progress',
            'current' => 0,
            'total'   => count($csvArray),
            'msg'     => 'Please sit back and relax while the system is performing data migration.',
        ];
        Cache::put('warning', $warning);

        foreach ($csvArray as $key => $row) {
            if ($row[14] < 8375) {
                continue;
            }
            DB::transaction(function () use ($row, $bar) {
                $gender = match ($row[7]) {
                    '0'     => GenderEnum::MALE,
                    '1'     => GenderEnum::FEMALE,
                    default => null,
                };
                $civilStatus = $row[15];
                $dateOfBirth = $row[6];
                $lastName = $row[2] !== 'NULL' ? $row[2] : '';
                $firstName = $row[3] !== 'NULL' ? $row[3] : '';
                $middleName = $row[4] !== 'NULL' ? $row[4] : '';

                Patient::create([
                    'old_patient_id'    => $row[1],
                    'control_no'        => $row[14] !== 'NULL' ? $row[14] : null,
                    'last_name'         => ucwords(strtolower($lastName)),
                    'first_name'        => ucwords(strtolower($firstName)),
                    'middle_name'       => ucwords(strtolower($middleName)),
                    'last_name_index'   => strtolower($lastName),
                    'first_name_index'  => strtolower($firstName),
                    'middle_name_index' => strtolower($middleName),
                    'date_of_birth'     => ! in_array($dateOfBirth, ['', 'NULL']) ? $dateOfBirth : null,
                    'age'               => $row[5] !== 'NULL' ? $row[5] : null,
                    'contact_number1'   => $row[12] !== 'NULL' ? $row[12] : null,
                    'contact_number2'   => $row[13] !== 'NULL' ? $row[13] : null,
                    'occupation'        => $row[19] !== 'NULL' ? $row[19] : null,
                    'street'            => $row[8] !== 'NULL' ? $row[8] : null,
                    'gender_id'         => $gender,
                    'civil_status_id'   => $civilStatus !== '' ? ((int) $civilStatus + 1) : '',
                    'nationality_id'    => NationalityEnum::FILIPINO,
                    'status_id'         => PatientStatusEnum::INACTIVE,
                    'created_by'        => Auth::systemUser()->id,
                    'last_modified_by'  => Auth::systemUser()->id,
                ]);

                $bar->advance();
            });

            $warning['current'] = $key;
            Cache::put('warning', $warning);
        }

        $bar->finish();
        Cache::delete('warning');

        $this->info("\nOrder Patient List");
        app(PatientService::class)->updatePatientOrder();

        return self::SUCCESS;
    }
}
