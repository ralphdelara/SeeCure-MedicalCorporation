<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class DoctorService
{
    public function getDoctorList(): Collection
    {
        return User::with(['department', 'professions', 'specialties', 'position'])
            ->select('id', 'first_name', 'middle_name', 'last_name')
            ->where('department_id', 2) // Consultation
            ->whereHas('professions', function ($query) {
                $query->where('professions.id', 1); // Doctor
            })
            ->whereDoesntHave('specialties')->orderBy('last_name')->get()->map(function ($user) {
                return [
                    'id'   => $user->id,
                    'name' => $user->full_name,
                ];
            });
    }
}
