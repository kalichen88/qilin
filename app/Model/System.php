<?php
declare(strict_types=1);

namespace App\Model;

class System extends Model
{
    protected ?string $table = 'system';

    protected array $fillable = [
        'siteTitle', 'siteName', 'siteInfo', 'siteLogo', 'siteBg', 'bindDomain',
        'wechatOpenidSwitch', 'wechatUrl', 'min_price', 'max_price', 'global_txfl', 'global_fyfl',
        'codePrice', 'domainPrice', 'min_tx', 'max_tx', 'day_max_tx', 'ak', 'global_ak',
        'global_short', 'appid', 'secret', 'wechatJumpUrl', 'global_pay',
        'switch_1', 'switch_3', 'switch_4', 'switch_9', 'switch_10', 'switch_11',
        'switch_pc', 'ffSwitch',
    ];

}
