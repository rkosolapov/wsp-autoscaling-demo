<?php

require_once('lib/ExecHelper.php');
class StressHelper extends ExecHelper
{
    const CPU='CPU';
    const RAM='RAM';
    const IO='IO';

    private $_time;

    public function __construct($timeout = '1s')
    {
        $this->_time = $timeout;
        $this->_utility = 'stress-ng';
    }

    public function run()
    {
        $to = '--timeout ' . $this->_time;
        if (empty($this->_options[$to])) $this->addOption($to);
        return(parent::run());
    }

}