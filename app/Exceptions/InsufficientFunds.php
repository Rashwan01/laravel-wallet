<?php

namespace Theamostafa\Wallet\Exceptions;

use Exception;
use League\CommonMark\Exception\LogicException;

class InsufficientFunds extends Exception {
    public function render($request) {
        throw  new LogicException($this->getMessage());
    }
}
