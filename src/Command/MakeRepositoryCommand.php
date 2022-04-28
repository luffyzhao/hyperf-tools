<?php

namespace LHyperfTools\Command;

use Hyperf\Command\Command;
use Hyperf\Utils\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;

class MakeRepositoryCommand extends Command
{
    public function __construct()
    {
        parent::__construct("make:repository");
    }

    public function handle()
    {
        $name = $this->input->getArgument('name');
        if(empty($name)){
            throw new \InvalidArgumentException('name 参数不能为空！');
        }

        $this->call('gen:repository', [
            'name' => $name
        ]);

        if($this->makeServiceQuestion()){
            $this->call('gen:service', [
                'name' => $name
            ]);
        }


        if($this->makeModelQuestion()){
            $this->call('gen:model', [
                'name' => Str::substr($name, strrpos($name, "\\") + 1)
            ]);
        }
    }

    /**
     * @return false
     */
    protected function makeServiceQuestion(): bool
    {
        $question = new Question('是否对应生成Service?', 'yes/no');
        $a = $this->output->askQuestion($question);
        if (!in_array($a, ['yes', 'no'])) {
            $this->output->warning('请输入 yes 或者 no !!');
            $this->makeServiceQuestion();
        }
        if ($a === 'yes') {
            return true;
        }
        return false;

    }

    /**
     * @return bool
     */
    protected function makeModelQuestion()
    {
        $question = new Question('是否对应生成Model?', 'yes/no');
        $a = $this->output->askQuestion($question);
        if (!in_array($a, ['yes', 'no'])) {
            $this->output->warning('请输入 yes 或者 no !!');
            $this->makeModelQuestion();
        }
        if ($a === 'yes') {
            return true;
        }
        return false;
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