<?php
declare(strict_types=1);

namespace LHyperfTools\Auth;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\StdoutLoggerInterface;
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
     * @var DriverInterface[]
     */
    protected $drivers = [];

    /**
     * @var string
     */
    protected $default = null;

    public function __construct(ConfigInterface $config, StdoutLoggerInterface $logger)
    {
        $this->config = $config;
    }

    /**
     * @param $name
     * @return DriverInterface
     */
    public function getDriver($name = null): DriverInterface
    {
        if(is_null($name)){
            $name = $this->default;
        }

        if (isset($this->drivers[$name]) && $this->drivers[$name] instanceof DriverInterface) {
            return $this->drivers[$name];
        }
        if (is_null($name)) {
            $name = $this->config->get("l-auth.default");
        }
        $config = $this->config->get("l-auth.modules.{$name}");

        if (empty($config)) {
            throw new InvalidArgumentException(sprintf('The cache config %s is invalid.', $name));
        }

        if (!class_exists($config['model'])) {
            throw new InvalidArgumentException('The modules not exists .');
        }

        $class = new $config['model']();

        if (!($class instanceof AuthInterface)) {
            throw new InvalidArgumentException('The modules not instanceof AuthInterface .');
        }

        if (!class_exists($config['driver'])) {
            throw new InvalidArgumentException('The driver not exists .');
        }

        $driver = new $config['driver']($class);
        if (!($driver instanceof DriverInterface)) {
            throw new InvalidArgumentException('The driver not instanceof AuthInterface .');
        }

        $this->drivers[$name] = $driver;
        $this->default = $name;

        return $this->drivers[$name];

    }
}