<?php declare(strict_types=1);
namespace App\Controller\Manager;
use App\Common\Response;
use App\Middleware\AdminAuthMiddleware;
use App\Model\Short;
use App\Service\ShortService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AdminAuthMiddleware::class)]
class ShortController extends BaseCrudController
{
    protected function model(): string { return Short::class; }
    protected array $searchable = ['name'];
    protected array $fields = ['name', 'key', 'model', 'switch', 'sort'];
    #[GetMapping(path: '/api/short/get')] public function get(): mixed { return Response::success($this->response, $this->q_page()); }
    #[GetMapping(path: '/api/short/getall')] public function getall(): mixed { return Response::success($this->response, Short::query()->orderBy('sort')->get()); }
    #[GetMapping(path: '/api/short/get/single')] public function single(): mixed { return Response::success($this->response, $this->q_single((int) $this->request->input('id', 0))); }
    #[PostMapping(path: '/api/short/add')] public function add(): mixed { return Response::success($this->response, $this->q_save(null)); }
    #[PostMapping(path: '/api/short/save')] public function save(): mixed { return Response::success($this->response, $this->q_save((int) $this->request->input('id', 0))); }
    #[PostMapping(path: '/api/short/delete')] public function delete(): mixed { return Response::success($this->response, ['deleted' => $this->q_delete((int) $this->request->input('id', 0))]); }
    #[PostMapping(path: '/api/short/deletes')] public function deletes(): mixed { return Response::success($this->response, ['deleted' => $this->q_deletes()]); }

    #[Inject]
    protected ShortService $shortService;

    #[PostMapping(path: '/api/short/build')]
    public function build(): mixed
    {
        $url = (string) $this->request->input('url', '');
        $model = (string) $this->request->input('model', '');
        $key = (string) $this->request->input('key', '');
        $short = $this->shortService->shorten($url, $model, $key);
        return Response::success($this->response, ['url' => $short]);
    }
}
