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

        $firstNames = [
            'Ralph',
            'Gio',
            'Tweeny',
            'Riva',
            'Alecsandra',
            'Dezenith',
            'Robelyn',
            'Atela Marie',
            'Nene',
            'Donna',
            'Lyka',
            'Amria Canice',
            'Bianca Ysobel',
            'Charles Eugene',
            'Christian Paulo',
            'Keziah Emm',
            'Lyka Loraine',
            'Palomar',
            'Arnelie',
            'Keith Louise',
            'Mary Angela',
            'Riva',
            'Riezl Antonette',
            'Tricia Ann',
            'Ma. Angel',
        ];

        $lastNames = [
            'De Lara',
            'Solano',
            'Arboleda',
            'Esponilla',
            'Gacote',
            'Nedic',
            'Tolsa',
            'Taningco',
            'Nene',
            'Alcazarin',
            'Lyka',
            'Laude',
            'Tabaar',
            'Villanoche',
            'Reyes',
            'Miraflor',
            'Zulueta',
            'Palomar',
            'Fenera',
            'Vega',
            'Rasgo',
            'Esponilla',
            'Mationg',
            'Soquiat',
            'Silverio',
        ];

        $middleNames = [
            '',
            'M',
            'R',
            'N',
            'G',
            'V',
            'M',
            '',
            'N',
            'N',
            'l',
            'N',
            'S',
            '.',
            'T',
            'S',
            'N',
            '.',
            'D',
            'R',
            'V',
            'N',
            'T',
            'A',
            'N',
        ];

        $userNames = [
            'ralph',
            'gio',
            'tweenny',
            'riva',
            'alecs',
            'dez',
            'rob',
            'atela',
            'nene',
            'don',
            'lyka',
            'amria',
            'bianca',
            'charles',
            'christian',
            'keziah',
            'loraine',
            'palomar',
            'arnelie',
            'louise',
            'mary',
            'riva',
            'riezl',
            'tricia',
            'angel',
        ];

        foreach ($firstNames as $key => $data) {
            User::create([
                'username'         => $userNames[$key],
                'password'         => Hash::make($userNames[$key]),
                'last_name'        => $lastNames[$key],
                'first_name'       => $data,
                'middle_name'      => $middleNames[$key],
                'first_name_index' => $data,
                'last_name_index'  => $lastNames[$key],
                'username_index'   => $userNames[$key],
                'department_id'    => 1, // Admin
                'position_id'      => 1,
                'status'           => true,
                'created_by'       => $user->id, // System User
                'last_modified_by' => $user->id, // System User
            ]);
        }
    }
};
