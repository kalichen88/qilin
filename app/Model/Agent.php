<?php
declare(strict_types=1);

namespace App\Model;

class Agent extends Model
{
    protected ?string $table = 'agent';

    protected array $fillable = [
        'user', 'password', 'name', 'group', 'parent', 'money', 'txfl', 'fyfl', 'ff', 'hash',
        'pay', 'short', 'avatar', 'wechat', 'qq', 'tx_password',
        'video_day_switch', 'video_day_price', 'video_week_switch', 'video_week_price',
        'video_mouth_switch', 'video_mouth_price', 'priceType', 'priceOnce', 'priceMin', 'priceMax',
    ];
}
