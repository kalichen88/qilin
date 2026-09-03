<?php declare(strict_types=1);
namespace App\Model;
class Order extends Model {
    protected ?string $table = 'order';
    protected array $fillable = ['orderId','video','status','agentPrice','extraMoney','type','price','agent','link','startTime','expiredTime','ip','payType','isKl','raisePrice','openid','fingerprint','useTemplate','usePayTemplate','payModel','parentMoney'];
}
