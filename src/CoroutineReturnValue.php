<?php
/**
 * Created by PhpStorm.
 * User: jamlee
 * Date: 2015/10/31
 * Time: 13:41
 */
namespace Jamlee\Coroutine;

/**
 * Class CoroutineReturnValue
 * wrap variable as object
 * @package Jamlee\Coroutine
 */
class CoroutineReturnValue {
    protected $value;

    public function __construct($value) {
        $this->value = $value;
    }

    public function getValue() {
        return $this->value;
    }
}