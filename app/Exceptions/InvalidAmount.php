<?php

namespace Theamostafa\Wallet\Exceptions;

use Exception;
use League\CommonMark\Exception\LogicException;

class InvalidAmount extends Exception {
    public function render($request) {
        throw  new LogicException("Invalid amount");
    }
}
