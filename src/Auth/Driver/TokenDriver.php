<?php

namespace LHyperfTools\Auth\Driver;


use Hyperf\HttpServer\Contract\RequestInterface;
use LHyperfTools\Auth\Contracts\AuthInterface;
use LHyperfTools\Auth\Contracts\DriverInterface;
use Phper666\JWTAuth\JWT;
use Hyperf\Di\Annotation\Inject;


class TokenDriver extends Driver
{
    /**
     * @Inject
     * @var JWT
     */
    protected $jwt;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;


    /**
     * @param AuthInterface $auth
     */
    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param array $data
     * @return \Lcobucci\JWT\Token|string
     * @throws \LHyperfTools\Exception\AuthException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function login(array $data)
    {
        parent::login($data);

        return $this->jwt->getToken([
            'class' => get_class($this->auth),
            'id' => $this->auth->getKey()
        ]);
    }



    /**
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Throwable
     */
    public function check(): bool
    {
        $string = $this->getAuthorizationForRequest();
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

    /**
     * @return string
     */
    protected function getAuthorizationForRequest(): string
    {
        return $this->request->getHeaderLine('authorization');
    }


}