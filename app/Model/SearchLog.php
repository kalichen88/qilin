<?php declare(strict_types=1);
namespace App\Model;
class SearchLog extends Model {
    protected ?string $table = 'search_log';
    protected array $fillable = ['ip', 'fingerprint', 'openid', 'keyword'];
}
