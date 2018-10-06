<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

/**
 * PushAuth\UserEmailConfirmation
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $user_id
 * @property string $email
 * @property string $status
 * @property string $urlhash
 * @property string|null $confirm_dt
 * @property-read \PushAuth\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserEmailConfirmation whereConfirmDt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserEmailConfirmation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserEmailConfirmation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserEmailConfirmation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserEmailConfirmation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserEmailConfirmation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserEmailConfirmation whereUrlhash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserEmailConfirmation whereUserId($value)
 * @mixin \Eloquent
 */
class UserEmailConfirmation extends Model
{
    //
    protected $table = 'user_email_confirm';

    protected $fillable = [
'user_id',
'email',
'status',
'urlhash',
'confirm_dt',
    ];

    public function user()
    {
        return $this->hasOne('PushAuth\User', 'id', 'user_id');
    }

}
