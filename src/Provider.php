<?php
namespace LHyperfTools;

class Provider
{
    public function __invoke(): array
    {
        return [
            \LHyperfTools\Command\Generator\RepositoryCommand::class,
            \LHyperfTools\Command\Generator\ServiceCommand::class,
            \LHyperfTools\Command\Generator\SearchCommand::class
        ];
    }
}