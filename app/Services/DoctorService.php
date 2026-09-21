<?php

namespace App\Services;

use App\Enums\DepartmentEnum;
use App\Enums\ProfessionEnum;
use App\Models\User;
use Illuminate\Support\Collection;

class DoctorService
{
    public function getDoctorList(): Collection
    {
        return User::with(['departments', 'professions', 'specialties', 'positions'])
            ->select('id', 'first_name', 'middle_name', 'last_name')
            ->whereHas('departments', function ($query) {
                $query->where('departments.id', DepartmentEnum::CONSULTATION);
            })
            ->whereHas('professions', function ($query) {
                $query->where('professions.id', ProfessionEnum::DOCTOR);
            })
            ->whereDoesntHave('specialties')->orderBy('last_name')->get()->map(function ($user) {
                return [
                    'id'   => $user->id,
                    'name' => $user->full_name,
                ];
            });
    }
}
