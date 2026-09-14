<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditType whereName($value)
 * @mixin \Eloquent
 */
	class AuditType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $city_id
 * @property int $province_id
 * @property-read City $city
 * @property-read Province $province
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereProvinceId($value)
 * @mixin \Eloquent
 */
	class Barangay extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $visit_id
 * @property numeric|null $total_price
 * @property numeric|null $total_discount
 * @property numeric|null $total_tax
 * @property numeric|null $total_nett_price
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BillingAudit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BillingDetail> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\User|null $lastModifiedBy
 * @property-read \App\Models\Visit|null $visit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereTotalDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereTotalNettPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereTotalTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereVisitId($value)
 * @property string $patient_id
 * @property bool $is_completed
 * @property-read \App\Models\Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing wherePatientId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Cashier|null $cashier
 */
	class Billing extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $billing_id
 * @property int $audit_type_id
 * @property string $data
 * @property string $created_by
 * @property CarbonImmutable $created_at
 * @property-read AuditType $auditType
 * @property-read Billing $billing
 * @property-read User $createdBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingAudit whereBillingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingAudit whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingAudit whereId($value)
 * @mixin \Eloquent
 */
	class BillingAudit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $billing_id
 * @property int $billing_type_id
 * @property string $name
 * @property numeric|null $price
 * @property numeric|null $discount
 * @property numeric|null $tax
 * @property numeric|null $nett_price
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Billing|null $billing
 * @property-read User $createdBy
 * @property-read User|null $lastModifiedBy
 * @property-read BillingType $type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereBillingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereBillingTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereNettPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereUpdatedAt($value)
 * @property int|null $discount_type_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereDiscountTypeId($value)
 * @mixin \Eloquent
 * @property numeric|null $tax_percent
 * @property numeric|null $tax_amount
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereTaxPercent($value)
 */
	class BillingDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingType whereName($value)
 * @mixin \Eloquent
 */
	class BillingType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $patient_id
 * @property string $visit_id
 * @property string $billing_id
 * @property numeric|null $total_cost_price
 * @property numeric|null $total_price
 * @property numeric|null $total_discount
 * @property numeric|null $total_tax
 * @property numeric|null $total_nett_price
 * @property bool $is_completed
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CashierAudit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Billing $billing
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CashierDetail> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\User|null $lastModifiedBy
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\Payment|null $payment
 * @property-read \App\Models\Visit $visit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereBillingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereTotalCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereTotalDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereTotalNettPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereTotalTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereVisitId($value)
 */
	class Cashier extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $cashier_id
 * @property int $audit_type_id
 * @property string $data
 * @property string $created_by
 * @property \Carbon\CarbonImmutable $created_at
 * @property-read \App\Models\AuditType $auditType
 * @property-read \App\Models\Cashier $cashier
 * @property-read \App\Models\User $createdBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierAudit whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierAudit whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierAudit whereId($value)
 */
	class CashierAudit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $cashier_id
 * @property int $cashier_type_id
 * @property string $name
 * @property numeric|null $cost_price
 * @property int $quantity
 * @property numeric|null $total_price
 * @property numeric|null $discount
 * @property int|null $discount_type_id
 * @property numeric|null $tax_percent
 * @property numeric|null $tax_amount
 * @property numeric|null $nett_price
 * @property int $order
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Cashier $cashier
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\DiscountType|null $discountType
 * @property-read \App\Models\User|null $lastModifiedBy
 * @property-read \App\Models\CashierType $type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereCashierTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereDiscountTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereNettPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereTaxPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereUpdatedAt($value)
 */
	class CashierDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierType whereName($value)
 */
	class CashierType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $province_id
 * @property-read Collection<int, Barangay> $barangays
 * @property-read int|null $barangays_count
 * @property-read Province $province
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereProvinceId($value)
 * @mixin \Eloquent
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CivilStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CivilStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CivilStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CivilStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CivilStatus whereName($value)
 * @mixin \Eloquent
 */
	class CivilStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $visit_id
 * @property string $patient_id
 * @property string|null $guardian_name
 * @property string|null $guardian_contact_number
 * @property string|null $guardian_email
 * @property int|null $guardian_relationship_id
 * @property string|null $diagnosis
 * @property string $doctor_id
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read User $createdBy
 * @property-read User $doctor
 * @property-read Relationship|null $guardianRelationship
 * @property-read User|null $lastModifiedBy
 * @property-read Patient|null $patient
 * @property-read Collection<int, PatientVitalSign> $patientVitalSign
 * @property-read int|null $patient_vital_sign_count
 * @property-read Collection<int, ConsultationSignsOrSymptom> $signsOrSymptoms
 * @property-read int|null $signs_or_symptoms_count
 * @property-read Visit $visit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereGuardianContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereGuardianEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereGuardianName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereGuardianRelationshipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereVisitId($value)
 * @property string|null $follow_up_date
 * @property-read Collection<int, ConsultationAudit> $audits
 * @property-read int|null $audits_count
 * @property-read Collection<int, Document> $documents
 * @property-read int|null $documents_count
 * @property-read Laboratory|null $laboratory
 * @property-read Collection<int, Prescription> $prescriptions
 * @property-read int|null $prescriptions_count
 * @property-read Radiology|null $radiology
 * @property-read ConsultationSoap|null $soap
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereFollowUpDate($value)
 * @property bool $is_completed
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereIsCompleted($value)
 * @mixin \Eloquent
 * @property-read int|null $laboratory_count
 */
	class Consultation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $consultation_id
 * @property int $audit_type_id
 * @property string $data
 * @property string $created_by
 * @property CarbonImmutable $created_at
 * @property-read AuditType $auditType
 * @property-read Consultation $consultation
 * @property-read User $createdBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationAudit whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationAudit whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationAudit whereId($value)
 * @mixin \Eloquent
 */
	class ConsultationAudit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $diagnosis
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Consultation|null $consultation
 * @property-read User $createdBy
 * @property-read Collection<string, ConsultationDiagnosisIcd10Code> $icd10Codes
 * @property-read User|null $lastModifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis whereDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis whereUpdatedAt($value)
 * @property string $consultation_id
 * @property-read int|null $icd10_codes_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis whereConsultationId($value)
 * @mixin \Eloquent
 */
	class ConsultationDiagnosis extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $consultation_id
 * @property string $consultation_diagnosis_id
 * @property string|null $icd10_code_id
 * @property string $created_by
 * @property CarbonImmutable $created_at
 * @property-read Consultation $consultation
 * @property-read ConsultationDiagnosis $consultationDiagnosis
 * @property-read User $createdBy
 * @property-read Icd10Code|null $icd10
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosisIcd10Code newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosisIcd10Code newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosisIcd10Code query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosisIcd10Code whereConsultationDiagnosisId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosisIcd10Code whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosisIcd10Code whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosisIcd10Code whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosisIcd10Code whereIcdCodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosisIcd10Code whereId($value)
 * @property-read Icd10Code|null $icd10Code
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosisIcd10Code whereIcd10CodeId($value)
 * @mixin \Eloquent
 */
	class ConsultationDiagnosisIcd10Code extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $consultation_id
 * @property int $signs_or_symptom_id
 * @property-read Consultation $consultation
 * @property-read SignsOrSymptom $signsOrSymptom
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSignsOrSymptom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSignsOrSymptom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSignsOrSymptom query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSignsOrSymptom whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSignsOrSymptom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSignsOrSymptom whereSignsOrSymptomId($value)
 * @mixin \Eloquent
 */
	class ConsultationSignsOrSymptom extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $consultation_id
 * @property string|null $subjective
 * @property string|null $assessment
 * @property string|null $plan
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSoap newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSoap newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSoap query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSoap whereAssessment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSoap whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSoap whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSoap whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSoap whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSoap whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSoap wherePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSoap whereSubjective($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSoap whereUpdatedAt($value)
 * @property-read User $createdBy
 * @property-read User|null $lastModifiedBy
 * @mixin \Eloquent
 */
	class ConsultationSoap extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereName($value)
 * @mixin \Eloquent
 */
	class Department extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountType whereName($value)
 * @mixin \Eloquent
 */
	class DiscountType extends \Eloquent {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document query()
 * @mixin \Eloquent
 */
	class Document extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gender newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gender newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gender query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gender whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gender whereName($value)
 * @mixin \Eloquent
 */
	class Gender extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10Code newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10Code newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10Code query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10Code whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10Code whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10Code whereId($value)
 * @mixin \Eloquent
 */
	class Icd10Code extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $name
 * @property int $inventory_category_id
 * @property int $inventory_unit_id
 * @property numeric $stock
 * @property numeric $cost_price
 * @property numeric $markup_amount
 * @property numeric $markup_percent
 * @property numeric $vat_percent
 * @property numeric $vat_amount
 * @property numeric $selling_price_vat_exclusive
 * @property numeric $selling_price_vat_inclusive
 * @property string|null $photo
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read InventoryCategory $category
 * @property-read User $createdBy
 * @property-read User|null $lastModifiedBy
 * @property-read InventoryUnit $unit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereMarkupAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereMarkupPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereInventoryCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereInventoryUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereSellingPriceVatExclusive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereSellingPriceVatInclusive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereVatAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereVatPercent($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InventoryAudit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InventoryStockMovement> $stockMovement
 * @property-read int|null $stock_movement_count
 */
	class Inventory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $inventory_id
 * @property int $audit_type_id
 * @property string $data
 * @property string $created_by
 * @property \Carbon\CarbonImmutable $created_at
 * @property-read \App\Models\AuditType $auditType
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\Inventory $inventory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryAudit whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryAudit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryAudit whereInventoryId($value)
 */
	class InventoryAudit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryCategory whereName($value)
 * @mixin \Eloquent
 */
	class InventoryCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $inventory_id
 * @property int $stock_movement_type_id
 * @property numeric $cost_price
 * @property numeric $current_stock
 * @property numeric $quantity
 * @property numeric $new_stock
 * @property numeric $total_price
 * @property string $lot_no
 * @property \Carbon\CarbonImmutable $manufacture_date
 * @property \Carbon\CarbonImmutable $expiry_date
 * @property string|null $supplier
 * @property string|null $reference_no
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\Inventory $inventory
 * @property-read \App\Models\User|null $lastModifiedBy
 * @property-read \App\Models\StockMovementType $stockMovementType
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereCurrentStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereInventoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereLotNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereManufactureDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereNewStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereReferenceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereStockMovementTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereSupplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereUpdatedAt($value)
 */
	class InventoryStockMovement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryUnit whereName($value)
 * @mixin \Eloquent
 */
	class InventoryUnit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $visit_id
 * @property string $patient_id
 * @property string|null $consultation_id
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Consultation|null $consultation
 * @property-read User $createdBy
 * @property-read User|null $lastModifiedBy
 * @property-read Patient|null $patient
 * @property-read Collection<int, LaboratoryTest> $tests
 * @property-read int|null $tests_count
 * @property-read Visit $visit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereVisitId($value)
 * @property bool $is_completed
 * @property-read Collection<int, \App\Models\LaboratoryTestData> $testData
 * @property-read int|null $test_data_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory wherePatientName($value)
 * @property-read Collection<int, \App\Models\LaboratoryTestFieldData> $testFieldData
 * @property-read int|null $test_field_data_count
 * @property string|null $patient_name
 * @mixin \Eloquent
 */
	class Laboratory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $laboratory_id
 * @property int $audit_type_id
 * @property string $data
 * @property string $created_by
 * @property \Carbon\CarbonImmutable $created_at
 * @property-read \App\Models\AuditType $auditType
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\Laboratory $laboratory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryAudit whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryAudit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryAudit whereLaboratoryId($value)
 * @mixin \Eloquent
 */
	class LaboratoryAudit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property numeric $price
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LaboratoryTest> $tests
 * @property-read int|null $tests_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackage wherePrice($value)
 * @mixin \Eloquent
 */
	class LaboratoryPackage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $laboratory_package_id
 * @property int $laboratory_test_id
 * @property-read \App\Models\LaboratoryPackage $package
 * @property-read \App\Models\LaboratoryTest $test
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackageTest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackageTest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackageTest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackageTest whereLaboratoryPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackageTest whereLaboratoryTestId($value)
 * @mixin \Eloquent
 */
	class LaboratoryPackageTest extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property numeric $price
 * @property int|null $laboratory_type_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LaboratoryTestField> $fields
 * @property-read int|null $fields_count
 * @property-read \App\Models\LaboratoryPackage|null $package
 * @property-read \App\Models\LaboratoryType|null $type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest whereLaboratoryTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest wherePrice($value)
 * @mixin \Eloquent
 */
	class LaboratoryTest extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $laboratory_id
 * @property int|null $laboratory_package_id
 * @property int $laboratory_type_id
 * @property int $laboratory_test_id
 * @property string|null $remarks
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LaboratoryTestFieldData> $fields
 * @property-read int|null $fields_count
 * @property-read \App\Models\Laboratory $laboratory
 * @property-read \App\Models\User|null $lastModifiedBy
 * @property-read \App\Models\LaboratoryPackage|null $package
 * @property-read \App\Models\LaboratoryTest $test
 * @property-read \App\Models\LaboratoryType $type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereLaboratoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereLaboratoryPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereLaboratoryTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereLaboratoryTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class LaboratoryTestData extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $laboratory_test_id
 * @property string $name
 * @property string|null $unit
 * @property string|null $field_type
 * @property numeric|null $normal_range_both_min
 * @property numeric|null $normal_range_both_max
 * @property numeric|null $normal_range_male_min
 * @property numeric|null $normal_range_male_max
 * @property numeric|null $normal_range_female_min
 * @property numeric|null $normal_range_female_max
 * @property int $sort_order
 * @property-read \App\Models\LaboratoryTest $laboratoryTest
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereFieldType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereLaboratoryTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereNormalRangeBothMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereNormalRangeBothMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereNormalRangeFemaleMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereNormalRangeFemaleMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereNormalRangeMaleMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereNormalRangeMaleMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereUnit($value)
 * @mixin \Eloquent
 */
	class LaboratoryTestField extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $laboratory_id
 * @property string $laboratory_test_data_id
 * @property int $laboratory_test_field_id
 * @property string|null $value
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\LaboratoryTestField $field
 * @property-read \App\Models\Laboratory $laboratory
 * @property-read \App\Models\User|null $lastModifiedBy
 * @property-read \App\Models\LaboratoryTestData $testData
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereLaboratoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereLaboratoryTestDataId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereLaboratoryTestFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereValue($value)
 * @mixin \Eloquent
 * @property int $order_no
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereOrderNo($value)
 */
	class LaboratoryTestFieldData extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryType whereName($value)
 * @mixin \Eloquent
 */
	class LaboratoryType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nationality newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nationality newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nationality query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nationality whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nationality whereName($value)
 * @mixin \Eloquent
 */
	class Nationality extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $last_name
 * @property string $first_name
 * @property string|null $middle_name
 * @property string|null $date_of_birth
 * @property string|null $age
 * @property string|null $contact_number1
 * @property string|null $contact_number2
 * @property string|null $email
 * @property string|null $occupation
 * @property string|null $philhealth_id
 * @property string|null $house_no
 * @property string|null $street
 * @property int|null $barangay_id
 * @property int|null $city_id
 * @property int|null $province_id
 * @property int|null $gender_id
 * @property int|null $civil_status_id
 * @property int|null $nationality_id
 * @property int $status_id
 * @property int|null $patient_suffix_id
 * @property string|null $photo
 * @property string|null $last_name_index
 * @property string|null $first_name_index
 * @property string|null $middle_name_index
 * @property int|null $batch
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, PatientAudit> $audits
 * @property-read int|null $audits_count
 * @property-read Barangay|null $barangay
 * @property-read City|null $city
 * @property-read CivilStatus|null $civilStatus
 * @property-read Collection<int, Consultation> $consultation
 * @property-read int|null $consultation_count
 * @property-read User $createdBy
 * @property-read Gender|null $gender
 * @property-read string $full_name
 * @property-read Collection<int, Laboratory> $laboratory
 * @property-read int|null $laboratory_count
 * @property-read User|null $lastModifiedBy
 * @property-read Nationality|null $nationality
 * @property-read Collection<int, PatientAudit> $patientAudit
 * @property-read int|null $patient_audit_count
 * @property-read Collection<int, PatientVitalSign> $patientVitalSigns
 * @property-read int|null $patient_vital_signs_count
 * @property-read Province|null $province
 * @property-read PatientStatus $status
 * @property-read PatientSuffix|null $suffix
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient orWhereBlind(string $column, string $indexName, array|string $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereBatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereBlind(string $column, string $indexName, array|string $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCivilStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereContactNumber1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereContactNumber2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereFirstNameIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereGenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereHouseNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereLastNameIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereMiddleNameIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereNationalityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePatientSuffixId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePhilhealthId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereUpdatedAt($value)
 * @property-read string|null $age_computed
 * @property-read string|null $full_address
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePriorityTypeId($value)
 * @property string|null $senior_citizen_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereSeniorCitizenId($value)
 * @property-read bool $is_senior
 * @mixin \Eloquent
 */
	class Patient extends \Eloquent implements \Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $patient_id
 * @property int $audit_type_id
 * @property array<array-key, mixed> $action
 * @property string $created_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read User $createdBy
 * @property-read Patient|null $patient
 * @property-read AuditType|null $type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class PatientAudit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStatus whereName($value)
 * @mixin \Eloquent
 */
	class PatientStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientSuffix newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientSuffix newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientSuffix query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientSuffix whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientSuffix whereName($value)
 * @mixin \Eloquent
 */
	class PatientSuffix extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $patient_id
 * @property string|null $consultation_id
 * @property int $vital_sign_id
 * @property int $vital_sign_field_id
 * @property numeric $value
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Consultation|null $consultation
 * @property-read User $createdBy
 * @property-read User|null $lastModifiedBy
 * @property-read Patient|null $patient
 * @property-read VitalSign $vitalSign
 * @property-read VitalSignField $vitalSignField
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereVitalSignFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereVitalSignId($value)
 * @mixin \Eloquent
 */
	class PatientVitalSign extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $receipt_sequence_header
 * @property int $receipt_sequence
 * @property string $patient_id
 * @property string $visit_id
 * @property string $cashier_id
 * @property int|null $payment_method_id
 * @property int $payment_status_id
 * @property string|null $reference_number
 * @property numeric|null $total_amount
 * @property numeric|null $amount_received
 * @property numeric|null $amount_paid
 * @property numeric|null $amount_change
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Cashier $cashier
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User|null $lastModifiedBy
 * @property-read \App\Models\PaymentMethod|null $method
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\PaymentStatus $status
 * @property-read \App\Models\Visit $visit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereAmountChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereAmountPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereAmountReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePaymentStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereReceiptSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereReceiptSequenceHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereVisitId($value)
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $payment_id
 * @property int $audit_type_id
 * @property string $data
 * @property string $created_by
 * @property \Carbon\CarbonImmutable $created_at
 * @property-read \App\Models\AuditType $auditType
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\Payment|null $payment
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentAudit whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentAudit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentAudit wherePaymentId($value)
 */
	class PaymentAudit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereName($value)
 */
	class PaymentMethod extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentStatus whereName($value)
 */
	class PaymentStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \App\Models\Consultation|null $consultation
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\User|null $lastModifiedBy
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\Visit|null $visit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy query()
 */
	class Pharmacy extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $pharmacy_id
 * @property int $audit_type_id
 * @property string $data
 * @property string $created_by
 * @property \Carbon\CarbonImmutable $created_at
 * @property-read \App\Models\AuditType $auditType
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\Pharmacy $pharmacy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyAudit whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyAudit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyAudit wherePharmacyId($value)
 */
	class PharmacyAudit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $pharmacy_id
 * @property string $prescription_id
 * @property string $prescription_quantity
 * @property string $pharmacy_quantity
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Consultation|null $consultation
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User|null $lastModifiedBy
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\Visit|null $visit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail wherePharmacyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail wherePharmacyQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail wherePrescriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail wherePrescriptionQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereUpdatedAt($value)
 */
	class PharmacyDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $pharmacy_id
 * @property string $prescription_id
 * @property string $prescription_quantity
 * @property string $pharmacy_quantity
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails wherePharmacyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails wherePharmacyQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails wherePrescriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails wherePrescriptionQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereUpdatedAt($value)
 */
	class PharmacyDetails extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\PositionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position whereName($value)
 * @mixin \Eloquent
 */
	class Position extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $consultation_id
 * @property string|null $inventory_id
 * @property string $inventory_name
 * @property string $quantity
 * @property string $dosage
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Consultation $consultation
 * @property-read User $createdBy
 * @property-read User|null $lastModifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereDosage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereInventoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereInventoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Prescription extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriorityType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriorityType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriorityType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriorityType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriorityType whereName($value)
 * @mixin \Eloquent
 */
	class PriorityType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $prefix
 * @property string|null $suffix
 * @property-read Collection<int, UserProfession> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profession query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profession whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profession wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profession whereSuffix($value)
 * @mixin \Eloquent
 */
	class Profession extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereName($value)
 * @mixin \Eloquent
 */
	class Province extends \Eloquent {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology query()
 * @property string $id
 * @property string $visit_id
 * @property string $patient_id
 * @property string $consultation_id
 * @property bool $is_completed
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology whereVisitId($value)
 * @mixin \Eloquent
 */
	class Radiology extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Relationship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Relationship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Relationship query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Relationship whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Relationship whereName($value)
 * @mixin \Eloquent
 */
	class Relationship extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SignsOrSymptom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SignsOrSymptom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SignsOrSymptom query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SignsOrSymptom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SignsOrSymptom whereName($value)
 * @mixin \Eloquent
 */
	class SignsOrSymptom extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $suffix
 * @property-read Collection<int, UserSpecialty> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialty query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialty whereSuffix($value)
 * @mixin \Eloquent
 */
	class Specialty extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovementType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovementType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovementType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovementType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovementType whereName($value)
 * @mixin \Eloquent
 */
	class StockMovementType extends \Eloquent {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction query()
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $last_name
 * @property string $first_name
 * @property string|null $middle_name
 * @property int|null $gender_id
 * @property string|null $date_of_birth
 * @property string|null $contact_number
 * @property string|null $email
 * @property string|null $house_no
 * @property string|null $street
 * @property int|null $barangay_id
 * @property int|null $city_id
 * @property int|null $province_id
 * @property string|null $license_no
 * @property string|null $ptr_no
 * @property string|null $date_hired
 * @property string|null $date_resigned
 * @property bool $status
 * @property string|null $remember_token
 * @property int $department_id
 * @property int $position_id
 * @property string|null $photo
 * @property string|null $last_name_index
 * @property string|null $first_name_index
 * @property string|null $middle_name_index
 * @property int|null $batch
 * @property string|null $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, UserAudit> $audits
 * @property-read int|null $audits_count
 * @property-read Barangay|null $barangay
 * @property-read City|null $city
 * @property-read User|null $createdBy
 * @property-read Department $department
 * @property-read Gender|null $gender
 * @property-read string $full_name
 * @property-read User|null $lastModifiedBy
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Position $position
 * @property-read Collection<int, UserProfession> $professions
 * @property-read int|null $professions_count
 * @property-read Province|null $province
 * @property-read Collection<int, UserSpecialty> $specialties
 * @property-read int|null $specialties_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User orWhereBlind(string $column, string $indexName, array|string $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBlind(string $column, string $indexName, array|string $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDateHired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDateResigned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstNameIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereHouseNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastNameIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLicenseNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereMiddleNameIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePtrNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 * @property string|null $username_index
 * @property-read string|null $age_computed
 * @property-read string|null $full_address
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsernameIndex($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent implements \Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property int $audit_type_id
 * @property array<array-key, mixed> $action
 * @property string $created_by
 * @property CarbonImmutable $created_at
 * @property-read User $createdBy
 * @property-read User|null $lastModifiedBy
 * @property-read AuditType|null $type
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit whereUserId($value)
 * @mixin \Eloquent
 */
	class UserAudit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property int $profession_id
 * @property-read Profession $profession
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfession query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfession whereProfessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfession whereUserId($value)
 * @mixin \Eloquent
 */
	class UserProfession extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $user_id
 * @property int $specialty_id
 * @property-read Specialty $specialty
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialty query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialty whereSpecialtyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialty whereUserId($value)
 * @mixin \Eloquent
 */
	class UserSpecialty extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $patient_id
 * @property bool $has_consultation
 * @property bool $has_laboratory
 * @property bool $has_radiology
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Consultation|null $consultation
 * @property-read User|null $createdBy
 * @property-read User|null $lastModifiedBy
 * @property-read Patient|null $patient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereHasConsultation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereHasLaboratory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereHasRadiology($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereUpdatedAt($value)
 * @property bool $consultation_completed
 * @property bool $lab_completed
 * @property bool $radiology_completed
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereConsultationCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereLabCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereRadiologyCompleted($value)
 * @property string|null $admitted_at
 * @property string|null $discharged_at
 * @property bool $is_emergency
 * @property int $visit_status_id
 * @property-read \App\Models\VisitStatus $visitStatus
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereAdmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereDischargedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereIsEmergency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit wherePriorityTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereVisitStatusId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PriorityType> $priorityTypes
 * @property-read int|null $priority_types_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Laboratory> $laboratory
 * @property-read int|null $laboratory_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Radiology> $radiology
 * @property-read int|null $radiology_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Billing> $billing
 * @property-read int|null $billing_count
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cashier> $cashier
 * @property-read int|null $cashier_count
 */
	class Visit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $visit_id
 * @property int $priority_type_id
 * @property-read \App\Models\PriorityType $priorityType
 * @property-read \App\Models\Visit $visit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitPriorityType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitPriorityType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitPriorityType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitPriorityType wherePriorityTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitPriorityType whereVisitId($value)
 * @mixin \Eloquent
 */
	class VisitPriorityType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitStatus whereName($value)
 * @mixin \Eloquent
 */
	class VisitStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property-read Collection<int, VitalSignField> $fields
 * @property-read int|null $fields_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSign query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSign whereName($value)
 * @mixin \Eloquent
 */
	class VitalSign extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $unit
 * @property int $vital_sign_id
 * @property-read VitalSign $vitalSign
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSignField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSignField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSignField query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSignField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSignField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSignField whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSignField whereVitalSignId($value)
 * @mixin \Eloquent
 */
	class VitalSignField extends \Eloquent {}
}

