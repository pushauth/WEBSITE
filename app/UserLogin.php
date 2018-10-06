<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

/**
 * PushAuth\UserLogin
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $user_id
 * @property string $ip
 * @property string $user_agent
 * @property string|null $login_dt
 * @property-read \PushAuth\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserLogin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserLogin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserLogin whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserLogin whereLoginDt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserLogin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserLogin whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserLogin whereUserId($value)
 * @mixin \Eloquent
 */
class UserLogin extends Model
{
    //
    protected $table = 'user_login';

    protected $fillable = [


'user_id',
'ip',
'user_agent',
'login_dt',

    ];

    public function user()
    {
        return $this->hasOne('PushAuth\User', 'id', 'user_id');
    }

}
