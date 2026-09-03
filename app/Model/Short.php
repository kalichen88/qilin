<?php declare(strict_types=1);
namespace App\Model;
class Short extends Model {
    protected ?string $table = 'short';
    protected array $fillable = ['name', 'key', 'model', 'switch', 'sort'];
}
