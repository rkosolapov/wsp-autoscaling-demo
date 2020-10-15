<?php
    require_once('lib/WebHelper.php');
    $webHelper = new WebHelper();

    if ($webHelper->getEnv('WSP_APP_DOMAIN_TO_LOAD', false) === false 
        && $webHelper->getEnv('WSP_APP_MODE', false) === false) {
        echo "<p class='lead'>The application isn't configured, please follow instructions in the README file</p>";
        throw new Exception("The application isn't configured, please follow instructions in the README file");
    }

    if ($webHelper->getEnv('WSP_APP_MODE', false) == 'CONSUMER') {
        echo "<p class='lead'>This instance of the application is intended to consume resources.  Use Loader to make load on it.</p>";
        exit(0);
    }

    $consumer = $webHelper->getEnv('WSP_APP_DOMAIN_TO_LOAD', false);
?>

<p class="lead">It starts Apache Benchmark test on the Consumer (<?= $consumer ?>), every request will consume the chosen resources.</p>
<p>Make sure that:<ul>
  <li>autoscaling options in WSP for the Consumer are set according to your needs
  <li>the app is redeployed after that
</ul></p>

<h4>Choose resources to consume</h4>

<form role='form' method='get' action='index.php'>
  <input type='hidden' name='action' value='<?= WebHelper::ACTION_RUN ?>'/>

  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" name="loadOptions[CPU]" id='c1'>
    <label class="form-check-label" for="c1">CPU</label>
  </div>

  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" name="loadOptions[RAM]" id='c2'>
    <label class="form-check-label" for="c2">RAM</label>
  </div>

  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" name="loadOptions[IO]" id='c3'>
    <label class="form-check-label" for="c3">Disk I/O</label>
  </div>

  <button type="submit" class="btn btn-danger btn-lg">Start!</button>
</form>