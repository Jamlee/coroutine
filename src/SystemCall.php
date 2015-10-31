<?php
namespace Jamlee\Coroutine;

class SystemCall
{
    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function __invoke(Task $task, Scheduler $scheduler)
    {
        $callback = $this->callback; // Can't call it directly in PHP :/
        return $callback($task, $scheduler);
    }

    public static function getTaskId()
    {
        return new self(function (Task $task, Scheduler $scheduler) {
            $task->setSendValue($task->getTaskId());
            $scheduler->schedule($task);
        });
    }

    public static function killTask($tid)
    {
        return new SystemCall(
            function(Task $task, Scheduler $scheduler) use ($tid) {
                if ($scheduler->killTask($tid)) {
                    $scheduler->schedule($task);
                } else {
                    throw new \InvalidArgumentException('Invalid task ID!');
                }
            }
        );
    }

    public static function newTask(\Generator $coroutine)
    {
        return new SystemCall(
            function (Task $task, Scheduler $scheduler) use ($coroutine) {
                $task->setSendValue($scheduler->newTask($coroutine));
                $scheduler->schedule($task);
            }
        );
    }

    public static function waitForRead($socket)
    {
        return new self(
            function (Task $task, Scheduler $scheduler) use ($socket) {
                $scheduler->waitForRead($socket, $task);
            }
        );
    }

    public static function waitForWrite($socket)
    {
        return new self(
            function (Task $task, Scheduler $scheduler) use ($socket) {
                $scheduler->waitForWrite($socket, $task);
            }
        );
    }

    public static function retval($value) {
        return new CoroutineReturnValue($value);
    }
}