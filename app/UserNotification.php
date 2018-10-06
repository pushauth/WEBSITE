<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

/**
 * PushAuth\UserNotification
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $user_id
 * @property string $subject
 * @property string $body
 * @property string $is_read
 * @property string $urlhash
 * @property string|null $read_dt
 * @property-read \PushAuth\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserNotification readed($flag)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserNotification whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserNotification whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserNotification whereReadDt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserNotification whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserNotification whereUrlhash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserNotification whereUserId($value)
 * @mixin \Eloquent
 */
class UserNotification extends Model
{
    //
    protected $table = 'user_notification';
    protected $fillable = [


'user_id',
'subject',
'body',
'is_read',
'urlhash',
'read_dt',

    ];

    public function user()
    {
        return $this->hasOne('PushAuth\User', 'id', 'user_id');
    }
    public function scopeReaded($query, $flag)
    {
        return $query->where('is_read', $flag);
    }

}
