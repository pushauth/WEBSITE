<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

/**
 * PushAuth\UserRole
 *
 * @property int $id
 * @property int $user_id
 * @property string $role
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \PushAuth\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserRole whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserRole whereUserId($value)
 * @mixin \Eloquent
 */
class UserRole extends Model
{
    //
    protected $table = 'user_roles';
    protected $fillable = [

'user_id',
'role',

    ];

    public function user()
    {
        return $this->hasOne('PushAuth\User', 'id', 'user_id');
    }


}
