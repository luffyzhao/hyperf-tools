<?php
namespace LHyperfTools\Repositories;

use Psr\Container\ContainerInterface;
use Hyperf\DbConnection\Model\Model;

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