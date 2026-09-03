<?php
declare(strict_types=1);

namespace App\Model;

class Admin extends Model
{
    protected ?string $table = 'admin';

    protected array $fillable = ['user', 'password', 'name', 'flag'];
}
