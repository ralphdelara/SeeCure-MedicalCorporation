<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;

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
 *
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
 *
 * @mixin \Eloquent
 */
class ConsultationDetail extends Model
{
    //
}
