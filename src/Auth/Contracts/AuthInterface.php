<?php
namespace LHyperfTools\Auth\Contracts;

interface AuthInterface
{
    public function getPasswordField():string;

    public function getPasswordHash(string $string): string;
}