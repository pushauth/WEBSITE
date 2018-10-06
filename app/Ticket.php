<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    protected $table='tickets';
    protected  $fillable= [


'author_id',
'status',
'subject',
'text',
'type',
'app_id',
'error_msg',
'issue_dt',
'url_hash',


    ];

    protected $morphClass = 'ticket';


    public function client()
    {
        return $this->hasOne('PushAuth\User', 'id', 'author_id');
    }
    public function threads()
    {
        return $this->hasMany('PushAuth\TicketThread', 'ticket_id', 'id');
    }

    public function app()
    {
        return $this->hasOne('PushAuth\UserApp', 'id', 'app_id');
    }
    public function files()
    {
        return $this->morphMany('PushAuth\Files', 'target');
    }

}
