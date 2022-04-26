<?php

namespace LHyperfTools\Command\Generator;

use Hyperf\Devtool\Generator\GeneratorCommand;

class RepositoryCommand extends GeneratorCommand
{

    public function __construct()
    {
        parent::__construct('gen:repository');
        $this->setDescription('Create a new repository class');
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/repository.stub';
    }

    protected function getDefaultNamespace(): string
    {
        return 'App\\Repositories';
    }
}