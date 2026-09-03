<?php
declare(strict_types=1);

namespace App\Media;

use Hyperf\Context\ApplicationContext;
use Hyperf\Guzzle\ClientFactory;

/**
 * 云转码/媒体源适配器：负责“canonical 资源 → 动态签名 URL”。
 * 配置 MEDIA_SIGN_URL 后走远程签名接口（云转码系统），否则回落为原样返回。
 */
class MediaAdapter
{
    public function __construct(protected array $config = [])
    {
    }

    /**
     * 对给定的资源返回一个带签名的可播放 URL。
     *
     * @param array $resource ['resourceId','mediaUrl','playUrl','cover','source2']
     */
    public function sign(array $resource): array
    {
        $signUrl = (string) env('MEDIA_SIGN_URL', '');
        if ($signUrl !== '' && ! empty($resource['resourceId'])) {
            try {
                $client = ApplicationContext::getContainer()->get(ClientFactory::class)->create();
                $response = $client->post($signUrl, ['json' => ['resourceId' => $resource['resourceId']]]);
                $data = json_decode((string) $response->getBody(), true);
                if (is_array($data) && ! empty($data['url'])) {
                    return [
                        'mediaUrl' => (string) $data['url'],
                        'playUrl' => (string) ($resource['playUrl'] ?? ''),
                        'cover' => (string) ($resource['cover'] ?? ''),
                        'expires' => (int) ($data['expires'] ?? time() + 3600),
                    ];
                }
            } catch (\Throwable $e) {
                // 远程失败则回落
            }
        }
        // 回落：canonical url 原样返回，并保留 expires 供前端/定时刷新
        return [
            'mediaUrl' => $resource['mediaUrl'] ?? '',
            'playUrl' => $resource['playUrl'] ?? '',
            'cover' => $resource['cover'] ?? '',
            'expires' => time() + 3600,
        ];
    }

    /**
     * 从云转码系统按 resourceId 重新换取新鲜签名。
     */
    public function refresh(string $resourceId): array
    {
        return $this->sign(['resourceId' => $resourceId]);
    }
}
