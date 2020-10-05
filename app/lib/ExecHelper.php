<?php

class LastRunStruct
{
    public $cmd;
    public $output;
    public $errcode;

    public function _construct($cmd, $errcode, $output)
    {
        $this->cmd = $cmd;
        $this->output = $output;
        $this->errcode = errcode;
    }
}

abstract class ExecHelper
{
    protected $_options = [];
    protected $_utility;
    protected $_lastRun;

    public function run()
    {
        $output = [];
        $return = -1;

        if (empty($this->_utility)) throw new Exception('utility is not set');
        
        $cmd = $this->getCmd();

        error_log('Executing ' . $cmd);

        exec($cmd, $output, $return);
        $this->_lastRun = new LastRunStruct($cmd, $return, implode("\n", $output));

        return($return);
    }

    public function passthru()
    {
        passthru($this->getCmd());
    }

    public function addOption($option)
    {
        $this->_options[] = $option;
    }

    public function getCmd() 
    {
        $cmd = $this->_utility . ' ' . implode(' ', $this->_options);
        return($cmd);
    }

    public function getLastRun()
    {
        return ($this->_lastRun);
    }
}