<?php declare(strict_types=1);
namespace App\Model;
class Notify extends Model {
    protected ?string $table = 'notify';
    protected array $fillable = ['orderId', 'params'];
}
