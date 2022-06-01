<?php

use HyperfExt\Auth\Contracts\AuthManagerInterface;
use HyperfExt\Auth\Contracts\GuardInterface;
use HyperfExt\Auth\Contracts\StatefulGuardInterface;
use HyperfExt\Auth\Contracts\StatelessGuardInterface;

if (! function_exists('auth')) {
    /**
     * Auth认证辅助方法
     *
     * @param string|null $guard 守护名称
     *
     * @return GuardInterface|StatefulGuardInterface|StatelessGuardInterface
     */
    function auth(string $guard = 'manage_api')
    {  if (is_null($guard)) $guard = config('auth.default.guard');

        return make(AuthManagerInterface::class)->guard($guard);
    }
}

if(!defined('BASE_PATH')){
    define('BASE_PATH', __DIR__ . '/../../../../');
}