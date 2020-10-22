<h4>Apache Benchmark</h4>

<?php
    $WSPPREFIX = 'wsp-stat';
    require_once('lib/WebHelper.php');
    $webHelper = new WebHelper();
    $loadOptions = $webHelper->getLoadOptions();

    $time=$webHelper->getEnv('WSP_APP_TIME', 600);
    $users=$webHelper->getEnv('WSP_APP_USERS', 50);
    $domainToLoad=$webHelper->getEnv('WSP_APP_DOMAIN_TO_LOAD', false);
    
    if ($domainToLoad === false)
        throw new Exception("WSP_APP_DOMAIN_TO_LOAD is not set, can not run ab");

    require_once('lib/AbHelper.php');
    $abHelper = new AbHelper();
    $abHelper->addOption("-c $users");
    $abHelper->addOption("-t $time");
    
    $statFile = tempnam('/app/', $WSPPREFIX);
    chmod($statFile, 0666);
    $abHelper->addOption("-e $statFile");

    if (isset($_SERVER['HTTPS']) &&
        ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
        $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
        $protocol = 'https';
    } else {
        $protocol = 'http';
    }   
    

    $statFileUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . "/" . basename($statFile);

    $url = $domainToLoad . "/index.php?" . WebHelper::ACTION . "=" . WebHelper::ACTION_CONSUME;
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
    <li><?= $users ?> users simultaneously connect to the app. When the app responds, the user connects again
    <li>Each query consumes the resources you've chose (<?php echo implode(', ', array_keys($loadOptions)); ?>) using the <i>stress-ng</i> utility for 1 second
</ul></p>
    
<hr class='my-4'>

<pre>
<?php    
    ob_flush();
    flush();

    error_log('Starting: ' . $abHelper->getCmd());
    $abHelper->passthru();
    error_log('Finished: ' . $abHelper->getCmd());

    ob_flush();
    flush();
?>
</pre>
<script>var link = document.getElementById('pleaseWait'); link.style.display = 'none'; link.style.visibility = 'hidden';</script>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<div id="chartContainer" style="height: 370px; width: 100%; margin-top: 1em; margin-bottom: 1em;"></div>
<script>
function showGraph() {
    var dataPoints = [];
    
    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        exportEnabled: true,
        title:{
            text: "Response time"
        },
        axisY: {
            title: "Response time, ms"
        },
        data: [{
            type: "column",
            toolTipContent: "{x}% of requests have been served in less than {y} ms",
            dataPoints: dataPoints
        }]
    });
    
    $.get("<?= $statFileUrl ?>", getDataPointsFromCSV);
    
    //CSV Format
    //Percent,ResponseTime
    function getDataPointsFromCSV(csv) {
        var csvLines = points = [];
        csvLines = csv.split(/[\r?\n|\r|\n]+/);
        for (var i = 0; i < csvLines.length; i++) {
            if (csvLines[i].length > 0) {
                points = csvLines[i].split(",");
                dataPoints.push({
                    label: points[0],
                    y: parseFloat(points[1])
                });
            }
        }
        chart.render();
    }
    
}
showGraph();
</script>

<form role='form' method='get' action='index.php'>
  <input type='hidden' name='action' value='<?= WebHelper::ACTION_START ?>'/>
  <button type="submit" name='button' value='next' class="btn btn-primary">OK</button>
</form>

<?php exec('find /app/'.$WSPPREFIX.'* -mtime +5 -exec rm {} \;'); ?>