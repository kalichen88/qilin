<?php declare(strict_types=1);
namespace App\Controller\View;

use App\Common\AbstractController;
use App\Common\Response;
use App\Middleware\LogMiddleware;
use App\Model\Category;
use App\Model\Video;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(LogMiddleware::class)]
class CategoryController extends AbstractController
{
    #[PostMapping(path: '/view/category/get')]
    public function get(): mixed
    {
        return Response::success($this->response, Category::query()->orderBy('sort')->get());
    }

    #[PostMapping(path: '/view/category/getAll')]
    public function getAll(): mixed
    {
        // video_video 无 category 关联字段；返回全量分页视频
        return Response::success($this->response, Video::query()->orderByDesc('id')->paginate(12));
    }
}
