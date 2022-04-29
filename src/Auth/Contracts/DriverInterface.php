<?php

namespace LHyperfTools\Auth\Contracts;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\StdoutLoggerInterface;

interface DriverInterface
{
    /**
     * 登录
     * @param array $data
     */
    public function login(array $data);

    /**
     * @return AuthInterface
     */
    public function getUser(): AuthInterface;


    /**
     * @param AuthInterface $auth
     * @return DriverInterface
     */
    public function loginForUser(AuthInterface $auth): self;

    /**
     * @param $id
     * @return DriverInterface
     */
    public function loginForUserId($id): self;

    /**
     * 是否登录
     * @return bool
     */
    public function isLogin(): bool;

    /**
     * @return bool
     */
    public function check(): bool;

}