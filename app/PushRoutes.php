<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

/**
 * PushAuth\PushRoutes
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $req_id
 * @property int $device_id
 * @property int $client_id
 * @property int $order
 * @property string $status
 * @property string|null $answer
 * @property string|null $sended_dt
 * @property string|null $answer_dt
 * @property-read \PushAuth\User $client
 * @property-read \PushAuth\UserDevices $device
 * @property-read \PushAuth\PushRequest $pushRequest
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRoutes whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRoutes whereAnswerDt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRoutes whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRoutes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRoutes whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRoutes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRoutes whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRoutes whereReqId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRoutes whereSendedDt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRoutes whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRoutes whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PushRoutes extends Model
{
    //
    protected $table = 'routes';

    protected $fillable = [


'req_id',
'device_id',
'client_id',
'order',
'status',
'answer',
'sended_dt',
'answer_dt',

'response_dt',
'response_code',

    ];

    public function client()
    {
        return $this->hasOne('PushAuth\User', 'id', 'client_id');
    }

    public function device()
    {
        return $this->hasOne('PushAuth\UserDevices', 'id', 'device_id');
    }

    public function pushRequest()
    {
        return $this->hasOne('PushAuth\PushRequest', 'id', 'req_id');
    }


}
