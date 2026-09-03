<?php declare(strict_types=1);
namespace App\Model;
class PayTemplate extends Model {
    protected ?string $table = 'pay_template';
    protected array $fillable = ['model', 'title', 'thumb', 'switch', 'isDefault'];
}
