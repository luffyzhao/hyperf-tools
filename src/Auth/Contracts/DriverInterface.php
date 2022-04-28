<?php

namespace LHyperfTools\Auth\Contracts;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\StdoutLoggerInterface;

interface DriverInterface
{
    /**
     * @param AuthInterface $auth
     */
    public function __construct(AuthInterface $auth);

    /**
     * 登录
     * @param array $data
     * @return mixed
     */
    public function login(array $data);

    /**
     * @return AuthInterface
     */
    public function getUser(): AuthInterface;


    /**
     * @param AuthInterface $auth
     * @return self
     */
    public function loginForUser(AuthInterface $auth): self;

    /**
     * @param $id
     * @return AuthInterface
     */
    public function loginForUserId($id): self;

    /**
     * 是否登录
     * @return bool
     */
    public function isLogin(): bool;

    /**
     * @param $string
     * @return bool
     */
    public function check($string): bool;

}