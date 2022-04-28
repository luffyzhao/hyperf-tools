<?php

namespace LHyperfTools\Auth\Driver;


use Hyperf\Cache\Cache;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Di\Container;
use JsonSerializable;
use LHyperfTools\Auth\Contracts\AuthInterface;
use LHyperfTools\Auth\Contracts\DriverInterface;
use Phper666\JWTAuth\BlackList;
use Phper666\JWTAuth\JWT;
use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;
use Psr\SimpleCache\CacheInterface;
use Hyperf\Utils\ApplicationContext;

class TokenDriver extends Driver
{
    /**
     * @var JWT
     */
    protected $jwt;

    public function __construct(AuthInterface $auth)
    {
        parent::__construct($auth);
        $this->jwt = new JWT(ApplicationContext::getContainer()->get(ContainerInterface::class), new BlackList(ApplicationContext::getContainer()->get(ContainerInterface::class)));
    }

    /**
     * @param array $data
     * @return TokenDriver
     * @throws \LHyperfTools\Exception\AuthException|\Psr\SimpleCache\InvalidArgumentException
     */
    public function login(array $data): DriverInterface
    {
        return parent::login($data);
    }

    /**
     * @return string
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function __toString()
    {
        return (string)$this->jwt->getToken([
            'modules' => get_class($this->auth),
            'id' => $this->auth->getKey()
        ]);
    }


    /**
     * @param $string
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Throwable
     */
    public function check($string): bool
    {
        if (!$this->jwt->checkToken($string)) {
            throw new \Exception("token 格式不正确");
        }

        $obj = $this->jwt->getParserData($string);
        if ($obj['modules'] !== get_class($this->auth)) {
            throw new \Exception("token 不正确");
        }

        $this->loginForUserId($obj['id']);

        return true;
    }
}