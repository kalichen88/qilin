<?php declare(strict_types=1);
namespace App\Model;
class Pay extends Model {
    protected ?string $table = 'pay';
    protected array $fillable = ['name','payId','payKey','payGateway','extra','productName','payType','viewName','icon','extraMoney','model','switch','sort'];
}
