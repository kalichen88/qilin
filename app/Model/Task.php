<?php declare(strict_types=1);
namespace App\Model;
class Task extends Model {
    protected ?string $table = 'task';
    protected array $fillable = ['config'];
}
