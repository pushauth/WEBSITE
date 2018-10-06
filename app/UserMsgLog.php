<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

/**
 * PushAuth\UserMsgLog
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $user_id
 * @property string|null $msg_pushlimit_dt
 * @property string|null $msg_devicelimit_dt
 * @property string|null $msg_userlimit_dt
 * @property-read \PushAuth\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserMsgLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserMsgLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserMsgLog whereMsgDevicelimitDt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserMsgLog whereMsgPushlimitDt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserMsgLog whereMsgUserlimitDt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserMsgLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserMsgLog whereUserId($value)
 * @mixin \Eloquent
 */
class UserMsgLog extends Model
{
    //
    protected $table='user_msg_log';
    protected $fillable = [

'user_id',
'msg_pushlimit_dt',
'msg_devicelimit_dt',
'msg_userlimit_dt',

    ];

    public function user()
    {
        return $this->hasOne('PushAuth\User', 'id', 'user_id');
    }


}
