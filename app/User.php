<?php

namespace PushAuth;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;

/**
 * PushAuth\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $status
 * @property string $confirmed
 * @property int $stripe_active
 * @property string|null $stripe_id
 * @property string|null $stripe_subscription
 * @property string|null $stripe_plan
 * @property string|null $last_four
 * @property \Carbon\Carbon|null $trial_ends_at
 * @property \Carbon\Carbon|null $subscription_ends_at
 * @property int $plan_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\PushAuth\UserApp[] $app
 * @property-read \Illuminate\Database\Eloquent\Collection|\PushAuth\UserDevices[] $devices
 * @property-read \Illuminate\Database\Eloquent\Collection|\PushAuth\UserLogin[] $logins
 * @property-read \PushAuth\UserMsgLog $msgLogLast
 * @property-read \Illuminate\Database\Eloquent\Collection|\PushAuth\UserNotification[] $notifications
 * @property-read \PushAuth\UserPlan $plan
 * @property-read \PushAuth\UserProfile $profile
 * @property-read \PushAuth\UserRole $role
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\User whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\User whereLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\User wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\User whereStripeActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\User whereStripePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\User whereStripeSubscription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\User whereSubscriptionEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\User whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    BillableContract
{
    use Authenticatable, Authorizable, CanResetPassword, Billable;

    protected $dates = ['trial_ends_at', 'subscription_ends_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password','status','confirmed'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function getIsAdminAttribute()
    {
        return true;
    }

    public function devices()
    {
        return $this->hasMany('PushAuth\UserDevices', 'user_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany('PushAuth\UserNotification', 'user_id', 'id');
    }

    public function notificationsFlagRead($flag)
    {
        return $this->hasMany('PushAuth\UserNotification', 'user_id', 'id')->readed($flag);
    }

    public function tickets()
    {
        return $this->hasMany('PushAuth\Ticket', 'author_id', 'id');
    }

    public function app()
    {
        return $this->hasMany('PushAuth\UserApp', 'user_id', 'id');
    }
    public function logins()
    {
        return $this->hasMany('PushAuth\UserLogin', 'user_id', 'id');
    }
    public function profile()
    {
        return $this->hasOne('PushAuth\UserProfile', 'user_id', 'id');
    }
    public function stripe()
    {
        return $this->hasOne('PushAuth\UserStripe', 'user_id', 'id');
    }
    public function stripeCards()
    {
        return $this->hasMAny('PushAuth\UserStripeCards', 'user_id', 'id');
    }
    public function stripeInvoice()
    {
        return $this->hasMany('PushAuth\UserStripeInvoice', 'user_id', 'id');
    }

    public function role()
    {
        return $this->hasOne('PushAuth\UserRole', 'user_id', 'id');
    }

    public function plan()
    {
        return $this->hasOne('PushAuth\UserPlan', 'user_id', 'id');
    }

    public function msgLogLast()
    {
        return $this->hasOne('PushAuth\UserMsgLog', 'user_id', 'id');
    }

/*    public function plan() // those who follow me

    {
        //$this->belongsToMany('App\Role', 'user_roles', 'user_id', 'role_id');
        return $this->hasOne('PushAuth\PricePlan', 'user_plan', 'user_id', 'plan_id');
    }*/

}
