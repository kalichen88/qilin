<?php declare(strict_types=1);
namespace App\Model;
class Category extends Model {
    protected ?string $table = 'category';
    protected array $fillable = ['name', 'thumb', 'keyword', 'sort'];
}
