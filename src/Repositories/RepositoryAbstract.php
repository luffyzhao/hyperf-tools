<?php
namespace LHyperfTools\Repositories;

use Hyperf\Contract\ContainerInterface;
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