<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\SoapSaved;
use App\Models\ConsultationAudit;
use App\Models\ConsultationSoap;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Crypt;
use Log;

class LogSoapSave implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(SoapSaved $event): void
    {
        $soap = $event->soap;
        $type = $event->type;
        $savedFields = $event->savedFields;
        $originalFields = $event->originalFields;

        if ($type === 'created') {
            $data = $this->created($soap);
        } else {
            $data = $this->updated($soap, $savedFields, $originalFields);
        }

        ConsultationAudit::create([
            'consultation_id' => $soap->consultation_id,
            'audit_type_id'   => $type === 'created' ? AuditTypeEnum::ADD : AuditTypeEnum::UPDATE,
            'data'            => json_encode($data),
            'created_by'      => Auth::id() ?? Auth::systemUser()->id,
        ]);
    }

    public function created(ConsultationSoap $soap): array
    {
        $fields = $soap->getAttributes();

        $this->removeUnimportantFields($fields);

        $fields['subjective'] = $soap->subjective;
        $fields['assessment'] = $soap->assessment;
        $fields['plan'] = $soap->plan;

        return [
            'title'  => 'S O A P has been added.',
            'fields' => [
                [
                    'field' => 'Subjective',
                    'to'    => $soap->subjective,
                ], [
                    'field' => 'Assessment',
                    'to'    => $soap->assessment,
                ], [
                    'field' => 'Plan',
                    'to'    => $soap->plan,
                ],
            ],
        ];
    }

    public function updated(
        ConsultationSoap $soap,
        array $savedFields,
        array $originalFields,
    ): array {
        $fields = [];

        foreach ($savedFields as $field => $newValue) {
            $oldValue = $originalFields[$field];

            if ($soap->hasCast($field, 'encrypted')) {
                try {
                    $newValue = Crypt::decryptString($newValue);
                } catch (DecryptException $e) {
                    Log::error($e->getMessage());
                }
            }

            $castType = $soap->getCasts()[$field] ?? '';
            $isDate = str_starts_with($castType, 'date') || str_starts_with($castType, 'datetime');

            if ($isDate) {
                // Safely extract the format or fall back to your default string template
                $format = str_contains($castType, ':')
                    ? explode(':', $castType, 2)[1]
                    : 'M d Y, h:i:s a';

                // Safely parse and convert values with Carbon
                if ($oldValue) {
                    $oldValue = Carbon::parse($oldValue)->format($format);
                }
                if ($newValue) {
                    $newValue = Carbon::parse($newValue)->format($format);
                }
            }

            $fields[] = [
                'field' => $field,
                'from'  => $oldValue,
                'to'    => $newValue,
            ];
        }

        return [
            'title'  => 'S O A P has been updated.',
            'fields' => $fields,
        ];
    }

    private function removeUnimportantFields(array &$fields): void
    {
        $exclude = [
            'id', 'consultation_id',
            'created_by', 'created_at',
            'last_modified_by', 'updated_at',
        ];

        foreach ($exclude as $key) {
            unset($fields[$key]);
        }
    }
}
