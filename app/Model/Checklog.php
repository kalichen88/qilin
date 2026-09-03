<?php declare(strict_types=1);
namespace App\Model;
class Checklog extends Model {
    protected ?string $table = 'checklog';
    protected array $fillable = ['url', 'response'];
}
