<?php

class StressHelper
{
    const CPU='CPU';
    const RAM='RAM';
    const IO='IO';

    private $_options = [];
    private $_time;

    public function __construct($timeout = '1s')
    {
        $this->_time = $timeout;
    }

    public function run()
    {
        $output = [];
        $return = -1;
        
        $cmd = 'stress-ng ' 
            . implode(' ', $this->_options) 
            . ' --timeout ' 
            . $this->_time;

        var_dump($cmd); //debug

        exec($cmd, $output, $return);
        return($return);
    }

    public function addOption($option)
    {
        $this->_options[] = $option;
    }

}