<?php

use App\Enums\LaboratoryPackageEnum;
use App\Models\LaboratoryPackageTest;
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
        $array = [];

        foreach (LaboratoryPackageEnum::cases() as $packageCase) {
            foreach ($packageCase->tests() as $testCase) {
                $array[] = [
                    'laboratory_package_id' => $packageCase->value,
                    'laboratory_test_id' => $testCase->value,
                ];
            }
        }

        LaboratoryPackageTest::fillAndInsert($array);
    }
};
