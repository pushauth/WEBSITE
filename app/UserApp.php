<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

/**
 * PushAuth\UserApp
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $user_id
 * @property string $public_key
 * @property string $private_key
 * @property string $plan
 * @property string $status
 * @property string $urlhash
 * @property string|null $name
 * @property string|null $about
 * @property string|null $url
 * @property string|null $ip_mask
 * @property string|null $img
 * @property-read \PushAuth\AppHook $hook
 * @property-read \Illuminate\Database\Eloquent\Collection|\PushAuth\PushRequest[] $pushRequests
 * @property-read \PushAuth\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserApp whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserApp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserApp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserApp whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserApp whereIpMask($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserApp whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserApp wherePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserApp wherePrivateKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserApp wherePublicKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserApp whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserApp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserApp whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserApp whereUrlhash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserApp whereUserId($value)
 * @mixin \Eloquent
 */
class UserApp extends Model
{
    //
    protected $table = 'user_app';

    protected $fillable = [

'user_id',
'public_key',
'private_key',
'plan',
'status',
'urlhash',
'name',
'about',
'url',
'ip_mask',
'img'


    ];

    public function user()
    {
        return $this->hasOne('PushAuth\User', 'id', 'user_id');
    }

    public function pushRequests()
    {
        return $this->hasMany('PushAuth\PushRequest', 'app_id', 'id');
    }
    public function hook()
    {
        return $this->hasOne('PushAuth\AppHook', 'app_id', 'id');
    }

}
