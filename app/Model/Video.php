<?php
declare(strict_types=1);

namespace App\Model;

class Video extends Model
{
    protected ?string $table = 'video';

    protected array $fillable = ['videoUrl', 'thumb', 'title', 'payNum', 'videoDuration'];
}
