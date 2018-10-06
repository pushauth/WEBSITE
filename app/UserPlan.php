<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

/**
 * PushAuth\UserPlan
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $plan_id
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\PushAuth\PlanLimits[] $limits
 * @property-read \PushAuth\PricePlan $plan
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserPlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserPlan wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserPlan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserPlan whereUserId($value)
 * @mixin \Eloquent
 */
class UserPlan extends Model
{
    //
    protected $table = 'user_plan';

    protected $fillable = [

'plan_id',
'user_id',

    ];

    public function limits()
    {
        return $this->hasMany('PushAuth\PlanLimits', 'plan_id', 'plan_id');
    }


    public function plan()
    {
        return $this->hasOne('PushAuth\PricePlan', 'id', 'plan_id');
    }


}
