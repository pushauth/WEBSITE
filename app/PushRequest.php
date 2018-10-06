<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

/**
 * PushAuth\PushRequest
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $app_id
 * @property int|null $device_id
 * @property string $hash
 * @property string $mode
 * @property string|null $answer
 * @property string|null $response_dt
 * @property int|null $response_code
 * @property string|null $response_message
 * @property string|null $code
 * @property string $test
 * @property string|null $uniq_request_id
 * @property-read \PushAuth\UserApp $app
 * @property-read \PushAuth\UserDevices $device
 * @property-read \Illuminate\Database\Eloquent\Collection|\PushAuth\PushRoutes[] $routes
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRequest whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRequest whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRequest whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRequest whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRequest whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRequest whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRequest whereResponseCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRequest whereResponseDt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRequest whereResponseMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRequest whereTest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRequest whereUniqRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\PushRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PushRequest extends Model
{
    //
    protected $table = 'push_requests';

    protected $fillable = [

'app_id',
'device_id',
'hash',
'mode',
'answer',
'response_dt',
'response_code',
'response_message',
'code',
'test',
'uniq_request_id'


    ];

    public function device()
    {
        return $this->hasOne('PushAuth\UserDevices', 'id', 'device_id');
    }

    public function app()
    {
        return $this->hasOne('PushAuth\UserApp', 'id', 'app_id');
    }

    public function routes()
    {
        return $this->hasMany('PushAuth\PushRoutes', 'req_id', 'id');
    }

}
