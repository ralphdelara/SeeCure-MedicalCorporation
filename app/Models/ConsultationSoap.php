<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
#[Fillable([
    'consultation_id',
    'subjective',
    'assessment',
    'plan',
    'created_by',
    'last_modified_by',
])]
class ConsultationSoap extends Model
{
    use CorrectTimezone, HasUuids;

    protected function casts(): array
    {
        return [
            'subjective' => 'encrypted',
            'assessment' => 'encrypted',
            'plan'       => 'encrypted',
            'created_at' => 'date:M d, Y h:i a',
            'updated_at' => 'date:M d, Y h:i a',
        ];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function lastModifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_modified_by', 'id');
    }
}
