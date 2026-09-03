<?php declare(strict_types=1);
namespace App\Model;
class PayRequest extends Model {
    protected ?string $table = 'pay_request';
    protected array $fillable = ['orderId', 'params', 'status', 'requestParams', 'model', 'extra'];
}
