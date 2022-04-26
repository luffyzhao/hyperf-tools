<?php
namespace LHyperfTools\Services;

use Hyperf\Contract\ContainerInterface;

abstract class ServiceAbstract
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;
}