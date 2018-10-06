<?php

namespace PushAuth;

use Illuminate\Database\Eloquent\Model;

/**
 * PushAuth\AppHook
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $app_id
 * @property string $hash
 * @property string|null $payload_url
 * @property string $type
 * @property string $qr_flag
 * @property string $push_flag
 * @property string $timeout_flag
 * @property string $status
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\AppHook whereAppId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\AppHook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\AppHook whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\AppHook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\AppHook wherePayloadUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\AppHook wherePushFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\AppHook whereQrFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\AppHook whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\AppHook whereTimeoutFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\AppHook whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\PushAuth\AppHook whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AppHook extends Model
{
    //
    protected $table = 'app_hook';
    protected $fillable = [

'app_id',
'hash',
'payload_url',
'type',
'qr_flag',
'push_flag',
'timeout_flag',
'status',

    ];
}
