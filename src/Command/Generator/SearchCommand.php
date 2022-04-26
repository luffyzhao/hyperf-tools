<?php

namespace LHyperfTools\Command\Generator;

use Hyperf\Devtool\Generator\GeneratorCommand;

class SearchCommand extends GeneratorCommand
{

    public function __construct()
    {
        parent::__construct('gen:search');
        $this->setDescription('Create a new search class');
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/search.stub';
    }

    protected function getDefaultNamespace(): string
    {
        return 'App\Search';
    }
}