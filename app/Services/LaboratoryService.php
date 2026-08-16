<?php

namespace App\Services;

use App\Models\Consultation;
use Arr;
use Illuminate\Support\Facades\Auth;

class LaboratoryService
{
    public function storeLaboratory(
        string $visitId,
        string $patientId,
        array $consultDetails,
    ): int {
        return 0;
    }
}
