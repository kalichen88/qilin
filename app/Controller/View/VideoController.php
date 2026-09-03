<?php declare(strict_types=1);
namespace App\Controller\View;

use App\Common\Response;
use App\Common\ViewAbstractController;
use App\Common\ViewCtx;
use App\Media\MediaAdapter;
use App\Middleware\LogMiddleware;
use App\Model\Box;
use App\Model\History;
use App\Model\System;
use App\Model\Video;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(LogMiddleware::class)]
class VideoController extends ViewAbstractController
{
    #[Inject]
    protected MediaAdapter $adapter;

    #[PostMapping(path: '/view/video/banner')]
    public function banner(): mixed
    {
        return Response::success($this->response, Video::query()->orderByDesc('payNum')->limit(6)->get());
    }

    #[PostMapping(path: '/view/video/getInfo')]
    public function getInfo(): mixed
    {
        $id = (int) $this->request->input('id', 0);
        $video = Video::find($id);
        $sys = System::query()->first();
        return Response::success($this->response, [
            'video' => $video,
            'purchased' => $this->purchased($id),
            'price' => [
                'single' => $sys->min_price ?? 1,
                'day' => $sys->day_min_price ?? 1,
                'week' => $sys->week_min_price ?? 1,
                'mouth' => $sys->mouth_min_price ?? 1,
            ],
        ]);
    }

    #[PostMapping(path: '/view/video/getUrl')]
    public function getUrl(): mixed
    {
        $id = (int) $this->request->input('id', 0);
        $video = Video::find($id);
        if (! $video) {
            return Response::error($this->response, '资源不存在', 404);
        }
        if (! $this->purchased($id)) {
            return Response::error($this->response, '未购买，请先支付', 1001);
        }
        $signed = $this->adapter->sign([
            'resourceId' => (string) $id,
            'mediaUrl' => (string) $video->videoUrl,
            'playUrl' => '',
            'cover' => (string) $video->thumb,
        ]);
        return Response::success($this->response, [
            'url' => $signed['mediaUrl'],
            'cover' => $video->thumb,
            'title' => $video->title,
            'expires' => $signed['expires'] ?? 0,
        ]);
    }

    #[PostMapping(path: '/view/video/search')]
    public function search(): mixed
    {
        $kw = (string) $this->request->input('keyword', '');
        return Response::success($this->response, Video::query()->where('title', 'like', '%' . $kw . '%')->paginate(12));
    }

    #[PostMapping(path: '/view/video/likeSearch')]
    public function likeSearch(): mixed
    {
        $id = (int) $this->request->input('id', 0);
        return Response::success($this->response, Video::query()->where('id', '!=', $id)->orderByDesc('payNum')->limit(8)->get());
    }

    #[PostMapping(path: '/view/video/getMyVideo')]
    public function getMyVideo(): mixed
    {
        $fp = ViewCtx::get('fingerprint');
        $openid = ViewCtx::get('openid');
        $query = History::query()->where('expireTime', '>', time())->where(function ($q) use ($fp, $openid) {
            if ($fp !== '') {
                $q->orWhere('fingerprint', $fp);
            }
            if ($openid !== '') {
                $q->orWhere('openid', $openid);
            }
        });
        return Response::success($this->response, $query->orderByDesc('id')->get());
    }

    #[PostMapping(path: '/view/video/getBox')]
    public function getBox(): mixed
    {
        return Response::success($this->response, Box::query()->get());
    }

    #[GetMapping(path: '/view/video/payVideo')]
    public function payVideo(): mixed
    {
        $id = (int) $this->request->query('id', 0);
        $video = Video::find($id);
        $sys = System::query()->first();
        try {
            return $this->view->render('video', [
                'video' => $video,
                'config' => ViewCtx::all(),
                'site' => (string) ($sys->siteName ?? ''),
                't' => ViewCtx::get('t'),
                'url' => '',
                'adImg' => (string) ($sys->adImg ?? ''),
                'i_time_1' => (int) ($sys->i_time_1 ?? 0),
                'i_time_2' => (int) ($sys->i_time_2 ?? 0),
                'i_time_3' => (int) ($sys->i_time_3 ?? 0),
                's_url' => (string) ($sys->s_url ?? ''),
                's_url_1' => (string) ($sys->s_url_1 ?? ''),
                's_url_2' => (string) ($sys->s_url_2 ?? ''),
                's_url_3' => (string) ($sys->s_url_3 ?? ''),
                's_url_4' => (string) ($sys->s_url_4 ?? ''),
            ]);
        } catch (\Throwable $e) {
            return Response::success($this->response, ['page' => 'payVideo', 'id' => $id, 'error' => $e->getMessage()]);
        }
    }

    private function purchased(int $id): bool
    {
        $fp = ViewCtx::get('fingerprint');
        $openid = ViewCtx::get('openid');
        return History::query()->where('video', $id)->where('expireTime', '>', time())
            ->where(function ($q) use ($fp, $openid) {
                if ($fp !== '') {
                    $q->orWhere('fingerprint', $fp);
                }
                if ($openid !== '') {
                    $q->orWhere('openid', $openid);
                }
            })
            ->exists();
    }
}
