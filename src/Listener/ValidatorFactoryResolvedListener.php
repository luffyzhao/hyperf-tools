<?php

namespace LHyperfTools\Listener;

use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\Event\ValidatorFactoryResolved;
use Psr\SimpleCache\CacheInterface;
use Hyperf\Di\Annotation\Inject;

class ValidatorFactoryResolvedListener implements ListenerInterface
{
    /**
     * @Inject
     * @var CacheInterface
     */
    protected CacheInterface $cache;
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
            return $this->cache->get($attribute['key']) === $value;
        });
        // 当创建一个自定义验证规则时，你可能有时候需要为错误信息定义自定义占位符这里扩展了 :foo 占位符
        $validatorFactory->replacer('captcha', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':captcha', $attribute, $message);
        });
    }
}