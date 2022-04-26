<?php

namespace LHyperfTools\Command;

use Hyperf\Command\Command;
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
            'name' => $this->input->getArgument('name')
        ]);

        if($this->makeServiceQuestion()){
            $this->call('gen:service', [
                'name' => $this->input->getArgument('name')
            ]);
        }
    }

    /**
     * @return false
     */
    protected function makeServiceQuestion(): bool
    {
        $question = new Question('测试对错', 'yes/no');
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
     * @return array[]
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::OPTIONAL, '这里是对这个参数的解释']
        ];
    }
}