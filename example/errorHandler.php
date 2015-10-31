<?php
/**
 * Created by PhpStorm.
 * User: jamlee
 * Date: 2015/10/31
 * Time: 15:39
 */

use Jamlee\Coroutine\Scheduler;
use Jamlee\Coroutine\SystemCall;

require '../vendor/autoload.php';


function task() {
    try {
        yield SystemCall::killTask(500);
    } catch (Exception $e) {
        echo 'Tried to kill task 500 but failed: ', $e->getMessage(), "\n";
    }
}

$scheduler = new Scheduler;
$scheduler::$debug = true;
$scheduler->newTask(task());
$scheduler->run();