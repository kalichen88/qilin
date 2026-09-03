<?php declare(strict_types=1);
namespace App\Model;
class IvLog extends Model {
    protected ?string $table = 'iv_log';
    protected array $fillable = ['ip', 'xvzf', 'fingerprint'];
}
