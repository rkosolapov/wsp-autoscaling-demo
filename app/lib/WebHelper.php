<?php

class WebHelper
{
    const ACTION_CONSUME='consume';
    const ACTION_START='start';
    const ACTION_RUN='run';
    const ACTION='action';
    const LOAD_OPTIONS='loadOptions';

    public function getLoadOptions()
    {
        return($this->getRequestParam(self::LOAD_OPTIONS));
    }

    public function getAction()
    {
        $action = empty($_REQUEST[self::ACTION]) ? 'start' : $_REQUEST[self::ACTION];
        return($action);
    }

    public function formatSeconds($s) {
        if ($s < 60) return "$s seconds";
        $s = $s/60; return "$s minutes";
    }

    public function getRequestParam($item) {
        if (empty($_REQUEST[$item])) {
            throw new Exception($item . ' are not set');
        }

        return($_REQUEST[$item]);
    }

    public function getEnv($name, $default) {
        $res = getenv($name);
        return( $res === false ? $default : $res );
    }
}