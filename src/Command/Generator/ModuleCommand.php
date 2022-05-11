<?php

namespace LHyperfTools\Command\Generator;

use Hyperf\Command\Command;
use Hyperf\Translation\FileLoader;
use Hyperf\Utils\Filesystem\Filesystem;
use Hyperf\Utils\Str;
use Symfony\Component\Finder\SplFileInfo;

class ModuleCommand extends Command
{
    public function __construct()
    {
        parent::__construct("gen:module");
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $name = $this->input->getArgument('name');
        if(empty($name)){
            throw new \InvalidArgumentException('name 参数不能为空！');
        }
        $this->executeModel($name);
    }

    /**
     * @throws \Exception
     */
    private function executeModel(string $name)
    {
        $files = $this->getFiles(__DIR__ . '/stubs/Model/');
        /** @var SplFileInfo $file */
        foreach ($files as $file){
            $stub = $this->buildClass($file, $name);
            $path = $file->getPath() . DIRECTORY_SEPARATOR . Str::camel($name). DIRECTORY_SEPARATOR;
            $this->makeDir($path);
            file_put_contents($path . $file->getFilename(), $stub);
        }
    }

    /**
     *
     * @param SplFileInfo $file
     * @param string $name
     * @return array|string
     */
    protected function buildClass(SplFileInfo $file, string $name): array|string
    {
        $stub = $file->getContents();
        $stub = $this->replaceClass($stub, $name);
        return $this->replaceDatabases($stub, $name);
    }


    /**
     * @param string $path
     * @return array
     */
    private function getFiles(string $path): array
    {
        $filesystem = new Filesystem();
        return $filesystem->files($path);
    }

    /**
     * @param string $stub
     * @param string $name
     * @return string
     */
    private function replaceClass(string $stub, string $name): string
    {
        return str_replace('%MODULE%', Str::camel($name), $stub);
    }

    /**
     * @param string $stub
     * @param string $name
     * @return string
     */
    private function replaceDatabases(string $stub, string $name)
    {
        return str_replace('%SMODULE%', Str::lower($name), $stub);
    }


    /**
     * @param string $path
     * @return bool
     * @throws \Exception
     */
    private function makeDir(string $path)
    {
        if(!file_exists($path)){
            mkdir($path, 0755, true);
        }

        if(!is_writable($path)){
            throw new \Exception(sprintf("%s 目录没有写入权限！", $path));
        }
        return true;
    }
}