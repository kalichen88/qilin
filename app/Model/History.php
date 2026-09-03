<?php declare(strict_types=1);
namespace App\Model;
class History extends Model {
    protected ?string $table = 'history';
    protected array $fillable = ['video','fingerprint','openid','type','startTime','expireTime','xvzf'];
}
