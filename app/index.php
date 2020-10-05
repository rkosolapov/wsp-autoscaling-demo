<?php header('X-Accel-Buffering: no'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body style='padding: 2em'>  
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<div class="container">
<div class="jumbotron">

<h1 class="display-4">Web Services Platform</h1>
<h3>Autoscaling demo application</h3>
<hr class="my-4">
<?php

function getLoadOptions()
{
    if (empty($_REQUEST['loadOptions'])) {
        throw new Exception('loadOptions are not set');
    }

    return($_REQUEST['loadOptions']);
}

function main() 
{
    //var_dump($_REQUEST);  //var_dump($_SERVER);  // debug

    $action = empty($_REQUEST['action']) ? 'start' : $_REQUEST['action'];

    switch ($action)
    {
        case 'consume':
            $loadOptions = getLoadOptions();

            require_once('lib/StressHelper.php');
            $stress = new StressHelper();
            foreach($loadOptions as $option=>$state) {
                if (empty($state)) continue;
                switch($option) {
                    case StressHelper::CPU:
                        $stress->addOption('--cpu 4');
                    break;
                    case StressHelper::RAM:
                        $stress->addOption('--vm 1 --vm-bytes 512k');
                    break;
                    case StressHelper::IO:
                        $stress->addOption('--io 2');
                    break;
                    default:
                        throw new Exception("Unknown loadOption '$option'");
                }
            }
            if ($stress->run() !== 0) throw new Exception('Stress execution failed');
        break;
        
        case 'start':
            include('pages/start.php');
        break;

        case 'step1':
            $loadOptions = getLoadOptions();
            $title = '';
            $nextStep = 'step1run';
            $stepOptionsDescription = '';
            include('pages/step.php');
        break;            

        case 'step1run':
            $loadOptions = getLoadOptions();
            $title = '';
            $nextStep = 'start';
            $url = $_SERVER['HTTP_HOST'] . "/index.php?action=consume";
            foreach ($loadOptions as $k=>$v) $url .= "&loadOptions[$k]=$v";
            include('pages/stepRun.php');
        break;

        default:
            return;
    }
}

main();

?>

</div>
</div>

</body>
</html>

