<?php
declare(strict_types=1);

namespace LHyperfTools;

use LHyperfTools\Command\Generator\ModuleCommand;
use LHyperfTools\Command\Generator\RepositoryCommand;
use LHyperfTools\Command\Generator\SearchCommand;
use LHyperfTools\Command\Generator\ServiceCommand;
use LHyperfTools\Command\MakeRepositoryCommand;
use LHyperfTools\Listener\ValidatorFactoryResolvedListener;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            "commands" => [
                RepositoryCommand::class,
                ServiceCommand::class,
                SearchCommand::class,
                MakeRepositoryCommand::class,
                ModuleCommand::class
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The config for jwt.',
                    'source' => __DIR__ . '/../vendor/hyperf-ext/auth/publish/auth.php',
                    'destination' => BASE_PATH . '/config/autoload/auth.php',
                ],
                [
                    'id' => 'config',
                    'description' => 'The config for auth.',
                    'source' => __DIR__ . '/../vendor/hyperf-ext/jwt/publish/jwt.php',
                    'destination' => BASE_PATH . '/config/autoload/jwt.php',
                ],
                [
                    'id' => 'config',
                    'description' => 'The config for hashing.',
                    'source' => __DIR__ . '/../vendor/hyperf-ext/hashing/publish/hashing.php',
                    'destination' => BASE_PATH . '/config/autoload/hashing.php',
                ], [
                    'id' => 'config',
                    'description' => 'The config for hashing.',
                    'source' => __DIR__ . '/../publish/captcha.php',
                    'destination' => BASE_PATH . '/config/autoload/captcha.php',
                ],
            ],
            'listeners' => [
                ValidatorFactoryResolvedListener::class
            ]
        ];
    }
}