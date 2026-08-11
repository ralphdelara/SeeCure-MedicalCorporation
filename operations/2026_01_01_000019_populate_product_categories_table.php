<?php

use App\Models\ProductCategory;
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
        ProductCategory::fillAndInsert([
            ['name' => 'Analgesics / NSAIDs / Antipyretics'],
            ['name' => 'Antibiotics / Anti-infectives'],
            ['name' => 'Anti-diabetics'],
            ['name' => 'Baby Care'],
            ['name' => 'Cardiovascular Drugs'],
            ['name' => 'Cosmetics & Personal Care'],
            ['name' => 'Detergents'],
            ['name' => 'Disinfectants & Cleaners'],
            ['name' => 'Drugs / Pharmaceutical Products'],
            ['name' => 'Energy/Sports Drinks'],
            ['name' => 'Food Supplements & Vitamins'],
            ['name' => 'Food, Beverages & Dietary Supplements'],
            ['name' => 'Gastrointestinal Drugs'],
            ['name' => 'Household / Urban Hazardous Substances (HUHS) & Cosmetics'],
            ['name' => 'Household/Urban Products'],
            ['name' => 'Hygiene Items'],
            ['name' => 'Insecticides'],
            ['name' => 'Juices & Sodas'],
            ['name' => 'Medical Consumables & Surgical Supplies'],
            ['name' => 'Medical Devices & Hospital Supplies'],
            ['name' => 'Milks & Formula'],
            ['name' => 'Oils/Rubbing Agents'],
            ['name' => 'Pre-packaged Foods & Drinks'],
            ['name' => 'Prescription & Over-the-Counter (OTC) Medicines'],
            ['name' => 'Respiratory / Anti-asthma'],
            ['name' => 'Snacks & Biscuits'],
            ['name' => 'Soaps & Cleansers'],
            ['name' => 'Toothpastes'],
        ]);
    }
};
