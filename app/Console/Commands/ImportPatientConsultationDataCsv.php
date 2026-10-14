<?php

namespace App\Console\Commands;

use App\Enums\VisitStatusEnum;
use App\Enums\VitalSignsEnum;
use App\Enums\VitalSignsFieldEnum;
use App\Models\Consultation;
use App\Models\ConsultationSoap;
use App\Models\Diagnosis;
use App\Models\Patient;
use App\Models\PatientVitalSign;
use App\Models\Visit;
use Auth;
use DB;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

#[Signature('patient-consultation:import')]
#[Description('Imports patient consultation data')]
class ImportPatientConsultationDataCsv extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->encryptConsultationFields();

        $filePath = base_path('database/data/consultation-details-vitalsigns-soap.csv');

        if (! file_exists($filePath)) {
            $this->error("File not found at: {$filePath}");

            return self::FAILURE;
        }

        $this->info("Starting Patient Consultation import from: {$filePath}");

        if (($handle = fopen($filePath, 'r')) !== false) {
            // fgetcsv automatically handles newlines inside quotes
            while (($data = fgetcsv($handle, 0, ',')) !== false) {
                $csvArray[] = $data;
            }
            fclose($handle);
        }
        unset($csvArray[0]); // removes the header

        $bar = $this->output->createProgressBar(count($csvArray));
        $bar->setMessage('Loading consultation list...');
        $bar->start();

        $warning = [
            'title'   => 'Patient Consultation Migration in progress',
            'current' => 0,
            'total'   => count($csvArray),
            'msg'     => 'Please sit back and relax while the system is performing data migration.',
        ];
        Cache::put('warning', $warning);

        $consultationList = [];
        $vitalSigns = [];
        $soap = [];

        $patientIds = Patient::select('id', 'old_patient_id')->where('old_patient_id', '!=', null)->get()->toArray();
        $patientIds = array_column($patientIds, 'id', 'old_patient_id');

        foreach ($csvArray as $key => $row) {
            if (empty($patientIds[$row[1]])) {
                continue;
            }

            // create Visit record
            $visit = Visit::create([
                'patient_id'       => $patientIds[$row[1]],
                'visit_status_id'  => VisitStatusEnum::COMPLETED,
                'has_consultation' => true,
                'created_by'       => Auth::systemUser()->id,
                'last_modified_by' => Auth::systemUser()->id,
                'created_at'       => $row[2],
                'updated_at'       => $row[2],
            ]);

            // consultation details with old_patient_id as array key
            $doctorId = (empty($row[3]) || $row[3] === 'NULL') ? Auth::systemUser()->id : $row[3];

            $consultation = Consultation::create([
                'visit_id'         => $visit->id,
                'old_consult_id'   => $row[0],
                'consult_reason'   => (empty($row[10]) || $row[10] === 'NULL') ? null : $row[10],
                'is_completed'     => true,
                'doctor_id'        => $doctorId,
                'created_by'       => $doctorId,
                'last_modified_by' => $doctorId,
                'created_at'       => $row[2],
                'updated_at'       => $row[2],
            ]);

            $this->insertVitalSigns($row, $consultation->id, $patientIds[$row[1]]);

            $this->insertSoap($row, $consultation->id, $doctorId);

            $bar->advance();

            $warning['current'] = $key;
            Cache::put('warning', $warning);
        }

        $bar->finish();
        Cache::delete('warning');

        $this->info('Success! Patient consultation data has been migrated');

        return self::SUCCESS;
    }

    public function encryptConsultationFields()
    {
        $this->info('Encrypting consult_reason and prescription_remarks');

        $consultationQuery = DB::table('consultations')->select('id', 'consult_reason', 'prescription_remarks')
            ->get()->toArray();

        foreach ($consultationQuery as $data) {
            DB::table('consultations')
                ->where('id', $data->id)
                ->update([
                    'consult_reason'       => ! empty($data->consult_reason) ? Crypt::encryptString($data->consult_reason) : null,
                    'prescription_remarks' => ! empty($data->prescription_remarks) ? Crypt::encryptString($data->prescription_remarks) : null,
                ]);
        }

        $this->info('Encrypting successful!');
    }

    public function insertVitalSigns(array $row, string $consultationId, string $patientId): void
    {
        $vitalSigns = [];
        // Vital signs with old_consult_id as array key
        // Blood Pressure
        if (
            ! empty($row[4])
            && $row[4] !== 'NULL'
            && trim($row[4]) !== ''
        ) {
            $row[4] = str_replace('*', '/', $row[4]);
            $row[4] = str_replace('\\', '/', $row[4]);

            if (str_contains($row[4], '/')) {
                $bp = explode('/', $row[4]);
            } else {
                $bp = [$row[4]];
            }

            $vitalSigns[] = [
                'patient_id'          => $patientId,
                'consultation_id'     => $consultationId,
                'vital_sign_id'       => VitalSignsEnum::BLOOD_PRESSURE,
                'vital_sign_field_id' => VitalSignsFieldEnum::SYSTOLIC,
                'value'               => $bp[0],
                'created_by'          => Auth::systemUser()->id,
                'last_modified_by'    => Auth::systemUser()->id,
                'created_at'          => $row[2],
                'updated_at'          => $row[2],
            ];

            if (! empty($bp[1])) {
                $vitalSigns[] = [
                    'patient_id'          => $patientId,
                    'consultation_id'     => $consultationId,
                    'vital_sign_id'       => VitalSignsEnum::BLOOD_PRESSURE,
                    'vital_sign_field_id' => VitalSignsFieldEnum::DIASTOLIC,
                    'value'               => $bp[1],
                    'created_by'          => Auth::systemUser()->id,
                    'last_modified_by'    => Auth::systemUser()->id,
                    'created_at'          => $row[2],
                    'updated_at'          => $row[2],
                ];
            }
        }

        if (
            ! empty($row[5])
            && $row[5] !== 'NULL'
            && trim($row[5]) !== ''
        ) {
            // Cardiac Rate
            $vitalSigns[] = [
                'patient_id'          => $patientId,
                'consultation_id'     => $consultationId,
                'vital_sign_id'       => VitalSignsEnum::CARDIAC_RATE,
                'vital_sign_field_id' => VitalSignsFieldEnum::CARDIAC_RATE,
                'value'               => $row[5],
                'created_by'          => Auth::systemUser()->id,
                'last_modified_by'    => Auth::systemUser()->id,
                'created_at'          => $row[2],
                'updated_at'          => $row[2],
            ];
        }

        if (
            ! empty($row[6])
            && $row[6] !== 'NULL'
            && trim($row[6]) !== ''
        ) {
            // Respiratory Rate
            $vitalSigns[] = [
                'patient_id'          => $patientId,
                'consultation_id'     => $consultationId,
                'vital_sign_id'       => VitalSignsEnum::RESPIRATORY_RATE,
                'vital_sign_field_id' => VitalSignsFieldEnum::RESPIRATORY_RATE,
                'value'               => $row[6],
                'created_by'          => Auth::systemUser()->id,
                'last_modified_by'    => Auth::systemUser()->id,
                'created_at'          => $row[2],
                'updated_at'          => $row[2],
            ];
        }

        if (
            ! empty($row[7])
            && $row[7] !== 'NULL'
            && trim($row[7]) !== ''
        ) {
            // Oxygen Saturation
            $vitalSigns[] = [
                'patient_id'          => $patientId,
                'consultation_id'     => $consultationId,
                'vital_sign_id'       => VitalSignsEnum::OXYGEN_SATURATION,
                'vital_sign_field_id' => VitalSignsFieldEnum::PERCENTAGE,
                'value'               => $row[7],
                'created_by'          => Auth::systemUser()->id,
                'last_modified_by'    => Auth::systemUser()->id,
                'created_at'          => $row[2],
                'updated_at'          => $row[2],
            ];
        }

        if (
            ! empty($row[8])
            && $row[8] !== 'NULL'
            && trim($row[8]) !== ''
        ) {
            // Weight
            $vitalSigns[] = [
                'patient_id'          => $patientId,
                'consultation_id'     => $consultationId,
                'vital_sign_id'       => VitalSignsEnum::BODY_WEIGHT,
                'vital_sign_field_id' => VitalSignsFieldEnum::WEIGHT,
                'value'               => $row[8],
                'created_by'          => Auth::systemUser()->id,
                'last_modified_by'    => Auth::systemUser()->id,
                'created_at'          => $row[2],
                'updated_at'          => $row[2],
            ];
        }

        if (
            ! empty($row[9])
            && $row[9] !== 'NULL'
            && trim($row[9]) !== ''
        ) {
            // Degrees
            $vitalSigns[] = [
                'patient_id'          => $patientId,
                'consultation_id'     => $consultationId,
                'vital_sign_id'       => VitalSignsEnum::TEMPERATURE,
                'vital_sign_field_id' => VitalSignsFieldEnum::DEGREES,
                'value'               => $row[9],
                'created_by'          => Auth::systemUser()->id,
                'last_modified_by'    => Auth::systemUser()->id,
                'created_at'          => $row[2],
                'updated_at'          => $row[2],
            ];
        }

        if (! empty($vitalSigns)) {
            PatientVitalSign::fillAndInsert($vitalSigns);
        }
    }

    public function insertSoap(array $row, string $consultationId, string $doctorId): void
    {
        $subjective = '';

        if (! empty($row[14]) && $row[14] !== 'NULL') {
            $subjective .= $row[14]."\n\n";
        }

        if (! empty($row[12]) && $row[12] !== 'NULL') {
            $subjective .= $row[12]."\n\n";
        }

        if (! empty($row[13]) && $row[13] !== 'NULL') {
            $assessment = $row[13];
        } else {
            $assessment = null;
        }

        $plan = (empty($row[15]) || $row[15] === 'NULL') ? null : $row[15];

        // SOAP with old_consult_id as array key
        ConsultationSoap::fillAndInsert([[
            'consultation_id'  => $consultationId,
            'subjective'       => $subjective,
            'assessment'       => $assessment,
            'plan'             => $plan,
            'created_by'       => $doctorId,
            'last_modified_by' => $doctorId,
            'created_at'       => $row[2],
            'updated_at'       => $row[2],
        ]]);

        Diagnosis::create([
            'consultation_id'  => $consultationId,
            'diagnosis'        => $assessment,
            'created_by'       => $doctorId,
            'last_modified_by' => $doctorId,
            'created_at'       => $row[2],
            'updated_at'       => $row[2],
        ]);
    }
}
