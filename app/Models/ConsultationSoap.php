<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;

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
 *
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
 *
 * @mixin \Eloquent
 */
class ConsultationSoap extends Model
{
    //
}
