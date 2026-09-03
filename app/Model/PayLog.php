<?php declare(strict_types=1);
namespace App\Model;
class PayLog extends Model {
    protected ?string $table = 'pay_log';
    protected array $fillable = ['agent','total','info','orderId','admin'];
}
