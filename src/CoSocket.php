<?php
/**
 * Created by PhpStorm.
 * User: jamlee
 * Date: 2015/10/31
 * Time: 13:45
 */
namespace Jamlee\Coroutine;

class CoSocket {
    protected $socket;

    public function __construct($socket) {
        $this->socket = $socket;
    }

    public function accept() {
        yield SystemCall::waitForRead($this->socket);
        yield SystemCall::retval(new CoSocket(stream_socket_accept($this->socket, 0)));
    }

    public function read($size) {
        yield SystemCall::waitForRead($this->socket);
        yield SystemCall::retval(fread($this->socket, $size));
    }

    public function write($string) {
        yield SystemCall::waitForWrite($this->socket);
        fwrite($this->socket, $string);
    }

    public function close() {
        @fclose($this->socket);
    }
}