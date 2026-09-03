<?php declare(strict_types=1);
namespace App\Model;
class Group extends Model {
    protected ?string $table = 'group';
    protected array $fillable = ['name', 'rule'];
}
