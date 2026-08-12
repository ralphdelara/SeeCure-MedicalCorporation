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
 * @property int $id
 * @property int $patient_id
 * @property string|null $guardian_name
 * @property string|null $guardian_contact_number
 * @property string|null $guardian_email
 * @property int $status_id
 * @property int $doctor_id
 * @property int $created_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read User|null $createdBy
 * @property-read User $doctor
 * @property-read Patient $patient
 * @property-read Collection<int, PatientVitalSign> $patientVitalSign
 * @property-read int|null $patient_vital_sign_count
 * @property-read Collection<int, ConsultationSignsOrSymptom> $signsOrSymptoms
 * @property-read int|null $signs_or_symptoms_count
 * @property-read ConsultationStatus $status
 * @property-read Collection<int, ConsultationDetailType> $types
 * @property-read int|null $types_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereGuardianContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereGuardianEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereGuardianName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $guardian_relationship_id
 * @property int|null $last_modified_by
 * @property-read \App\Models\Relationship|null $guardianRelationship
 * @property-read \App\Models\User|null $lastModifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereGuardianRelationshipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereLastModifiedBy($value)
 */
	class Consultation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $consultation_id
 * @property string|null $subjective
 * @property string|null $assessment
 * @property string|null $plan
 * @property string|null $diagnosis
 * @property int $created_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetail whereAssessment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetail whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetail whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetail whereDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetail wherePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetail whereSubjective($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $last_modified_by
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetail whereLastModifiedBy($value)
 */
	class ConsultationDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $consultation_id
 * @property int $type_id
 * @property-read Consultation $consultation
 * @property-read ConsultationType $type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetailType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetailType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetailType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetailType whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetailType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetailType whereTypeId($value)
 * @mixin \Eloquent
 */
	class ConsultationDetailType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $consultation_id
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
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationStatus whereName($value)
 * @mixin \Eloquent
 */
	class ConsultationStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property-read Collection<int, Consultation> $consultations
 * @property-read int|null $consultations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationType whereName($value)
 * @mixin \Eloquent
 */
	class ConsultationType extends \Eloquent {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType query()
 * @mixin \Eloquent
 */
	class ContactType extends \Eloquent {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Controller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Controller newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Controller query()
 * @mixin \Eloquent
 */
	class Controller extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property-read Collection<int, UserDepartment> $users
 * @property-read int|null $users_count
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
 */
	class DiscountType extends \Eloquent {}
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
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string|null $middle_name
 * @property Carbon|null $date_of_birth
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
 * @property int $created_by
 * @property string|null $photo
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, PatientAudit> $audits
 * @property-read int|null $audits_count
 * @property-read Barangay|null $barangay
 * @property-read City|null $city
 * @property-read CivilStatus|null $civilStatus
 * @property-read User|null $createdBy
 * @property-read Gender|null $gender
 * @property-read Collection<int, PatientGuardian> $guardian
 * @property-read int|null $guardian_count
 * @property-read Nationality|null $nationality
 * @property-read Collection<int, PatientVitalSign> $patientVitalSigns
 * @property-read int|null $patient_vital_signs_count
 * @property-read Province|null $province
 * @property-read PatientStatus $status
 * @property-read PatientSuffix|null $suffix
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCivilStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereContactNumber1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereContactNumber2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereGenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereHouseNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereNationalityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePatientSuffixId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePhilhealthId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $last_modified_by
 * @property-read string $full_name
 * @property-read \App\Models\User|null $lastModifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereLastModifiedBy($value)
 */
	class Patient extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $patient_id
 * @property int $audit_type_id
 * @property array<array-key, mixed> $action
 * @property int $created_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read User|null $createdBy
 * @property-read Patient $patient
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
 * @property int $patient_id
 * @property string $name
 * @property string|null $contact_number
 * @property string|null $email
 * @property int $relationship_id
 * @property int $created_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read User|null $createdBy
 * @property-read Patient $patient
 * @property-read Relationship $relationship
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian whereRelationshipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $last_modified_by
 * @property-read \App\Models\User|null $lastModifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian whereLastModifiedBy($value)
 */
	class PatientGuardian extends \Eloquent {}
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
 * @property int $id
 * @property int $patient_id
 * @property int|null $consultation_id
 * @property int $vital_sign_id
 * @property int $vital_sign_field_id
 * @property numeric $value
 * @property int $created_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Consultation|null $consultation
 * @property-read User|null $createdBy
 * @property-read Patient $patient
 * @property-read VitalSign $vitalSign
 * @property-read VitalSignField $vitalSignField
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereVitalSignFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereVitalSignId($value)
 * @mixin \Eloquent
 * @property int|null $last_modified_by
 * @property-read \App\Models\User|null $lastModifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereLastModifiedBy($value)
 */
	class PatientVitalSign extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position whereName($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\PositionFactory factory($count = null, $state = [])
 */
	class Position extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $product_category_id
 * @property int $product_unit_id
 * @property numeric $stock
 * @property numeric $cost_price
 * @property numeric $markup_amount
 * @property numeric $markup_percent
 * @property numeric $vat_percent
 * @property numeric $vat_amount
 * @property numeric $selling_price_vat_exclusive
 * @property numeric $selling_price_vat_inclusive
 * @property string|null $photo
 * @property int $created_by
 * @property int|null $last_modified_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\ProductCategory $category
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User|null $lastModifiedBy
 * @property-read \App\Models\ProductUnit $unit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMarkupAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMarkupPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSellingPriceVatExclusive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSellingPriceVatInclusive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereVatAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereVatPercent($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereName($value)
 */
	class ProductCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit whereName($value)
 */
	class ProductUnit extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @mixin \Eloquent
 */
	class Role extends \Eloquent {}
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
 */
	class StockMovementType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionType whereName($value)
 */
	class TransactionType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property Carbon|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $username
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string|null $full_name_index
 * @property int|null $gender_id
 * @property \Carbon\Carbon|null $date_of_birth
 * @property string|null $contact_number
 * @property string|null $house_no
 * @property string|null $street
 * @property int|null $barangay_id
 * @property int|null $city_id
 * @property int|null $province_id
 * @property string|null $license_no
 * @property string|null $ptr_no
 * @property \Carbon\Carbon|null $date_hired
 * @property \Carbon\Carbon|null $date_resigned
 * @property bool $status
 * @property int $position_id
 * @property int $created_by
 * @property string|null $photo
 * @property-read Collection<int, UserAudit> $audits
 * @property-read int|null $audits_count
 * @property-read Barangay|null $barangay
 * @property-read City|null $city
 * @property-read User|null $createdBy
 * @property-read Collection<int, UserDepartment> $departments
 * @property-read int|null $departments_count
 * @property-read Gender|null $gender
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Position $position
 * @property-read Collection<int, UserProfession> $professions
 * @property-read int|null $professions_count
 * @property-read Province|null $province
 * @property-read Collection<int, UserRole> $role
 * @property-read int|null $role_count
 * @property-read Collection<int, UserSpecialty> $specialties
 * @property-read int|null $specialties_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDateHired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDateResigned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFullNameIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereHouseNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLicenseNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereMiddleName($value)
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
 * @mixin \Eloquent
 * @property int|null $last_modified_by
 * @property-read string $full_name
 * @property-read User|null $lastModifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastModifiedBy($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $audit_type_id
 * @property array<array-key, mixed> $action
 * @property int $created_by
 * @property CarbonImmutable $created_at
 * @property-read User|null $createdBy
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
 * @property-read \App\Models\User|null $lastModifiedBy
 */
	class UserAudit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $department_id
 * @property-read Department $department
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDepartment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDepartment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDepartment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDepartment whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDepartment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDepartment whereUserId($value)
 * @mixin \Eloquent
 */
	class UserDepartment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
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
 * @property int $id
 * @property int $user_id
 * @property int $role_id
 * @property-read Role $role
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereUserId($value)
 * @mixin \Eloquent
 */
	class UserRole extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit query()
 */
	class Visit extends \Eloquent {}
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

