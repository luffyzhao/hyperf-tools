<?php
namespace LHyperfTools\Services;


use JetBrains\PhpStorm\Pure;

abstract class ServiceAbstract
{
    /**
     * @return static
     */
    #[Pure] public static function service(): static
    {
        return new static();
    }
}