<?php declare(strict_types=1);
namespace App\Model;
class Template extends Model {
    protected ?string $table = 'template';
    protected array $fillable = ['model', 'title', 'info', 'thumb', 'switch', 'isDefault'];
}
