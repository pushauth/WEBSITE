<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

/**
 * PushAuth\UserConfirm
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $email
 * @property string $pass
 * @property string $name
 * @property string $status
 * @property string $urlhash
 * @property string|null $confirm_dt
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserConfirm whereConfirmDt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserConfirm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserConfirm whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserConfirm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserConfirm whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserConfirm wherePass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserConfirm whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserConfirm whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserConfirm whereUrlhash($value)
 * @mixin \Eloquent
 */
class UserConfirm extends Model
{
    //
    protected $table = 'user_confirm';
    protected $fillable = [

'email',
'pass',
'name',
'status',
'urlhash',
'confirm_dt',


    ];
}
