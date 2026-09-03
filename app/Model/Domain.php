<?php
declare(strict_types=1);

namespace App\Model;

class Domain extends Model
{
    protected ?string $table = 'domain';

    protected array $fillable = ['host', 'wechat', 'qq', 'type', 'agent'];
}
