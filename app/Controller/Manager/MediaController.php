<?php
declare(strict_types=1);

namespace App\Controller\Manager;

use App\Common\AbstractController;
use App\Common\Response;
use App\Media\MediaIngest;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\GetMapping;

#[Controller]
class MediaController extends AbstractController
{
    #[Inject]
    protected MediaIngest $ingest;

    /**
     * 外部云转码系统推送 / Admin 批量导入。
     * body(JSON 或表单): rows[] = [{title, coverUrl, playUrl, mediaUrl, source2}]
     */
    #[PostMapping(path: '/api/media/import')]
    public function import(): mixed
    {
        $rows = (array) $this->request->input('rows', []);
        if (empty($rows)) {
            // 支持直接传单条字段
            $row = [
                'title' => $this->request->input('title'),
                'coverUrl' => $this->request->input('coverUrl', $this->request->input('thumb')),
                'playUrl' => $this->request->input('playUrl'),
                'mediaUrl' => $this->request->input('mediaUrl', $this->request->input('videoUrl')),
                'source2' => $this->request->input('source2'),
            ];
            $rows = [$row];
        }
        return Response::success($this->response, $this->ingest->importBatch($rows));
    }

    /**
     * 云转码系统签名接口占位：按 resourceId 取新鲜签名。
     */
    #[GetMapping(path: '/api/media/sign')]
    public function sign(): mixed
    {
        $resourceId = (string) $this->request->query('resourceId', '');
        return Response::success($this->response, ['resourceId' => $resourceId]);
    }
}
