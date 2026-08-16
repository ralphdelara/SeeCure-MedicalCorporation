<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class DoctorService
{
    public function getDoctorList(): Collection
    {
        return User::with(['departments.department', 'professions.profession', 'position'])
            ->select('id', 'first_name', 'last_name')
            ->whereHas('departments', function ($query) {
                $query->where('user_departments.department_id', 2); // Consultation
            })
            ->whereHas('position', function ($query) {
                $query->where('positions.id', 6); // General Practitioner
            })->orderBy('last_name')->get()
            ->map(function ($user) {
                $name = $user->last_name.' '.$user->first_name;
                foreach ($user->professions as $profession) {
                    $prefix = $profession->profession->prefix;

                    $name = $prefix.$name.', '.$profession->profession->suffix;
                }

                return [
                    'id'   => $user->id,
                    'name' => $name,
                ];
            });
    }
}
