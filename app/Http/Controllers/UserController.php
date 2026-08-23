<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        $formOptions = app(UserService::class)->getUserFormOptions();
        $userList = app(UserService::class)->getUserList(
            $request->keyword,
            $request->selectId,
            $request->path(),
        );

        return Inertia::render('user/index', compact(
            'formOptions',
            'userList',
        ));
    }

    public function getUserDetails(string $id): Response
    {
        $userDetails = app(UserService::class)->getUserDetails($id);
        $formOptions = app(UserService::class)->getUserFormOptions($userDetails);

        return Inertia::render('user/details/index', compact(
            'formOptions',
            'userDetails',
        ));
    }

    public function addOrUpdateUser(Request $request): void
    {
        $userDetails = $request->only(
            'user_id',
            'username',
            'password',
            'last_name',
            'first_name',
            'middle_name',
            'gender_id',
            'date_of_birth',
            'contact_number',
            'email',
            'house_no',
            'street',
            'barangay_id',
            'city_id',
            'province_id',
            'license_no',
            'ptr_no',
            'date_hired',
            'date_resigned',
            'status',
            'department_id',
            'position_id',
            'profession_ids',
            'specialty_ids',
            'photo',
        );

        if (! empty($userDetails['user_id']) && empty($userDetails['password'])) {
            unset($userDetails['password']);
        }

        app(UserService::class)->addOrUpdateUser($userDetails);
    }

    public function deleteUser(string $userId): void
    {
        User::destroy($userId);
    }
}
