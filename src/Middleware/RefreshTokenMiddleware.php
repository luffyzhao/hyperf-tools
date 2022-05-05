<?php

namespace LHyperfTools\Middleware;

use Exception;
use Hyperf\Contract\ContainerInterface;
use HyperfExt\Jwt\Contracts\ManagerInterface;
use HyperfExt\Jwt\Exceptions\TokenExpiredException;
use HyperfExt\Jwt\JwtFactory;
use LHyperfTools\Constants\HttpCode;
use LHyperfTools\Traits\ApiResponseTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\Di\Annotation\Inject;

class RefreshTokenMiddleware implements MiddlewareInterface
{
    use ApiResponseTrait;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var ManagerInterface
     */
    private $manager;

    /**
     * @var JwtFactory
     */
    private $jwtFactory;

    public function __construct(ContainerInterface $container, JwtFactory $jwtFactory)
    {
        $this->container = $container;
        $this->jwtFactory = $jwtFactory;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \HyperfExt\Jwt\Exceptions\JwtException
     * @throws \HyperfExt\Jwt\Exceptions\TokenBlacklistedException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $jwt = $this->jwtFactory->make();

        try {
            $jwt->checkOrFail();
        } catch (Exception $exception) {
            if (! $exception instanceof TokenExpiredException) {
                return $this->setHttpCode(HttpCode::UNPROCESSABLE_ENTITY)->fail($exception->getMessage());
            }
            try {
                $token = $jwt->getToken();

                // 刷新token
                $new_token = $jwt->getManager()->refresh($token);

                // 解析token载荷信息
                $payload = $jwt->getManager()->decode($token, false, true);

                // 旧token加入黑名单
                $jwt->getManager()->getBlacklist()->add($payload);

                if(!empty($payload->get('guard'))){
                    // 一次性登录，保证此次请求畅通
                    auth($payload->get('guard') )->onceUsingId($payload->get('sub'));
                }else{
                    throw new Exception('刷新失败！');
                }


                return $handler->handle($request)->withHeader('authorization', $new_token)->withHeader('authorization_type', 'bearer');
            } catch (Exception $exception) {
                return $this->setHttpCode(HttpCode::UNPROCESSABLE_ENTITY)->fail($exception->getMessage());
            }
        }

        return $handler->handle($request);
    }
}