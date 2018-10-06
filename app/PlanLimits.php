<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

/**
 * PushAuth\PlanLimits
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $plan_id
 * @property string $key
 * @property string $value
 * @property string $period
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PlanLimits whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PlanLimits whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PlanLimits whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PlanLimits wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PlanLimits wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PlanLimits whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PlanLimits whereValue($value)
 * @mixin \Eloquent
 */
class PlanLimits extends Model
{
    //
    protected $table = 'plan_limit';
    protected $fillable = [

'plan_id',
'key',
'value',
'period',

    ];


}
