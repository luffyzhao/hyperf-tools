<?php

namespace LHyperfTools\Contracts;

interface SheetImport
{
    public function getFile(): string;

    public function getStartRow(): int;

    public function getEndRow(): ?int;

    public function getStartColumn(): string;

    public function getEndColumn(): string;

    public function getSheet(): int;

    public function getMap():array;

    public function getCasts():array;
}