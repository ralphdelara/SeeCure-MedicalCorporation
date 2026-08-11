<?php

use App\Models\ProductUnit;
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
        ProductUnit::fillAndInsert([
            ['name' => 'amp'],
            ['name' => 'bar'],
            ['name' => 'bottle'],
            ['name' => 'box'],
            ['name' => 'can'],
            ['name' => 'candle'],
            ['name' => 'cap'],
            ['name' => 'cc'],
            ['name' => 'coil'],
            ['name' => 'cup'],
            ['name' => 'fee'],
            ['name' => 'lozenges'],
            ['name' => 'nebule'],
            ['name' => 'oxygen'],
            ['name' => 'pack'],
            ['name' => 'pads'],
            ['name' => 'piece'],
            ['name' => 'pencil'],
            ['name' => 'respule'],
            ['name' => 'sachet'],
            ['name' => 'softgel'],
            ['name' => 'strip'],
            ['name' => 'suppository'],
            ['name' => 'tab'],
            ['name' => 'tablet'],
            ['name' => 'tube'],
            ['name' => 'units'],
            ['name' => 'vial'],
        ]);
    }
};
