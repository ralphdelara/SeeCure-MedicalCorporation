<?php

use App\Models\User;
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
        DB::table('company_profile')->insert([
            'company_name'     => 'See Cure Medical Corporation',
            'company_reg_no'   => '',
            'bir_no'           => '',
            'tel_no'           => '(036) 265-3816',
            'phone_no'         => '',
            'email'            => '',
            'clinic_hours'     => 'Daily from 9am - 5pm',
            'address'          => 'F. Carillo St., Poblacion, Numancia, Aklan',
            'landmark'         => 'In front of Black Nazarene Chapel',
            'last_modified_by' => User::whereBlind('last_name_index', 'last_name_index', 'user')
                ->whereBlind('first_name_index', 'first_name_index', 'system')->get()->first()->id,
        ]);
    }
};
