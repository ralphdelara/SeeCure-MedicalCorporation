<?php

namespace App\Services;

use App\Events\UserViewed;
use App\Models\Barangay;
use App\Models\City;
use App\Models\Department;
use App\Models\Gender;
use App\Models\Nationality;
use App\Models\Position;
use App\Models\Profession;
use App\Models\Province;
use App\Models\Specialty;
use App\Models\User;
use App\Models\UserAudit;
use Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserService
{
    public function getUserList(
        ?string $keyword,
        ?string $selectId,
        string $path,
    ): array {
        $userList = User::with([
            'gender',
            'province',
            'city',
            'barangay',
            'departments',
            'positions',
            'professions',
            'specialties',
            'audits',
            'createdBy',
            'lastModifiedBy',
        ]);

        if (! empty($keyword)) {
            $userList = $userList->whereBlind('last_name_index', 'last_name_index', strtolower($keyword))
                ->orWhereBlind('first_name_index', 'first_name_index', strtolower($keyword))
                ->orWhereBlind('middle_name_index', 'middle_name_index', strtolower($keyword));
        }

        $userList = $userList->orderBy('batch')
            ->paginate(50)
            ->withPath('/'.$path)->withQueryString();

        $tableData = $userList->collect()->toArray();
        $pageData = Arr::except($userList->toArray(), ['data']);
        $links = app(PageService::class)->limitLinks($userList, 5);
        $pageData['links'] = $links;

        return compact(
            'tableData',
            'pageData',
        );
    }

    public function addOrUpdateUser(array $userDetails): string
    {
        $userId = $userDetails['user_id'];

        unset($userDetails['user_id']);

        if (empty($userId)) {
            $userDetails['status'] = true;
            $userDetails['created_by'] = Auth::id();
        }

        $userDetails['last_modified_by'] = Auth::id();

        $userDetails['username_index'] = $userDetails['username'];

        $userDetails['last_name'] = formatName($userDetails['last_name']);
        $userDetails['first_name'] = formatName($userDetails['first_name']);

        $userDetails['last_name_index'] = $userDetails['last_name'];
        $userDetails['first_name_index'] = $userDetails['first_name'];

        if (! empty($userDetails['middle_name'])) {
            $userDetails['middle_name'] = formatName($userDetails['middle_name']);
            $userDetails['middle_name_index'] = $userDetails['middle_name'];
        }

        $user = User::updateOrCreate(
            ['id' => $userId],
            $userDetails,
        );

        // add or update department data
        $user->departments()->sync($userDetails['department_ids']);

        // add or update position data
        $user->positions()->sync($userDetails['position_ids']);

        // add or update profession data
        $user->professions()->sync($userDetails['profession_ids']);

        // add or update specialties
        $user->specialties()->sync($userDetails['specialty_ids']);

        $this->updateUserOrder();

        return (string) $user->id;
    }

    public function updateUserOrder(): void
    {
        $users = User::select('id', 'last_name', 'first_name', 'middle_name')->get()->toArray();

        usort($users, function ($a, $b) {
            return strcasecmp($a['last_name'], $b['last_name'])
                ?: strcasecmp($a['first_name'], $b['first_name'])
                ?: strcasecmp($a['middle_name'], $b['middle_name']);
        });

        $sequenceNo = 1;

        DB::transaction(function () use ($users, &$sequenceNo) {
            $chunks = array_chunk($users, 2000);

            foreach ($chunks as $chunk) {
                $cases = [];
                $ids = [];
                $params = [];

                foreach ($chunk as $index => $user) {
                    $cases[] = "WHEN id = :id{$index} THEN :batch{$index}::bigint";
                    $ids[] = ":id{$index}";

                    $params["id{$index}"] = $user['id'];
                    $params["batch{$index}"] = $sequenceNo;
                    $sequenceNo++;
                }

                $caseSql = implode(' ', $cases);
                $idSql = implode(',', $ids);

                $sql = "UPDATE users SET batch = CASE {$caseSql} END WHERE id IN ({$idSql})";
                DB::update($sql, $params);
            }
        });
    }

    public function getUserFormOptions(?array $userDetails = null): array
    {
        $provinceId = $userDetails['province_id'] ?? 1; // Aklan
        $cityId = $userDetails['city_id'] ?? 16; // Numancia

        $departmentOptions = Department::all();
        $professionOptions = Profession::all();
        $specialtyOptions = Specialty::all();
        $positionOptions = Position::all();
        $genderOptions = Gender::all();
        $nationalityOptions = Nationality::all();
        $provinceOptions = Province::all();
        $cityOptions = City::select('id', 'name')->where('province_id', '=', $provinceId)->get(); // Aklan
        $barangayOptions = Barangay::select('id', 'name')->where('city_id', '=', $cityId)->get();

        return compact(
            'departmentOptions',
            'professionOptions',
            'specialtyOptions',
            'positionOptions',
            'genderOptions',
            'nationalityOptions',
            'provinceOptions',
            'cityOptions',
            'barangayOptions',
        );
    }

    public function getUserDetails(string $id): array
    {
        if (! Str::isUuid($id)) {
            abort(404);
        }

        $user = User::with([
            'gender',
            'province',
            'city',
            'barangay',
            'departments',
            'positions',
            'professions',
            'specialties',
            'audits',
        ])->find($id);

        if (empty($user)) {
            abort(404);
        }

        UserViewed::dispatch($user);

        $user = $user->toArray();

        $user['departments'] = array_column($user['departments'], 'id');
        $user['positions'] = array_column($user['positions'], 'id');
        $user['professions'] = array_column($user['professions'], 'id');
        $user['specialties'] = array_column($user['specialties'], 'id');

        return $user;
    }

    public function getAuditLog(string $userId): array
    {
        return UserAudit::with([
            'createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'createdBy.professions',
            'createdBy.specialties',
            'auditType',
        ])
            ->select('audit_type_id', 'data', 'created_by', 'created_at')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()->toArray();
    }
}
