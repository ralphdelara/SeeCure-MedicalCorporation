<?php

use App\Enums\DepartmentEnum;
use App\Enums\PositionEnum;
use App\Enums\ProfessionEnum;
use App\Models\User;
use App\Services\UserService;
use TimoKoerber\LaravelOneTimeOperations\OneTimeOperation;

return new class extends OneTimeOperation
{
    /**
     * Determine if the operation is being processed asynchronously.
     */
    protected bool $async = false;

    /**
     * The queue that the job will be dispatched to.
     */
    protected string $queue = 'default';

    /**
     * A tag name, that this operation can be filtered by.
     */
    protected ?string $tag = null;

    /**
     * Process the operation.
     */
    public function process(): void
    {
        $user = User::create([
            'first_name'       => 'SYSTEM',
            'last_name'        => 'USER',
            'username'         => 'system_user',
            'password'         => Hash::make('system_pass'),
            'gender_id'        => 4, // Unknown
            'status'           => true,
            'department_id'    => 1, // Admin
            'position_id'      => 14, // Bot
            'first_name_index' => 'SYSTEM',
            'last_name_index'  => 'USER',
            'username_index'   => 'system_user',
            'created_by'       => null,
        ]);
        $user->departments()->sync([DepartmentEnum::ADMINISTRATOR, DepartmentEnum::INFORMATION_TECHNOLOGY]);
        $user->positions()->sync([PositionEnum::BOT]);

        $defaultUserId = $user->id;

        $usersArray = [
            [
                'first_name'  => 'Ralph',
                'middle_name' => 'F',
                'last_name'   => 'De Lara',
                'username'    => 'ralph',
                'password'    => 'ralph',
                'departments' => [DepartmentEnum::ADMINISTRATOR, DepartmentEnum::INFORMATION_TECHNOLOGY],
                'positions'   => [PositionEnum::SOFTWARE_ENGINEER],
                'professions' => [ProfessionEnum::IT],
            ],
            [
                'first_name'  => 'Alecsandra',
                'middle_name' => 'G',
                'last_name'   => 'Gacote',
                'username'    => 'alec',
                'password'    => 'alec',
                'departments' => [DepartmentEnum::FRONT_DESK],
                'positions'   => [PositionEnum::STAFF],
                'professions' => [ProfessionEnum::STAFF],
            ],
            [
                'first_name'  => 'Ivy',
                'middle_name' => '',
                'last_name'   => 'Ivy',
                'username'    => 'ivy',
                'password'    => 'ivy',
                'departments' => [DepartmentEnum::FRONT_DESK, DepartmentEnum::RADIOLOGY],
                'positions'   => [PositionEnum::STAFF],
                'professions' => [ProfessionEnum::STAFF],
            ],
            [
                'first_name'  => 'Dezenith',
                'middle_name' => 'V',
                'last_name'   => 'Nedic',
                'username'    => 'dess',
                'password'    => 'dess',
                'departments' => [DepartmentEnum::ADMINISTRATOR, DepartmentEnum::BILLING],
                'positions'   => [PositionEnum::STAFF],
                'professions' => [ProfessionEnum::STAFF],
            ],
            [
                'first_name'  => 'Tweenny',
                'middle_name' => 'Reyes',
                'last_name'   => 'Arboleda',
                'username'    => 'tweenny',
                'password'    => 'tweenny',
                'departments' => [DepartmentEnum::ADMINISTRATOR, DepartmentEnum::CONSULTATION],
                'positions'   => [PositionEnum::GENERAL_PRACTITIONER],
                'professions' => [ProfessionEnum::DOCTOR],
            ],
            [
                'first_name'  => 'Lyka Loraine',
                'middle_name' => 'Nedic',
                'last_name'   => 'Zulueta',
                'username'    => 'loraine',
                'password'    => 'loraine',
                'departments' => [DepartmentEnum::CONSULTATION],
                'positions'   => [PositionEnum::GENERAL_PRACTITIONER],
                'professions' => [ProfessionEnum::DOCTOR],
            ],
            [
                'first_name'  => 'Amria',
                'middle_name' => 'Nillasca',
                'last_name'   => 'Laude',
                'username'    => 'amria',
                'password'    => 'amria',
                'departments' => [DepartmentEnum::CONSULTATION],
                'positions'   => [PositionEnum::GENERAL_PRACTITIONER],
                'professions' => [ProfessionEnum::DOCTOR],
            ],
            [
                'first_name'  => 'Bianca Ysobel',
                'middle_name' => 'S.',
                'last_name'   => 'Tabañar',
                'username'    => 'bianca',
                'password'    => 'bianca',
                'departments' => [DepartmentEnum::CONSULTATION],
                'positions'   => [PositionEnum::GENERAL_PRACTITIONER],
                'professions' => [ProfessionEnum::DOCTOR],
            ],
            [
                'first_name'  => 'Kezia Emm',
                'middle_name' => 'S',
                'last_name'   => 'Miraflor',
                'username'    => 'kezia',
                'password'    => 'kezia',
                'departments' => [DepartmentEnum::CONSULTATION],
                'positions'   => [PositionEnum::GENERAL_PRACTITIONER],
                'professions' => [ProfessionEnum::DOCTOR],
            ],
            [
                'first_name'  => 'Charles Eugene',
                'middle_name' => 'I',
                'last_name'   => 'Villanoche',
                'username'    => 'charles',
                'password'    => 'charles',
                'departments' => [DepartmentEnum::CONSULTATION],
                'positions'   => [PositionEnum::GENERAL_PRACTITIONER],
                'professions' => [ProfessionEnum::DOCTOR],
            ],
            [
                'first_name'  => 'Atela',
                'middle_name' => '',
                'last_name'   => 'Taningco',
                'username'    => 'atela',
                'password'    => 'atela',
                'departments' => [DepartmentEnum::PHARMACY],
                'positions'   => [PositionEnum::PHARMACIST],
                'professions' => [ProfessionEnum::PHARMACIST],
            ],
            [
                'first_name'  => 'Vheng',
                'middle_name' => '',
                'last_name'   => 'Vheng',
                'username'    => 'vheng',
                'password'    => 'vheng',
                'departments' => [DepartmentEnum::CASHIER],
                'positions'   => [PositionEnum::STAFF],
                'professions' => [ProfessionEnum::STAFF],
            ],
            [
                'first_name'  => 'Lyka',
                'middle_name' => '',
                'last_name'   => 'Lyka',
                'username'    => 'lyka',
                'password'    => 'lyka',
                'departments' => [DepartmentEnum::LABORATORY, DepartmentEnum::BILLING],
                'positions'   => [PositionEnum::LABORATORY_AIDE, PositionEnum::STAFF],
                'professions' => [ProfessionEnum::STAFF],
            ],
            [
                'first_name'  => 'Lara',
                'middle_name' => '',
                'last_name'   => 'Lara',
                'username'    => 'lara',
                'password'    => 'lara',
                'departments' => [DepartmentEnum::FINANCE],
                'positions'   => [PositionEnum::ACCOUNTANT],
                'professions' => [ProfessionEnum::STAFF],
            ],
            [
                'first_name'  => 'Czariena',
                'middle_name' => '',
                'last_name'   => 'Czariena',
                'username'    => 'czariena',
                'password'    => 'czariena',
                'departments' => [DepartmentEnum::FINANCE],
                'positions'   => [PositionEnum::ACCOUNTANT],
                'professions' => [ProfessionEnum::STAFF],
            ],
        ];

        foreach ($usersArray as $data) {
            $realUsers = User::create([
                'username'         => $data['username'],
                'password'         => $data['password'],
                'last_name'        => $data['last_name'],
                'first_name'       => $data['first_name'],
                'middle_name'      => $data['middle_name'],
                'first_name_index' => $data['first_name'],
                'last_name_index'  => $data['last_name'],
                'username_index'   => $data['username'],
                'status'           => true,
                'created_by'       => $defaultUserId, // System USER
                'last_modified_by' => $defaultUserId, // System USER
            ]);

            $realUsers->departments()->sync($data['departments']);
            $realUsers->positions()->sync($data['positions']);
            $realUsers->professions()->sync($data['professions']);
            $realUsers->specialties()->sync($data['specialties'] ?? []);
        }

        app(UserService::class)->updateUserOrder();
    }
};
