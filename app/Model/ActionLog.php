<?php declare(strict_types=1);
namespace App\Model;
class ActionLog extends Model {
    protected ?string $table = 'action_log';
    protected array $fillable = ['url', 'fullUrl', 'actionId', 'ip', 'content'];
}
