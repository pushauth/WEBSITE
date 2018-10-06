<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

class UserStripeCards extends Model
{
    //
    protected $table = 'user_stripe_cards';

    protected $fillable = [

'user_id',
'card_id',
'last4',
'exp_month',
'exp_year',
'brand',
'hash',
'default',
'attempt_dt'

    ];

    public function user()
    {
        return $this->hasOne('PushAuth\User', 'id', 'user_id');
    }
}
