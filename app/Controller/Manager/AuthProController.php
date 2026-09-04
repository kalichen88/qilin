<?php declare(strict_types=1);
namespace App\Controller\Manager;

use App\Common\AbstractController;
use App\Common\JwtUtil;
use App\Common\Response;
use App\Model\Admin;
use App\Model\Agent;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;

/**
 * Ant Design Pro 前端（/manager）默认接口适配：login/account、currentUser、notices。
 */
#[Controller]
class AuthProController extends AbstractController
{
    #[PostMapping(path: '/api/login/account')]
    public function loginAccount(): mixed
    {
        $username = (string) $this->request->input('username', '');
        $password = (string) $this->request->input('password', '');

        $admin = Admin::query()->where('user', $username)->first();
        if ($admin && $admin->password === $password && (int) $admin->flag === 1) {
            $token = JwtUtil::issue('admin', (int) $admin->id, ['name' => $admin->name]);
            return $this->response->json([
                'status' => 'ok', 'type' => 'account', 'currentAuthority' => 'admin',
                'token' => $token, 'name' => $admin->name, 'userid' => $admin->id,
            ]);
        }

        $agent = Agent::query()->where('user', $username)->first();
        if ($agent && $agent->password === $password) {
            $token = JwtUtil::issue('agent', (int) $agent->id, ['name' => $agent->name]);
            return $this->response->json([
                'status' => 'ok', 'type' => 'account', 'currentAuthority' => 'agent',
                'token' => $token, 'name' => $agent->name, 'userid' => $agent->id,
            ]);
        }

        return $this->response->json(['status' => 'error', 'type' => 'account', 'currentAuthority' => 'guest']);
    }

    #[GetMapping(path: '/api/currentUser')]
    public function currentUser(): mixed
    {
        $header = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $header);
        $payload = $token ? JwtUtil::verify($token) : null;
        if ($payload) {
            return $this->response->json([
                'name' => $payload['name'] ?? '管理员',
                'avatar' => '',
                'userid' => $payload['uid'] ?? 0,
                'access' => $payload['scope'] ?? 'admin',
            ]);
        }
        return $this->response->json(['name' => 'admin', 'avatar' => '', 'userid' => 1, 'access' => 'admin']);
    }

    #[GetMapping(path: '/api/notices')]
    public function notices(): mixed
    {
        return $this->response->json([]);
    }
}
