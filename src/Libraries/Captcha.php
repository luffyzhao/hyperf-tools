<?php

namespace LHyperfTools\Libraries;

use Gregwar\Captcha\CaptchaBuilder;
use Hyperf\Contract\ConfigInterface;
use Psr\SimpleCache\CacheInterface;
use Ramsey\Uuid\Uuid;

class Captcha
{
    protected ConfigInterface $config;
    protected CacheInterface $cache;

    /**
     * @param ConfigInterface $config
     * @param CacheInterface $cache
     */
    public function __construct(ConfigInterface $config, CacheInterface $cache)
    {
        $this->config = $config;
        $this->cache = $cache;
    }

    /**
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function json(){
        $captcha = CaptchaBuilder::create()->build($this->config->get('captcha.width'),$this->config->get('captcha.height'),$this->config->get('captcha.font'),$this->config->get('captcha.fingerprint'));
        $key = $this->config->get('captcha.prefix') . Uuid::uuid1()->toString();
        $this->cache->set($key, $captcha->getPhrase(), $this->config->get('captcha.ttl'));
        return [
            'key' => $key,
            'image' => $captcha->inline()
        ];
    }
}