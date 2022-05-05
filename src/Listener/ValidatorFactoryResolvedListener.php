<?php

namespace LHyperfTools\Listener;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Logger\LoggerFactory;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\Event\ValidatorFactoryResolved;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Hyperf\Di\Annotation\Inject;

class ValidatorFactoryResolvedListener implements ListenerInterface
{
    /**
     * @var CacheInterface
     */
    protected $cache;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var RequestInterface
     */
    protected $request;

    public function __construct(CacheInterface $cache, StdoutLoggerInterface $logger, RequestInterface $request)
    {
        $this->cache = $cache;
        $this->logger = $logger;
        $this->request = $request;
    }

    public function listen(): array
    {
        return [
            ValidatorFactoryResolved::class,
        ];
    }

    public function process(object $event)
    {
        /**  @var ValidatorFactoryInterface $validatorFactory */
        $validatorFactory = $event->validatorFactory;
        // 注册了 foo 验证器
        $validatorFactory->extend('captcha', function ($attribute, $value, $parameters, $validator) {
            if(!$this->request->has('key')){
                return false;
            }
            return $this->cache->get($this->request->input('key')) === $value;
        });
        // 当创建一个自定义验证规则时，你可能有时候需要为错误信息定义自定义占位符这里扩展了 :foo 占位符
        $validatorFactory->replacer('captcha', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':captcha', $attribute, $message);
        });
    }
}