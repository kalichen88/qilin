<?php declare(strict_types=1);
namespace App\Model;
class Tousu extends Model {
    protected ?string $table = 'tousu';
    protected array $fillable = ['ip', 'type', 'content', 'fingerprint', 'openid'];
}
