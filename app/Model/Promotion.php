<?php declare(strict_types=1);
namespace App\Model;
class Promotion extends Model {
    protected ?string $table = 'promotion';
    protected array $fillable = ['agent','useTemplate','usePayTemplate','url','shortUrl','short','domain','box','hash','remark'];
}
