<?php

namespace LHyperfTools\Auth\Driver;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Database\Model\Model;
use LHyperfTools\Auth\Contracts\AuthInterface;
use LHyperfTools\Auth\Contracts\DriverInterface;
use LHyperfTools\Exception\AuthException;


abstract class Driver implements DriverInterface
{
    /**
     * @var AuthInterface
     */
    protected $auth;

    /**
     * @param array $data
     * @throws AuthException
     */
    public function login(array $data)
    {
        // 剔除password
        $password = $data[$this->auth->getPasswordField()];
        unset($data[$this->auth->getPasswordField()]);

        if ($this->auth instanceof Model) {
            $auth = $this->auth->newQuery();
            foreach ($data as $key => $datum) {
                $auth = $auth->where($key, $datum);
            }
            $user = $auth->first();
            if (is_null($user)) {
                $this->auth = null;
                throw new AuthException('用户不存在！');
            }

            if ($user->getAttribute($this->auth->getPasswordField()) !== $user->getPasswordHash($password)) {
                $this->auth = null;
                throw new AuthException('密码不正确！');
            }

            $this->loginForUser($user);

        } else {
            throw new AuthException('The modules not instanceof Model .');
        }
    }


    /**
     * @return AuthInterface
     */
    public function getUser(): AuthInterface
    {
        return $this->auth;
    }

    /**
     * @param AuthInterface $auth
     * @return DriverInterface
     */
    public function loginForUser(AuthInterface $auth): DriverInterface
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     * @param $id
     * @return DriverInterface
     * @throws AuthException
     */
    public function loginForUserId($id): DriverInterface
    {
        $auth = $this->auth->newQuery()->find($id);
        return $this->loginForUser($auth);
    }

    /**
     * @return bool
     */
    public function isLogin(): bool
    {
        if($this->auth !== null){
            return true;
        }
        return false;
    }
}