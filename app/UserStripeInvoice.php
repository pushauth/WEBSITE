<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

class UserStripeInvoice extends Model
{
    //
    protected $table='user_stripe_invoice';
    protected $fillable = [

'user_id',
'invoice_id',
'currency',
'amount',
'paid',
'period_start',
'period_end'

    ];

    public function user()
    {
        return $this->hasOne('PushAuth\User', 'id', 'user_id');
    }


}
