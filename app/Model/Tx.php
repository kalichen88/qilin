<?php declare(strict_types=1);
namespace App\Model;
class Tx extends Model {
    protected ?string $table = 'tx';
    protected array $fillable = ['agent','price','payImage','type','remark','status','account','rejectContent'];
}
