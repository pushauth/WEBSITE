<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

class TicketThread extends Model
{
    //
    protected $table = 'ticket_thread';

    protected $fillable = [

'ticket_id',
'author_id',
'text',
'url_hash',

    ];

    protected $morphClass = 'ticket_thread';

    public function author()
    {
        return $this->hasOne('PushAuth\User', 'id', 'author_id');
    }
    public function ticket()
    {
        return $this->hasOne('PushAuth\Ticket', 'id', 'ticket_id');
    }
    public function files()
    {
        return $this->morphMany('PushAuth\Files', 'target');
    }

}
