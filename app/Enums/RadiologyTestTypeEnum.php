<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum RadiologyTestTypeEnum: int
{
    use EnumTraits;

    // X-rays Subtypes
    case CHEST_XRAY = 1;
    case SKELETAL_XRAY = 2;
    case MAMMOGRAPHY = 3;
    case DENTAL_XRAY = 4;
    case DEXA_SCAN = 5;

    // CT Scans Subtypes
    case CT_ANGIOGRAPHY = 6;
    case CT_PERFUSION = 7;
    case ABDOMINAL_PELVIC_CT = 8;
    case HIGH_RESOLUTION_CT = 9;
    case VIRTUAL_COLONOSCOPY = 10;

    // MRI Scans Subtypes
    case BRAIN_SPINE_MRI = 11;
    case MUSCULOSKELETAL_MRI = 12;
    case MR_ANGIOGRAPHY_VENOGRAPHY = 13;
    case FUNCTIONAL_MRI = 14;
    case CARDIAC_MRI = 15;

    // Ultrasound Subtypes
    case OBSTETRIC_GYNECOLOGIC_ULTRASOUND = 16;
    case DOPPLER_ULTRASOUND = 17;
    case ECHOCARDIOGRAM = 18;
    case ABDOMINAL_ULTRASOUND = 19;
    case SMALL_PARTS_ULTRASOUND = 20;

    // Nuclear Medicine Subtypes
    case PET_SCAN = 21;
    case SPECT_SCAN = 22;
    case BONE_SCAN = 23;
    case HIDA_THYROID_SCAN = 24;
    case MYOCARDIAL_PERFUSION_IMAGING = 25;

    // Fluoroscopy Subtypes
    case BARIUM_SWALLOW_ENEMA = 26;
    case ARTHROGRAPHY = 27;
    case HYSTEROSALPINGOGRAPHY = 28;
    case LUMBAR_PUNCTURE_GUIDANCE = 29;
    case MYELOGRAPHY = 30;

    // Interventional Radiology Subtypes
    case VASCULAR_IR = 31;
    case ONCOLOGIC_IR = 32;
    case NON_VASCULAR_IR = 33;
    case PAIN_MANAGEMENT_IR = 34;
    case ACCESS_PLACEMENT = 35;

    // Radiation Oncology Subtypes
    case EXTERNAL_BEAM_RADIATION = 36;
    case BRACHYTHERAPY = 37;
    case SYSTEMIC_RADIATION = 38;
    case PROTON_THERAPY = 39;

    public function description(): string
    {
        return match ($this) {
            // X-rays
            self::CHEST_XRAY    => 'Chest X-ray',
            self::SKELETAL_XRAY => 'Skeletal X-ray',
            self::MAMMOGRAPHY   => 'Mammography',
            self::DENTAL_XRAY   => 'Dental X-ray',
            self::DEXA_SCAN     => 'DEXA Scan',

            // CT Scans
            self::CT_ANGIOGRAPHY      => 'CT Angiography (CTA)',
            self::CT_PERFUSION        => 'CT Perfusion',
            self::ABDOMINAL_PELVIC_CT => 'Abdominal/Pelvic CT',
            self::HIGH_RESOLUTION_CT  => 'High-Resolution CT (HRCT)',
            self::VIRTUAL_COLONOSCOPY => 'Virtual Colonoscopy',

            // MRI Scans
            self::BRAIN_SPINE_MRI           => 'Brain and Spine MRI',
            self::MUSCULOSKELETAL_MRI       => 'Musculoskeletal (MSK) MRI',
            self::MR_ANGIOGRAPHY_VENOGRAPHY => 'MR Angiography/Venography (MRA/MRV)',
            self::FUNCTIONAL_MRI            => 'Functional MRI (fMRI)',
            self::CARDIAC_MRI               => 'Cardiac MRI',

            // Ultrasound
            self::OBSTETRIC_GYNECOLOGIC_ULTRASOUND => 'Obstetric/Gynecologic Ultrasound',
            self::DOPPLER_ULTRASOUND               => 'Doppler Ultrasound',
            self::ECHOCARDIOGRAM                   => 'Echocardiogram',
            self::ABDOMINAL_ULTRASOUND             => 'Abdominal Ultrasound',
            self::SMALL_PARTS_ULTRASOUND           => 'Small Parts Ultrasound',

            // Nuclear Medicine
            self::PET_SCAN                     => 'PET Scan',
            self::SPECT_SCAN                   => 'SPECT Scan',
            self::BONE_SCAN                    => 'Bone Scan',
            self::HIDA_THYROID_SCAN            => 'HIDA / Thyroid Scan',
            self::MYOCARDIAL_PERFUSION_IMAGING => 'Myocardial Perfusion Imaging',

            // Fluoroscopy
            self::BARIUM_SWALLOW_ENEMA     => 'Barium Swallow / Enema',
            self::ARTHROGRAPHY             => 'Arthrography',
            self::HYSTEROSALPINGOGRAPHY    => 'Hysterosalpingography (HSG)',
            self::LUMBAR_PUNCTURE_GUIDANCE => 'Lumbar Puncture Guidance',
            self::MYELOGRAPHY              => 'Myelography',

            // Interventional Radiology
            self::VASCULAR_IR        => 'Vascular IR',
            self::ONCOLOGIC_IR       => 'Oncologic IR',
            self::NON_VASCULAR_IR    => 'Non-Vascular IR',
            self::PAIN_MANAGEMENT_IR => 'Pain Management IR',
            self::ACCESS_PLACEMENT   => 'Access Placement',

            // Radiation Oncology
            self::EXTERNAL_BEAM_RADIATION => 'External Beam Radiation Therapy (EBRT)',
            self::BRACHYTHERAPY           => 'Brachytherapy',
            self::SYSTEMIC_RADIATION      => 'Systemic Radiation',
            self::PROTON_THERAPY          => 'Proton Therapy',
        };
    }
}
