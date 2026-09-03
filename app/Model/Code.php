<?php declare(strict_types=1);
namespace App\Model;
class Code extends Model {
    protected ?string $table = 'code';
    protected array $fillable = ['content', 'agent', 'status', 'active'];
}
