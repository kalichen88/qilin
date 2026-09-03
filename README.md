# 万利云赏 · 知识付费系统重写 (wanli-v2)

> 技术栈：**Hyperf 3.1 + Swoole 5 + PHP 8.2 + MySQL 8 + Redis 7**。前端**先复用旧产物**（`runtime/manager` = Admin/Agent SPA、`runtime/view` = C 端 Vue），媒体来自**外部云转码系统**（API/CSV 入库 + 动态签名）。

## 目录
```text
wanli-v2/
  app/                  # 业务源码（Common/Controller/Middleware/Model/Media/Service/...）
  config/               # Hyperf 配置（config.php + autoload/*）
  bin/hyperf.php        # 启动入口
  storage/view/         # 复用旧服务端模板（落地/支付/播放/防红）
  bin/pay/ bin/short/ bin/lib/   # 复用旧支付/短链子进程
  runtime/manager|view|public|static|video   # 复用旧前端/静态
  database/1.49数据库.sql  # 数据库基线（含默认 admin/admin）
  Dockerfile / docker-compose.yml / .env.example
```

## 运行（本机 PHP 8.2 + Swoole 5）
```bash
cd wanli-v2
composer install
cp .env.example .env     # 按实际修改 DB/Redis/JWT
# 导入数据库（基线）
mysql -uwl -pwl wl < database/1.49数据库.sql
# 启动
php bin/hyperf.php start
# 验证
curl http://127.0.0.1:9501/health
```

## 运行（Docker，需可达镜像源）
```bash
cd wanli-v2
docker compose up -d
curl http://127.0.0.1:9501/health
```

## R0 已达成
- Hyperf 3.1 骨架可启动；`/health`、`/ping` 返回统一 `{code,msg,data}`。
- `/common/login`（admin 登录发 JWT）、`/common/basic`（站点信息）、`/common/getCode` 占位。
- 统一 `Response` + `AppExceptionHandler` + `BusinessException` + `ErrorCode`。
- Admin/Agent/Log 中间件骨架（JWT 双 scene）。
- 静态托管（`document_root=runtime/`）+ 旧前端 `manager/view/public` 复用。
- 媒体外部入库：`/api/media/import`（JSON/CSV）、`/api/media/sign`（动态签名占位）+ `MediaAdapter`/`MediaIngest`。

## R0 已验证可运行（实测通过）
在 PHP 8.1 + Swoole 5.0.2 + phpredis + MariaDB 10.6 环境实测：
```http
GET  /health            -> {"code":0,"msg":"ok","data":{"app":"wanli",...}}
GET  /health/ping       -> {"code":0,"msg":"ok","data":{"pong":true}}
GET  /common/basic      -> {"code":0,"msg":"ok","data":{"siteTitle":"万利云赏",...}}
POST /common/login      -> {"code":0,"msg":"登录成功","data":{"token":"eyJ0...","user":{...}}}   # admin/admin
POST /common/login      -> {"code":1001,"msg":"账号或密码错误",...}                              # 错误密码
GET  /api/media/sign?resourceId=123 -> {"code":0,"msg":"ok","data":{"resourceId":"123"}}
POST /api/media/import  -> {"code":0,"msg":"ok","data":{"total":1,"success":1,...}}            # 写入 video_video
```
- 说明：路由用**全量绝对路径**注解（`#[Controller]` 不带 prefix，方法 `path` 写全路径，如 `/common/login`）。
- `scan_cacheable=false`（开发期每次重扫）；R0 暂未开启后台进程（AsyncQueue/Crontab）与 DB 初始化监听，需 Redis/MySQL 就绪后再开。
- 数据库基线：`mysql -uwl -pwl wl < database/1.49数据库.sql`，并先执行 `database/setup.sql`（建库/建用户）。

## R1 已验证可运行（实测通过）
- `/common/login`：`admin/admin`(scope=admin)、`dl1/dl1`(scope=agent) 均签 JWT；错误密码 `1001 账号或密码错误`。
- `/common/auth`：携带 `Authorization: Bearer <token>` 返回用户载荷。
- `/common/logout`：将该 token 加入 Redis 黑名单（`jwt:bl:<md5>`），随后同名 token 再 `auth` 会失败（黑名单生效）。
- `/api/system/get/single`：需 `AdminAuth`（无 token→`401 未授权`；有 token→返回完整 `video_system`，含 siteTitle=万利云赏、txfl/fyfl、switch_* 等）。
- `/api/system/save`：鉴权后修改 `video_system`，`/common/basic` 回读已变更（siteTitle→万利云赏R1）。
- C 端上下文：`/` 等 `LogMiddleware` 捕获 `fingerprint/xvzf/t`（`/?t=abc` → `data.t=abc`）。
- `/api/public/getPublic?type=1` → 返回公共域名列表（如 `wl.91up.top`）。
- `/weixinCodeHandler?code=abc`、`/url`、`/shortVideo`：R1 骨架占位。

说明：R1 起 Redis 已启用（用于 JWT 黑名单）；`scan_cacheable=false`；后台进程(Crontab/AsyncQueue) 暂未开启。

## R2 已验证可运行（实测通过）
- 内容 CRUD（`AdminAuth`）：`/api/video|category|box|group|template|payTemplate|short|domain|notice` 的 `get/getall/get/single/add/save/delete/deletes`，视频另含 `adds`(批量) 与 `deleteAll`。实测：视频分页(total=126)、新增 id=257、分类/模板/短链/域名列表均正常。
- 代理 CRUD（`AdminAuth`）：`/api/agent` 的 `get/getall/get/single/getTotal/add/save/delete/deletes/pay/ff/short/password`，含分佣(`txfl/fyfl`)与按天/周/月自定价字段。实测新增代理 id=6。
- 代理推广（`AgentAuth`+`AgentLog`）：`/api/agentStart/getConfig` 返回分级定价与 `xvzf`；`add` 生成 `?t=<hash>` 写入 `video_promotion`；`copy` 复制新链接；`get` 列表分页。实测生成 `?t=sEAhAtMp`（id=58）。
- 无 token 访问 `/api/*` → `401 未授权`（Admin/Agent 中间件生效）。

说明：金额/卡密/支付/订单/提现/日志类（Order/Pay/PayLog/Code/Kl/Kllist/Tx/ActionLog/CheckLog/AdminChart 等）模型已建，控制器按 R3/R5 阶段接入。

## R3 已验证可运行（模拟支付闭环，实测通过）
- 支付抽象：`PaymentChannelInterface` + `MockChannel`（默认）+ `SubprocessChannel`（`PAY_DRIVER=real` 时经 `Swoole\Process::exec` 调 `bin/pay/<model>/index.php`，复用 28 个真实通道）。
- `POST /view/pay/checkout`：建单(`video_order` status=0) + 写 `video_pay_request`(params: notifyUrl/returnUrl/price) → 返回 `{orderId, type:form, data:<支付表单>, status}`。
- `GET /view/pay/getList`：返回启用支付通道（model/name/viewName/icon/extraMoney）。
- `POST /view/pay/notify|wxnotify`（`PayController`→`PaymentCallbackService`）：幂等置 `order.status=1`，写 `video_history`(授权,type 对应起止时间)、`video_pay_log`(流水)、`video_notify`(原始回调)，并计算 `parentMoney = price*agent.fyfl%` 给上级代理（验证 parentMoney=0.18=3.5×5%）。
- `GET /view/pay/checkOrder?orderId=`：返回 `{status:1|0, paid, url:/view/pay/return?orderId=}`。
- 幂等：重复 `notify` 返回 `{success:true, idempotent:true}`（不再重复落账）。

实测 DB 落库：`video_order.status=1 / parentMoney=0.18`、`video_history(video=257,fingerprint=fpR3Test,type=1,start/expire)`、`video_pay_log(agent=2,total=3.5,info=支付成功)`。

说明：`/view/pay/qrcode|h5|wxpay|wxjsapi` 为 R4 渲染模板占位（R4 接入 `storage/view` 落地页）。

## R4 已验证可运行（C 端 + 模板，实测通过）
- C 端 API（`/view/*`，挂 `LogMiddleware`）：`banner`、`getInfo`(video+price+purchased)、`search`、`likeSearch`、`getMyVideo`、`getBox`、`category/get|getAll`、`tousu/add`。
- **授权播放**：`POST /view/video/getUrl` → 校验 `video_history`(fingerprint/openid+expireTime)，已购经 `MediaAdapter::sign` 返回动态签名播放链；未购返回 `1001 未购买，请先支付`。
- **落地页**：`GET /` → 渲染 `storage/view/view.php` + `pc_switch`，加载**原版 Vue C 端 SPA**（复用 `runtime/view`）。
- **服务端模板**：`/view/video/payVideo` 渲染 `video.php`（含微信限制/`$site/$s_url*/$i_time_/…`）；`/view/pay/{h5,qrcode,wxpay,wxjsapi}` 渲染对应模板，出错回退 JSON（真实 C 端支付 UI 由 Vue `/h5`、`/qrcode`、`/payVideo` 路由承载）。
- `getUrl` 授权：无权限→`1001`；有权限(如 fpR3Test)→返回 `url`。

实测：落地页 `200 text/html`；payVideo 渲染 `video.php` HTML；tousu 写入 `video_tousu`；`getMyVideo` 返回授权记录；`banner/search/getInfo` 均返回数据。

## R5 已验证可运行（防红/短链/卡密/提现 + 看板，实测通过）
- 提现（admin `/api/tixian` + agent `/api/agentTx`）：agent `getTotal/add`(冻结余额)、admin `pass`(通过，**不重复扣款**)/`reject`(驳回并**退款**)/`get/getTotal`。
- 看板：`/api/adminChart/getNowData`（今日 visits/orders/amount/kl/tx/paylog/search）+ `/api/agentChart/getNowData`（按 agent.hash=xvzf 统计访问、按 agent 统计订单/金额/distribute）。
- 短链：`/api/short/build` 复用 `ShortService`（真实 `bin/short/<model>/index.php`，否则 mock）。
- 卡密：`/api/code`、`/api/kl`、`/api/kllist` CRUD。
- 巡检：`App\Task\CheckTask`（读 `video_task(id=1).config` 中 `switch=true` 的 key 逐项 `Check` 写 `video_checklog`）+ `App\Command\CheckCommand`（`php bin/hyperf.php check:run`）。

实测：agent 提现 1 元 → admin 通过后余额 5.4（6.4−1，未双重扣款）；adminChart 显示今日 orders=1/amount=3.5/paylog=1；code 列表返回；short build 返回 `http://s.wl/<hash>`；`check:run` 正常运行（启用开关即写 `video_checklog`）。

## R6 已验证（运维/监控 + 收尾）
- 静态/前端复用：`GET /manager/index.html`→200(Ant Design Pro)、`GET /view/js/app.*.js`→200(Vue SPA)、`GET /`→Vue 落地页。
- 后端进程：`processes.php` + `crontab.php` 恢复（AsyncQueue ConsumerProcess + CrontabDispatcherProcess），`CheckTask` 加 `#[Crontab(rule:'*/5 * * * * *')]`。说明：本环境未见到独立 crontab 进程生成（`hyperf/crontab` 进程注册需在 Redis 就绪后进一步配置），`CheckTask` 已由 `php bin/hyperf.php check:run` 验证可运行。
- CI：`.github/workflows/ci.yml` + `.gitlab-ci.yml`（PHP8.1/8.2 + Swoole + composer + `php -l`）。
- `hyperf/metric`（Prometheus）因需 `prometheus/client` 暂移除，`/metrics` 延后。
- 验收对拍清单：`docs/10-验收对拍清单.md`（接口/字段 vs 原版，逐条状态 + 外部依赖）。

## 前端接回 / 媒体签名 / 支付对账（实测通过）
- **前端接回（SPA fallback）**：`/manager`、`/manager/`、`/manager/{path}` → 渲染 `runtime/manager/index.html`；`/manager/*.js|css` 由静态处理器命中；`/h5`、`/payVideo`、`/qrcode`、`/tousu` → 渲染 `view.php`(Vue SPA)。实测：`/manager/admin/agent`→200 HTML、`/manager/umi.js`→200 JS、`/manager/`→200、`/h5`→200 HTML。
- **MediaAdapter 云转码签名**：配置 `MEDIA_SIGN_URL` 后，`sign()` POST `{resourceId}` 到云转码系统取新鲜 `{url,expires}`；未配置回落为原样返回（`getUrl` 授权播放不受影响）。
- **真实支付对账**：`App\Command\ReconcileCommand`(`php bin/hyperf.php pay:reconcile`) + `PaymentReconcileService`：仅结算“近 24h、带指纹、超 5 分钟未付”的待付单（避免误结算历史单），经 `PaymentCallbackService::handle` 幂等落账（order.status=1 + history + parentMoney）。实测 `{"settled":1}`，订单 status=1。

## 最终交付物
- 可运行后端（WSL 实测）：Hyperf 3.1 + Swoole5 + PHP8.1 + MariaDB + Redis。
- `docs/01..10`：接口清单 / 数据字典+ER / 时序图 / 深度补全 / 支付通道明细 / 架构与选型 / 补充发现+UI规格 / 前端复用与媒体入库 / R0任务卡 / 验收对拍清单。
- 复用资产：`storage/view`、`bin/pay|short`、`runtime/manager|view|public|static|video`。

## 前端渐进迁移（Vue3 / React18 种子）
- **C 端**：`frontend/c-vue3`（Vue3 + Vite + vue-router + axios）。
  - 页面：`/`(首页 banner+搜索+列表)、`/video/:id`(详情+购买+播放)、`/tousu`(投诉)。
  - 复用后端契约：`/view/video/*`、`/view/pay/*`、`/view/tousu/add`；`vite.config.js` 代理 `/view`、`/api`、`/common` → `:9501`。
- **管理端**：`frontend/admin-react18`（React18 + Vite + AntD5 + react-router + axios）。
  - 页面：`/login`、`/`(看板)、`/videos`、`/agents`，以及 `modules.js` 的 16 个 CRUD 模块（category/box/group/template/payTemplate/short/domain/notice/order/pay/code/kl/kllist/tx/tousu/checkLog），由通用 `CrudPage` 统一驱动。
  - 复用契约：`/common/login`、`/api/adminChart|video|agent`；代理 `/common`、`/api` → `:9501`。
- **C 端已扩**：`/`(banner+搜索+列表+分类)、`/video/:id`(详情+购买+播放)、`/my`(已购)、`/tousu`。
- 迁移路线：`docs/12-前端渐进迁移路线.md`（影子并行→逐页对拍→切流，含 C 端/管理端/代理端里程碑）。
- 运行（需 Node 18+ / npm）：`cd frontend/c-vue3 && npm i && npm run dev`；`cd frontend/admin-react18 && npm i && npm run dev`；构建产物可交给后端 `/` 与 `/manager` 静态托管。
- 说明：本环境仅有 Node12 无 npm，无法在此实际构建；两前端为“渐进迁移种子”，与原版 `runtime/view`、`runtime/manager` 并存，可逐步替换页面。

## 前端环境已就绪（Node20 + npm，实际构建通过）
- 已在 WSL 安装 **Node v20.15.0 + npm 10.7.0**，并配置 npm 代理（`127.0.0.1:7890`）+ 镜像（`registry.npmmirror.com`）。
- **Vue3 C 端** `npm run build` 通过（Vite5.4，148KB JS，`dist-c-view/`）。
- **React18 管理端** `npm run build` 通过（Vite5.4，antd 打入，`dist-admin/`）。
- 已补 M1/M2 页面：管理端 `SystemPage`(系统配置 `/system`)、`TxReview`(提现审核 `/txReview`)；C 端 `App` 处理微信 `code`(OAuth)、`Detail` 支付轮询 `/view/pay/checkOrder`。
- **M3**：管理端新增 `AgentConsole`(`/agent` 代理中心：推广生成/订单/提现/卡密/流水/看板)；C 端 `Detail` 增加支付方式选择(`/view/pay/getList`)；后端新增 `AgentCode/AgentOrder/AgentPayLog` 控制器（代理 API 完整）。
- 构建产物已拷回 `frontend/dist-c-view`、`frontend/dist-admin`，可交给后端 `/`、`/manager`（或新路径）静态托管。
- 构建方式：`cd frontend/c-vue3 && npm i && npm run build`；`cd frontend/admin-react18 && npm i && npm run build`。

## 待办（R1+）
见 `docs/09-R0任务卡与阶段计划.md`。
