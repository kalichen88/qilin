<?php
declare(strict_types=1);

namespace App\Media;

use App\Model\Video;

/**
 * 媒体入库：外部云转码系统（API 推送 / CSV 表格批量）写入本系统 video_video。
 */
class MediaIngest
{
    public function __construct(protected MediaAdapter $adapter)
    {
    }

    /**
     * 单条导入。$row: ['title','coverUrl','playUrl','mediaUrl','source2']
     */
    public function importOne(array $row): array
    {
        $title = trim((string) ($row['title'] ?? ''));
        $mediaUrl = trim((string) ($row['mediaUrl'] ?? ''));
        if ($title === '' || $mediaUrl === '') {
            return ['ok' => false, 'reason' => '标题或媒体链接缺失', 'row' => $row];
        }

        $exists = Video::query()->where('title', $title)->first();
        if ($exists) {
            return ['ok' => true, 'skipped' => true, 'id' => $exists->id, 'reason' => '已存在(按标题去重)'];
        }

        $video = Video::query()->create([
            'title' => $title,
            'videoUrl' => $mediaUrl,
            'thumb' => (string) ($row['coverUrl'] ?? ''),
            'payNum' => 0,
            'videoDuration' => (string) ($row['duration'] ?? ''),
        ]);

        return ['ok' => true, 'id' => $video->id];
    }

    /**
     * 批量导入。$rows 为 CSV 解析后的行数组。
     */
    public function importBatch(array $rows): array
    {
        $result = ['total' => count($rows), 'success' => 0, 'skipped' => 0, 'failed' => []];
        foreach ($rows as $row) {
            $r = $this->importOne($row);
            if (! empty($r['ok'])) {
                ! empty($r['skipped']) ? $result['skipped']++ : $result['success']++;
            } else {
                $result['failed'][] = $r;
            }
        }
        return $result;
    }
}
