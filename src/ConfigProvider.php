<?php
declare(strict_types=1);

namespace LHyperfTools;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            "commands" => [
                \LHyperfTools\Command\Generator\RepositoryCommand::class,
                \LHyperfTools\Command\Generator\ServiceCommand::class,
                \LHyperfTools\Command\Generator\SearchCommand::class,
                \LHyperfTools\Command\MakeRepositoryCommand::class
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The config for auth.',
                    'source' => __DIR__ . '/../publish/l-auth.php'
                ],
            ],
        ];
    }
}