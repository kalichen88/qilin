<?php declare(strict_types=1);
namespace App\Model;
class Kllist extends Model {
    protected ?string $table = 'kllist';
    protected array $fillable = ['orderId', 'video', 'price', 'agent'];
}
