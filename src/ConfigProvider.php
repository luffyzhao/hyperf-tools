<?php
declare(strict_types=1);

namespace LHyperfTools;

use LHyperfTools\Listener\ValidatorFactoryResolvedListener;

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
                    'source' => __DIR__ . '/publish/captcha.php',
                    'destination' => BASE_PATH . '/config/autoload/captcha.php',
                ],
            ],
            'listeners' => [
                ValidatorFactoryResolvedListener::class
            ]
        ];
    }
}