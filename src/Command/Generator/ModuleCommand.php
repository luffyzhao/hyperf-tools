<?php

namespace LHyperfTools\Command\Generator;

use Hyperf\Command\Command;
use Hyperf\Translation\FileLoader;
use Hyperf\Utils\Filesystem\Filesystem;
use Hyperf\Utils\Str;
use Symfony\Component\Console\Input\InputArgument;
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
        if (empty($name)) {
            throw new \InvalidArgumentException('name 参数不能为空！');
        }

        $this->executeFiles('Controller', $name);

        $this->executeFiles('Mail', $name);

        $this->executeFiles('Middleware', $name);

        $this->executeFiles('Model', $name);

        $this->executeFiles('Request', $name);

        $this->executeFiles('Search', $name);

        $this->executeFiles('Services', $name);

        $this->executeFiles('Repositories', $name);

        $this->executeMigration($name);

    }


    private function executeMigration($name){
        $file = __DIR__ . '/stubs/migrations/auth_module_table.stub';
        $stub = $this->buildClass($file, $name);

        $filename = BASE_PATH . '/migrations/' .date('Y_m_d_His') . 'crate_' .  Str::lower($name) . 'auth_module_table.php';

        file_put_contents($filename, $stub);
    }
    /**
     * @param $module
     * @param $name
     * @return void
     * @throws \Exception
     */
    private function executeFiles($module, $name)
    {
        $orPath = __DIR__ . '/stubs/' . Str::studly($module);

        $files = $this->getFiles($orPath);
        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            $stub = $this->buildClass($file, $name);
            $replacePath = BASE_PATH . '/app/' . $module . '/' . Str::studly($name);

            $path = $this->buildPath($file, $orPath, $replacePath);

            $this->makeDir($path);

            file_put_contents($this->buildFilename($file, $path), $stub);
        }
    }

    /**
     * @param SplFileInfo $file
     * @param string $path
     * @param string $replacePath
     * @return string
     */
    private function buildPath(SplFileInfo $file, string $path, string $replacePath)
    {
        $orPath = $file->getPath();
        return Str::replace($path, $replacePath, $orPath);
    }

    /**
     * @param SplFileInfo $file
     * @param string $path
     * @return string
     */
    private function buildFilename(SplFileInfo $file, string $path): string
    {
        return $path . '/' . $file->getBasename('.stub') . ".php";
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
        return $filesystem->allFiles($path);
    }

    /**
     * @param string $stub
     * @param string $name
     * @return string
     */
    private function replaceClass(string $stub, string $name): string
    {
        return str_replace('%MODULE%', Str::studly($name), $stub);
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
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        if (!is_writable($path)) {
            throw new \Exception(sprintf("%s 目录没有写入权限！", $path));
        }
        return true;
    }

    /**
     * @return array[]
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::OPTIONAL, '这里是对这个参数的解释']
        ];
    }
}