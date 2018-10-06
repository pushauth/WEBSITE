<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

class UserStripe extends Model
{


    //
    protected $table = 'user_stripe';
    protected $fillable = [

'user_id',
'status',
'customer_id',
'subscription_id',
'plan_id',
'current_period_end',
'error_status'

    ];


    public function user()
    {
        return $this->hasOne('PushAuth\User', 'id', 'user_id');
    }
    public function cards()
    {
        return $this->hasMany('PushAuth\UserStripeCards', 'user_id', 'user_id');
    }
    public function invoices()
    {
        return $this->hasMany('PushAuth\UserStripeInvoice', 'user_id', 'user_id');
    }
}
