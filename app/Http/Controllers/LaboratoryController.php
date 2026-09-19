<?php

namespace App\Http\Controllers;

use App\Enums\PositionEnum;
use App\Models\Laboratory;
use App\Models\User;
use App\Services\LaboratoryService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LaboratoryController extends Controller
{
    public function getLaboratoryList(Request $request, ?string $status = null): Response
    {
        $formOptions = app(LaboratoryService::class)->getLaboratoryFormOptions();
        $laboratoryList = app(LaboratoryService::class)->getLaboratoryList(
            $request->keyword,
            $status,
            $request->path(),
        );

        return Inertia::render('laboratory/index', compact(
            'formOptions',
            'laboratoryList',
        ));
    }

    public function getTests(string $id): array
    {
        return app(LaboratoryService::class)->getTests($id);
    }

    public function addOrUpdateLaboratory(Request $request): void {}

    public function getLaboratoryDetails(string $id): Response
    {
        $laboratoryDetails = app(LaboratoryService::class)->getLaboratoryDetails($id);
        $patientDetails = $laboratoryDetails['visit']['patient'];

        $staffOptionsArr = User::with('professions', 'specialties')->whereIn(
            'position_id',
            [
                PositionEnum::HEAD_OF_LABORATORY,
                PositionEnum::MEDICAL_TECHNOLOGIST,
                PositionEnum::MEDICAL_TECHNOLOGIST_SUPERVISOR,
            ],
        )->get()->toArray();

        $staffOptions = array_map(fn ($item) => [
            'id'   => $item['id'],
            'name' => $item['full_name'],
        ], $staffOptionsArr);

        return Inertia::render('laboratory/details/index', compact(
            'laboratoryDetails',
            'patientDetails',
            'staffOptions',
        ));
    }

    public function deleteLaboratory(string $id): void
    {
        Laboratory::destroy($id);
    }

    public function updateDetails(Request $request): void
    {
        $details = $request->all();

        app(LaboratoryService::class)->updateDetails($details);
    }

    public function getAuditLog(string $id): array
    {
        return app(LaboratoryService::class)->getAuditLog($id);
    }

    public function completeLaboratory(string $id): void
    {
        app(LaboratoryService::class)->completeLaboratory($id);
    }
}
