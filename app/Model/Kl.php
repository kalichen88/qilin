<?php declare(strict_types=1);
namespace App\Model;
class Kl extends Model {
    protected ?string $table = 'kl';
    protected array $fillable = ['agent', 'kl', 'init'];
}
