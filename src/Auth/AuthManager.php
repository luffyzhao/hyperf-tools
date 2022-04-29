<?php
declare(strict_types=1);

namespace LHyperfTools\Auth;

use Hyperf\Contract\ConfigInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use InvalidArgumentException;
use LHyperfTools\Auth\Contracts\AuthInterface;
use LHyperfTools\Auth\Contracts\DriverInterface;

class AuthManager
{
    /**
     * @var ConfigInterface
     */
    protected $config;
    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @param $name
     * @return DriverInterface
     */
    public function getDriver($name = null): DriverInterface
    {
        if (is_null($name)) {
            $name = $this->config->get("l-auth.default");
        }

        $config = $this->config->get("l-auth.modules.{$name}");

        if (empty($config)) {
            throw new InvalidArgumentException(sprintf('The cache config %s is invalid.', $name));
        }

        $class = new $config['model']();

        if (!($class instanceof AuthInterface)) {
            throw new InvalidArgumentException('The modules not instanceof AuthInterface .');
        }

        $driver = new $config['driver']($class);

        if (!($driver instanceof DriverInterface)) {
            throw new InvalidArgumentException('The driver not instanceof AuthInterface .');
        }


        return $driver;

    }
}