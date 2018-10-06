<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

/**
 * PushAuth\PricePlan
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\PushAuth\PlanLimits[] $limits
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PricePlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PricePlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PricePlan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PricePlan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PricePlan extends Model
{
    //
    protected $table = 'price_plan';

    protected $fillable = ['name'];


    public function limits()
    {
        return $this->hasMany('PushAuth\PlanLimits', 'plan_id', 'id');
    }


}
