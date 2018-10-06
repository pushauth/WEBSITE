<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

/**
 * PushAuth\UserDeviceConfirm
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int|null $user_id
 * @property string $os
 * @property string $uuid
 * @property string $token
 * @property string $status
 * @property string $urlhash
 * @property string|null $confirm_dt
 * @property string $with_user
 * @property string|null $email
 * @property-read \PushAuth\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDeviceConfirm whereConfirmDt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDeviceConfirm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDeviceConfirm whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDeviceConfirm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDeviceConfirm whereOs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDeviceConfirm whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDeviceConfirm whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDeviceConfirm whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDeviceConfirm whereUrlhash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDeviceConfirm whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDeviceConfirm whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserDeviceConfirm whereWithUser($value)
 * @mixin \Eloquent
 */
class UserDeviceConfirm extends Model
{
    //
    protected $table = 'user_device_confirm';

    protected $fillable = [
'user_id',
'os',
'uuid',
'token',
'status',
'urlhash',
'confirm_dt',
'with_user',
'email',
        'name',

        'vendor',

        'os_detail',
    ];

    public function user()
    {
        return $this->hasOne('PushAuth\User', 'id', 'user_id');
    }
}
