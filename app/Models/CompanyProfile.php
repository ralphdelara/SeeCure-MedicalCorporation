<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $company_name
 * @property string|null $company_reg_no
 * @property string|null $bir_no
 * @property string|null $tel_no
 * @property string|null $phone_no
 * @property string|null $email
 * @property string|null $clinic_hours
 * @property string|null $address
 * @property string|null $landmark
 * @property string $last_modified_by
 * @property string $updated_at
 * @property-read User $lastModifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile whereBirNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile whereClinicHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile whereCompanyRegNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile whereLandmark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile wherePhoneNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile whereTelNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile whereUpdatedAt($value)
 * @property string|null $non_vat_tin
 * @property string|null $min
 * @property string|null $sn
 * @property string|null $accreditation_no
 * @property string|null $accreditation_date_issued
 * @property string|null $ptu_no
 * @property string|null $ptu_date_issued
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile whereAccreditationDateIssued($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile whereAccreditationNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile whereMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile whereNonVatTin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile wherePtuDateIssued($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile wherePtuNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyProfile whereSn($value)
 * @mixin \Eloquent
 */
#[Table('company_profile', key: 'id', keyType: 'int', incrementing: false)]
#[Fillable([
    'company_name',
    'company_reg_no',
    'non_vat_tin',
    'min',
    'sn',
    'accreditation_no',
    'accreditation_date_issued',
    'ptu_no',
    'ptu_date_issued',
    'bir_no',
    'tel_no',
    'phone_no',
    'email',
    'clinic_hours',
    'address',
    'landmark',
    'last_modified_by',
])]
class CompanyProfile extends Model
{
    public $timestamps = false;

    /**
     * Get the user who last modified the company profile.
     */
    public function lastModifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_modified_by', 'id');
    }
}
