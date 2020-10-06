<?php header('X-Accel-Buffering: no'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body style='padding: 2em'>  
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<div class="container">
<div class="jumbotron">

<h1 class="display-4">Web Services Platform</h1>
<h3>Autoscaling demo application</h3>
<hr class="my-4">
<?php

function main() 
{
    //var_dump($_REQUEST);  //var_dump($_SERVER);  // debug

    require_once('lib/WebHelper.php');
    $webHelper = new WebHelper();

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

</body>
</html>
