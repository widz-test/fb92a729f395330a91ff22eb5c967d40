<?php

namespace Core\Foundation\Scheduler;

use Cron\CronExpression;

class Scheduler
{
    private $tasks = [];

    /**
     * Add task
     *
     * @param [type] $expression
     * @param callable $task
     * @return void
     */
    public function add($expression, callable $task)
    {
        $this->tasks[] = [
            'expression' => $expression,
            'task' => $task
        ];
    }

    /**
     * Run
     *
     * @return void
     */
    public function run()
    {
        while (true) {
            $currentTime = date('Y-m-d H:i:s');
            foreach ($this->tasks as $task) {
                $cron = CronExpression::factory($task['expression']);
                if ($cron->isDue($currentTime)) {
                    call_user_func($task['task']);
                }
            }
            sleep(60); // Check every minute
        }
    }
}
