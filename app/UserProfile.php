<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

/**
 * PushAuth\UserProfile
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $user_id
 * @property string|null $user_img
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $company
 * @property string|null $tel
 * @property string|null $website
 * @property-read \PushAuth\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserProfile whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserProfile whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserProfile whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserProfile whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserProfile whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserProfile whereUserImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\UserProfile whereWebsite($value)
 * @mixin \Eloquent
 */
class UserProfile extends Model
{
    //
    protected $table= 'user_profile';

    protected $fillable = [

'user_id',
'user_img',
'first_name',
'last_name',
'company',
'tel',
'website',

    ];

    public function user()
    {
        return $this->hasOne('PushAuth\User', 'id', 'user_id');
    }


}
