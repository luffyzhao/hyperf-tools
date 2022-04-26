<?php
namespace LHyperfTools\Services;

use Psr\Container\ContainerInterface;

abstract class ServiceAbstract
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;
}