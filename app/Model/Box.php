<?php declare(strict_types=1);
namespace App\Model;
class Box extends Model {
    protected ?string $table = 'box';
    protected array $fillable = ['video', 'title', 'thumb'];
}
