<?php

use App\Models\City;
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
        City::fillAndInsert([
            ['name' => 'Altavas', 'province_id' => 1],
            ['name' => 'Balete', 'province_id' => 1],
            ['name' => 'Banga', 'province_id' => 1],
            ['name' => 'Batan', 'province_id' => 1],
            ['name' => 'Buruanga', 'province_id' => 1],
            ['name' => 'Ibajay', 'province_id' => 1],
            ['name' => 'Kalibo', 'province_id' => 1],
            ['name' => 'Lezo', 'province_id' => 1],
            ['name' => 'Libacao', 'province_id' => 1],
            ['name' => 'Madalag', 'province_id' => 1],
            ['name' => 'Makato', 'province_id' => 1],
            ['name' => 'Malay', 'province_id' => 1],
            ['name' => 'Malinao', 'province_id' => 1],
            ['name' => 'Nabas', 'province_id' => 1],
            ['name' => 'New Washington', 'province_id' => 1],
            ['name' => 'Numancia', 'province_id' => 1],
            ['name' => 'Tangalan', 'province_id' => 1],
        ]);
    }
};
