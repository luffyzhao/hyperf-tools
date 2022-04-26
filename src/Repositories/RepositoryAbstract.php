<?php
namespace LHyperfTools\Repositories;

use Psr\Container\ContainerInterface;
use Hyperf\DbConnection\Model\Model;
use Hyperf\Di\Annotation\Inject;

abstract class RepositoryAbstract
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /** @var  */
    protected $model;
}