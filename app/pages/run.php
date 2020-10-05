<h4>Apache Benchmark</h4>

<?php
    require_once('lib/WebHelper.php');
    $webHelper = new WebHelper();
    $loadOptions = $webHelper->getLoadOptions();

    $time=$webHelper->getEnv('WSP_APP_TIME', 150);
    $users=$webHelper->getEnv('WSP_APP_USERS', 50);

    require_once('lib/AbHelper.php');
    $abHelper = new AbHelper();
    $abHelper->addOption("-c $users");
    $abHelper->addOption("-t $time");
    $abHelper->addOption("-e /app/stats.csv");

    $url = $_SERVER['HTTP_HOST'] . "/index.php?" . WebHelper::ACTION . "=" . WebHelper::ACTION_CONSUME;
    foreach ($loadOptions as $k=>$v) $url .= "&loadOptions[$k]=$v";
    $abHelper->addOption("'$url'");

    $cmd=$abHelper->getCmd();

    ob_implicit_flush(true);
    ob_end_flush();
?>

<div class="alert alert-light" role="alert" id="pleaseWait">
<div class="progress" style="height: 3px;">
<div class="progress-bar" role="progressbar" style="width: 1%;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" id="progressBar"></div>
</div>
<script>
    var percent=1;
    var e = document.getElementById("progressBar");
    function updateProgress() {
        percent++;
        if (percent < 100) {
            e.style.width=percent + "%";
            e.setAttribute("aria-valuenow", percent);
        }
    }
    self.setInterval(updateProgress, <?= $time*1000/100 ?>)
</script>
Running <i>`<?= $cmd ?>`</i> <br>It will take <b><?= $webHelper->formatSeconds($time) ?></b>, please wait.
</div>

<p class='lead'>The load pattern: 
<ul class='lead'>
    <li><?= $users ?> users simultaneously connects to the app. When the app responds, the user connects again
    <li>Each query consumes the resources you've chose (<?php echo implode(', ', array_keys($loadOptions)); ?>) using the <i>stress-ng</i> utility 
</ul></p>
    
<hr class='my-4'>

<pre>
<?php    
    ob_flush();
    flush();

    $abHelper->passthru();

    ob_flush();
    flush();
?>
</pre>
<script>var link = document.getElementById('pleaseWait'); link.style.display = 'none'; link.style.visibility = 'hidden';</script>

<form role='form' method='get' action='index.php'>
  <input type='hidden' name='action' value='<?= WebHelper::ACTION_START ?>'/>
  <button type="submit" name='button' value='next' class="btn btn-primary">OK</button>
</form>