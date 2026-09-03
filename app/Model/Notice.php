<?php declare(strict_types=1);
namespace App\Model;
class Notice extends Model {
    protected ?string $table = 'notice';
    protected array $fillable = ['title','content'];
}
