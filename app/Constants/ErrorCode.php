<?php
declare(strict_types=1);

namespace App\Constants;

class ErrorCode
{
    /**
     * 通用成功
     */
    public const SUCCESS = 0;

    /**
     * 通用错误
     */
    public const SERVER_ERROR = 500;

    /**
     * 参数错误
     */
    public const PARAM_ERROR = 400;

    /**
     * 未登录 / token 无效
     */
    public const UNAUTHORIZED = 401;

    /**
     * 无权限
     */
    public const FORBIDDEN = 403;

    /**
     * 资源不存在
     */
    public const NOT_FOUND = 404;

    /**
     * 业务错误（默认）
     */
    public const BIZ_ERROR = 1000;

    /**
     * 登录失败
     */
    public const LOGIN_FAILED = 1001;

    /**
     * 账号已禁用
     */
    public const ACCOUNT_DISABLED = 1002;
}
