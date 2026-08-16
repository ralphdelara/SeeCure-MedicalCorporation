<?php

use App\Models\LaboratoryTestType;
use TimoKoerber\LaravelOneTimeOperations\OneTimeOperation;

return new class extends OneTimeOperation
{
    /**
     * Determine if the operation is being processed asynchronously.
     */
    protected bool $async = true;

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
        LaboratoryTestType::fillAndInsert([
            ['name' => 'Acid-Fast Bacilli (AFB) Smear'],
            ['name' => 'Activated Partial Thromboplastin Time (aPTT)'],
            ['name' => 'Blood Culture and Sensitivity'],
            ['name' => 'Blood Urea Nitrogen (BUN)'],
            ['name' => 'Blood Typing'],
            ['name' => 'Complete Blood Count (CBC)'],
            ['name' => 'Creatinine Test'],
            ['name' => 'Dangerous Drug Screening Test'],
            ['name' => 'Dengue NS1 Rapid Test'],
            ['name' => 'Fasting Blood Sugar (FBS)'],
            ['name' => 'Fecal Occult Blood Test (FOBT)'],
            ['name' => 'Fecalysis'],
            ['name' => 'GeneXpert MTB/RIF Test'],
            ['name' => 'Gram Staining'],
            ['name' => 'Hepatitis B Profile'],
            ['name' => 'HIV Screening'],
            ['name' => 'Histopathology (Tissue Biopsy)'],
            ['name' => 'KOH Mount'],
            ['name' => 'Lipid Profile'],
            ['name' => 'Liver Function Panel (ALT/AST)'],
            ['name' => 'Oral Glucose Tolerance Test (OGTT)'],
            ['name' => 'Pap Smear'],
            ['name' => 'Peripheral Blood Smear'],
            ['name' => 'Polymerase Chain Reaction (PCR) Test'],
            ['name' => 'Pregnancy Test'],
            ['name' => 'Prostate-Specific Antigen (PSA)'],
            ['name' => 'Prothrombin Time (PT)'],
            ['name' => 'Serum Electrolytes'],
            ['name' => 'Stool Culture and Sensitivity'],
            ['name' => 'Syphilis Screening (VDRL/RPR)'],
            ['name' => 'Thyroid Profile'],
            ['name' => 'Uric Acid Test'],
            ['name' => 'Urinalysis'],
            ['name' => 'Urine Culture and Sensitivity'],
            ['name' => 'Wet Smears'],
        ]);
    }
};
