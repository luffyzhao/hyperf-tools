<?php

namespace LHyperfTools\Command\Generator;

use Hyperf\Devtool\Generator\GeneratorCommand;

class ServiceCommand extends GeneratorCommand
{

    public function __construct()
    {
        parent::__construct('gen:service');
        $this->setDescription('Create a new service class');
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/service.stub';
    }

    protected function getDefaultNamespace(): string
    {
        return 'App\\Services';
    }
    
    /**
     * @return string
     */
    protected function getNameInput(){
        return trim($this->input->getArgument('name')) . "Service";
    }
}