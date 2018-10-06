<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

/**
 * PushAuth\UserDevices
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $user_id
 * @property string $os
 * @property string $uuid
 * @property string $token
 * @property string|null $public_key
 * @property string|null $private_key
 * @property string $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\PushAuth\PushRequest[] $pushes
 * @property-read \PushAuth\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDevices whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDevices whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDevices whereOs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDevices wherePrivateKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDevices wherePublicKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDevices whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDevices whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDevices whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDevices whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDevices whereUuid($value)
 * @mixin \Eloquent
 */
class UserDevices extends Model
{
    //
    protected $table = 'user_devices';

    protected $fillable = [
        'user_id',
        'os',
        'uuid',
        'token',
        //'name',
        //'platform',
        'public_key',
        'private_key',
        'status',

        'name',

        'vendor',

        'os_detail',


    ];

    public function user()
    {
        return $this->hasOne('PushAuth\User', 'id', 'user_id');
    }

    public function pushes()
    {
        return $this->hasMany('PushAuth\PushRequest', 'device_id', 'id');
    }

    public function routes()
    {
        return $this->hasMany('PushAuth\PushRoutes', 'device_id', 'id');
    }

}
