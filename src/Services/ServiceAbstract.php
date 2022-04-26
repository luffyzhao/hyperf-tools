<?php
namespace LHyperfTools\Services;

use Psr\Container\ContainerInterface;
use Hyperf\Di\Annotation\Inject;

abstract class ServiceAbstract
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;
}