<?php declare(strict_types=1);
namespace App\Controller\Agent;
use App\Common\AbstractController;
use App\Common\Response;
use App\Common\Utils;
use App\Common\ViewCtx;
use App\Middleware\AgentAuthMiddleware;
use App\Middleware\AgentLogMiddleware;
use App\Model\Agent;
use App\Model\Box;
use App\Model\Domain;
use App\Model\PayTemplate;
use App\Model\Promotion;
use App\Model\Short;
use App\Model\Template;
use Hyperf\Context\Context;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AgentAuthMiddleware::class)]
#[Middleware(AgentLogMiddleware::class)]
class AgentStartController extends AbstractController
{
    private function agentId(): int
    {
        return (int) (Context::get('agent_user')['uid'] ?? 0);
    }

    #[GetMapping(path: '/api/agentStart/getConfig')]
    public function getConfig(): mixed
    {
        $agent = Agent::find($this->agentId());
        return Response::success($this->response, [
            'agent' => $agent,
            'xvzf' => $agent->hash ?? '',
            'priceType' => $agent->priceType ?? '',
            'priceMin' => $agent->priceMin ?? 0,
            'priceMax' => $agent->priceMax ?? 0,
        ]);
    }

    #[GetMapping(path: '/api/agentStart/getTemplate')] public function getTemplate(): mixed { return Response::success($this->response, Template::query()->where('switch', 1)->get()); }
    #[GetMapping(path: '/api/agentStart/getPayTemplate')] public function getPayTemplate(): mixed { return Response::success($this->response, PayTemplate::query()->where('switch', 1)->get()); }
    #[GetMapping(path: '/api/agentStart/getBox')] public function getBox(): mixed { return Response::success($this->response, Box::query()->get()); }
    #[GetMapping(path: '/api/agentStart/getShort')] public function getShort(): mixed { return Response::success($this->response, Short::query()->where('switch', 1)->get()); }
    #[GetMapping(path: '/api/agentStart/getBetween')] public function getBetween(): mixed { return Response::success($this->response, ['type' => 1, 'priceMin' => 1, 'priceMax' => 1]); }
    #[GetMapping(path: '/api/agentStart/getDefault')] public function getDefault(): mixed { return Response::success($this->response, ['useTemplate' => 'muban1', 'usePayTemplate' => 'pay1', 'short' => 0, 'domain' => 0, 'box' => 0]); }

    #[GetMapping(path: '/api/agentStart/get')] public function get(): mixed { return Response::success($this->response, Promotion::query()->where('agent', $this->agentId())->orderByDesc('id')->paginate(20)); }

    #[PostMapping(path: '/api/agentStart/add')]
    public function add(): mixed
    {
        $agentId = $this->agentId();
        $hash = Utils::promoHash();
        $domain = Domain::find((int) $this->request->input('domain', 0));
        $host = $domain->host ?? '';
        $url = $host ? 'http://' . $host . '/?t=' . $hash : '/?t=' . $hash;
        $promo = Promotion::query()->create([
            'agent' => $agentId,
            'useTemplate' => (string) $this->request->input('useTemplate', 'muban1'),
            'usePayTemplate' => (string) $this->request->input('usePayTemplate', 'pay1'),
            'url' => $url,
            'shortUrl' => $url,
            'short' => (int) $this->request->input('short', 0),
            'domain' => (int) $this->request->input('domain', 0),
            'box' => (int) $this->request->input('box', 0),
            'hash' => $hash,
            'remark' => (string) $this->request->input('remark', ''),
        ]);
        return Response::success($this->response, $promo, '已生成推广链接');
    }

    #[PostMapping(path: '/api/agentStart/save')] public function save(): mixed { $promo = Promotion::find((int) $this->request->input('id', 0)); if ($promo) { $promo->useTemplate = (string) $this->request->input('useTemplate', $promo->useTemplate); $promo->usePayTemplate = (string) $this->request->input('usePayTemplate', $promo->usePayTemplate); $promo->remark = (string) $this->request->input('remark', $promo->remark); $promo->save(); } return Response::success($this->response, $promo); }

    #[GetMapping(path: '/api/agentStart/copy')]
    public function copy(): mixed
    {
        $src = Promotion::find((int) $this->request->query('id', 0));
        if (! $src) {
            return Response::success($this->response, null);
        }
        $hash = Utils::promoHash();
        $url = str_replace('t=' . $src->hash, 't=' . $hash, (string) $src->url);
        $copy = Promotion::query()->create([
            'agent' => $this->agentId(), 'useTemplate' => $src->useTemplate, 'usePayTemplate' => $src->usePayTemplate,
            'url' => $url, 'shortUrl' => $url, 'short' => $src->short, 'domain' => $src->domain, 'box' => $src->box,
            'hash' => $hash, 'remark' => $src->remark,
        ]);
        return Response::success($this->response, $copy);
    }

    #[PostMapping(path: '/api/agentStart/changeMoney')] public function changeMoney(): mixed { $a = Agent::find($this->agentId()); if ($a) { $a->money = (float) $this->request->input('money', $a->money); $a->save(); } return Response::success($this->response, $a); }

    #[PostMapping(path: '/api/agentStart/updates')] public function updates(): mixed { $a = Agent::find($this->agentId()); if ($a) { foreach (['priceType', 'priceOnce', 'priceMin', 'priceMax', 'video_day_switch', 'video_day_price', 'video_week_switch', 'video_week_price', 'video_mouth_switch', 'video_mouth_price'] as $f) { if ($this->request->has($f)) { $a->{$f} = $this->request->input($f); } } $a->save(); } return Response::success($this->response, $a); }

    #[GetMapping(path: '/api/agentStart/changeTempalte')] public function changeTemplate(): mixed { $promo = Promotion::find((int) $this->request->query('id', 0)); if ($promo) { $promo->useTemplate = (string) $this->request->query('useTemplate', $promo->useTemplate); $promo->save(); } return Response::success($this->response, $promo); }
    #[GetMapping(path: '/api/agentStart/changePayTemplate')] public function changePayTemplate(): mixed { $promo = Promotion::find((int) $this->request->query('id', 0)); if ($promo) { $promo->usePayTemplate = (string) $this->request->query('usePayTemplate', $promo->usePayTemplate); $promo->save(); } return Response::success($this->response, $promo); }
}
