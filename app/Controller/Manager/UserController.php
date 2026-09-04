<?php declare(strict_types=1);
namespace App\Controller\Manager;

use App\Common\AbstractController;
use App\Common\JwtUtil;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;

/**
 * 兼容旧 Ant Design Pro 管理端（/manager）：
 *   GET /api/user/get  === 获取当前登录用户（admin / agent）。
 *   注意：旧前端不携带 Authorization 头，因此使用 Cookie(wanli_token) 作为回退；
 *   未登录时返回 code=100，前端据此跳转 /user/login。
 */
#[Controller]
class UserController extends AbstractController
{
    /** 管理端菜单权限串 */
    private const ADMIN_RULE = [
        '/admin', '/admin/dashboard',
        '/admin/agent', '/admin/agent/index', '/admin/agent/code',
        '/admin/auth', '/admin/auth/group', '/admin/auth/settings',
        '/admin/finance', '/admin/finance/kllist', '/admin/finance/order',
        '/admin/finance/paylog', '/admin/finance/tx/pass', '/admin/finance/tx/reject', '/admin/finance/tx/wait',
        '/admin/setting', '/admin/setting/checkLog', '/admin/setting/files',
        '/admin/setting/log', '/admin/setting/short', '/admin/setting/tousu',
        '/admin/system', '/admin/system/domain', '/admin/system/index',
        '/admin/system/kl', '/admin/system/notice', '/admin/system/pay',
        '/admin/system/payTemplate', '/admin/system/template',
        '/admin/video', '/admin/video/box', '/admin/video/category', '/admin/video/video',
    ];

    /** 代理中心菜单权限串 */
    private const AGENT_RULE = [
        '/agent', '/agent/analysis', '/agent/start', '/agent/code',
        '/agent/order', '/agent/paylog', '/agent/tx', '/agent/settings',
    ];

    #[GetMapping(path: '/api/user/get')]
    public function get(): mixed
    {
        $payload = JwtUtil::payloadFromRequest($this->request);

        // 未登录：返回 code=100，前端 replace('/user/login')
        if (! $payload) {
            // 旧前端在 code=100 时仍会 dispatch saveCurrentUser(payload: data)，
            // 因此 data 必须是非 null 对象，否则 reducer 读到 null.type 会抛错。
            return $this->response->json([
                'code' => 100,
                'msg' => '请登录',
                'data' => ['type' => 'guest', 'rule' => [], 'info' => ['name' => '', 'userid' => 0]],
            ]);
        }

        $scope = (string) ($payload['scope'] ?? 'admin');
        $uid = (int) ($payload['uid'] ?? 0);
        $name = (string) ($payload['name'] ?? '管理员');

        if ($scope === 'agent') {
            $type = 'agent';
            $rule = self::AGENT_RULE;
        } else {
            $type = 'admin';
            $rule = self::ADMIN_RULE;
        }

        return $this->response->json([
            'code' => 0,
            'msg' => 'ok',
            'data' => [
                'type' => $type,
                'rule' => $rule,
                'info' => ['name' => $name, 'userid' => $uid, 'avatar' => '', 'id' => $uid],
            ],
        ]);
    }
}
