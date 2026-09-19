<?php

namespace App\Services;

use App\Enums\VisitStatusEnum;
use App\Models\Billing;
use App\Models\Patient;
use App\Models\Visit;
use Arr;
use Illuminate\Database\Eloquent\Builder;

class RadiologyService
{
    public function getRadiologyList(
        ?string $keyword,
        ?string $status,
        string $path
    ): array {
        $billingList = Billing::with([
            'patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'age', 'gender_id', 'patient_suffix_id');
            },
            'patient.gender' => function ($query) {
                $query->select('id', 'name');
            },
            'createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'createdBy.professions',
            'createdBy.specialties',
            'lastModifiedBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'lastModifiedBy.professions',
            'lastModifiedBy.specialties',
            'visit',
        ]);

        if (! empty($keyword)) {
            $billingList = $billingList->whereHas('visit.patient', function ($query) use ($keyword) {
                /** @var Builder|Patient $query */
                $query->whereBlind('last_name_index', 'last_name_index', strtolower($keyword))
                    ->orWhereBlind('first_name_index', 'first_name_index', strtolower($keyword))
                    ->orWhereBlind('middle_name_index', 'middle_name_index', strtolower($keyword));
            });
        }

        if ($status === 'completed') {
            $billingList = $billingList->where('is_completed', true);
        } else {
            $billingList = $billingList->whereHas('visit', function ($query) {
                $query->where('visit_status_id', VisitStatusEnum::IN_RADIOLOGY)
                    ->where('is_completed', false);
            });
        }

        $billingList = $billingList->orderBy('created_at')->paginate(50)
            ->withPath('/'.$path)->withQueryString();

        $tableData = $billingList->collect()->toArray();
        $pageData = Arr::except($billingList->toArray(), ['data']);
        $links = app(PageService::class)->limitLinks($billingList, 5);
        $pageData['links'] = $links;

        return compact(
            'tableData',
            'pageData',
        );
    }

    public function storeRadiology(
        string $patientId,
        string $visitId,
        string $consultationId,
    ): string {
        return '';
    }

    public function getSmallPendingRadiologyList(): array
    {
        return Visit::with([
            'patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'patient_suffix_id', 'age', 'gender_id');
            },
            'patient.gender' => function ($query) {
                $query->select('id', 'name');
            },
            'patient.suffix' => function ($query) {
                $query->select('id', 'name');
            },
        ])->whereVisitStatusId(VisitStatusEnum::IN_RADIOLOGY)->get()->toArray();
    }
}
