<?php header('X-Accel-Buffering: no'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Autoscaling demo application</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body style='padding: 2em'>  
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<div class="container">
<div class="jumbotron">

<h1 class="display-4">Web Services Platform</h1>
<h3>Autoscaling demo application<?php
    require_once('lib/WebHelper.php');
    $webHelper = new WebHelper(); 
    $mode = $webHelper->getEnv('WSP_APP_MODE', false);
    if ($mode) echo ", $mode mode";
?> </h3>

<hr class="my-4">
<?php

function main() 
{
    require_once('lib/WebHelper.php');
    $webHelper = new WebHelper();

    if ($webHelper->getEnv('WSP_DEBUG', false)) {
        error_log('$_REQUEST: ' . print_r($_REQUEST, true) . '; $_SERVER: ' . print_r($_SERVER, true) . '; $_ENV: ' . print_r($_ENV, true));
    }

    switch ($webHelper->getAction())
    {
        case WebHelper::ACTION_CONSUME:
            include('pages/consume.php');
        break;
        
        case WebHelper::ACTION_START:
            include('pages/start.php');
        break;          

        case WebHelper::ACTION_RUN:
            include('pages/run.php');
        break;

        default:
            return;
    }
}

main();

?>

</div>
</div>

<pre>
<?php print(file_get_contents('.build.json')); ?>
</pre>

</body>
</html>

