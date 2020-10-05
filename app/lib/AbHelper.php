<?php

require_once('lib/ExecHelper.php');
class AbHelper extends ExecHelper
{
    public function __construct()
    {
        $this->_utility = 'ab';
    }
}