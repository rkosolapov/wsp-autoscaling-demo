<?php

require_once('lib/WebHelper.php');
$webHelper = new WebHelper();
$loadOptions = $webHelper->getLoadOptions();

require_once('lib/StressHelper.php');
$stress = new StressHelper();

if ($webHelper->getEnv('WSP_APP_DOMAIN_TO_LOAD', false) || $webHelper->getEnv('WSP_APP_MODE', false) == 'LOADER') {
    echo "<p>This instance of the application is intended to be Loader and should not consume resources.  Use it to to make load on the Consumer.</p>";
    throw new Exception('This is the Loader but you are trying to consume resources');
}

foreach($loadOptions as $option=>$state) {
    if (empty($state)) continue;
    switch($option) {
        case StressHelper::CPU:
            $stress->addOption('--cpu 2');
        break;
        case StressHelper::RAM:
            $stress->addOption('--vm 3 --vm-bytes 512m');
        break;
        case StressHelper::IO:
            $stress->addOption('--io 6');
        break;
        default:
            throw new Exception("Unknown loadOption '$option'");
    }
}
if ($stress->run() !== 0) throw new Exception('Stress execution failed: ' . print_r($stress->getLastRun(), true));

print_r($stress->getLastRun());
