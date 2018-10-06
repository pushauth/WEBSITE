<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

/**
 * PushAuth\DhExchange
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $device_id
 * @property string $hash
 * @property string|null $val_g
 * @property string|null $val_p
 * @property string|null $val_ak
 * @property string|null $val_bk
 * @property string|null $val_a
 * @property string|null $val_b
 * @property-read \PushAuth\UserDevices $device
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\DhExchange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\DhExchange whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\DhExchange whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\DhExchange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\DhExchange whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\DhExchange whereValA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\DhExchange whereValAk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\DhExchange whereValB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\DhExchange whereValBk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\DhExchange whereValG($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\DhExchange whereValP($value)
 * @mixin \Eloquent
 */
class DhExchange extends Model
{
    //
    protected $table = 'dh_exchanges';

    protected $fillable = [
'device_id',
'hash',
'val_g',
'val_p',
'val_ak',
'val_bk',
'val_a',
'val_b',
];

    public function device()
    {
        return $this->hasOne('PushAuth\UserDevices', 'id', 'device_id');
    }
}
