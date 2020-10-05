<h4><?php echo $title; ?></h4>
<h4>Apache Benchmark</h4>

<?php
    function getHRTime($s) {
        if ($s < 60) return "$s seconds";
        $s = $s/60; return "$s minutes";
    }

    function getMyEnv($name, $default) {
        $res = getenv($name);
        return( $res === false ? $default : $res );
    }

    // https://httpd.apache.org/docs/2.4/programs/ab.html
    $time=getMyEnv('WSP_APP_TIME', 150);
    $users=getMyEnv('WSP_APP_USERS', 50);
    $cmd="ab -c $users -t $time -g /app/gnuplot.tls -e /app/stats.csv '$url'";
    ob_implicit_flush(true);
    ob_end_flush();

    echo '<div class="alert alert-light" role="alert" id="pleaseWait">';
    echo '<div class="progress" style="height: 3px;"><div class="progress-bar" role="progressbar" style="width: 1%;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" id="progressBar"></div></div>';
    echo '<script>
    var percent=1;
    var e = document.getElementById("progressBar");
    function updateProgress() {
        percent++;
        if (percent < 100) {
            e.style.width=percent + "%";
            e.setAttribute("aria-valuenow", percent);
        }
    }
    self.setInterval(updateProgress, '. $time*1000/100 .')
    </script>';
    echo "Running <i>`" . $cmd . "`</i> <br>It will take <b>".getHRTime($time)."</b>, please wait.";
    echo '</div>';
    echo "<p class='lead'>The load pattern: <ul class='lead'><li>$users users simultaneously connects to the app. When the app responds, the user connects again";
    echo "<li>Each query consumes the resources you've chose (" . implode(', ', array_keys($loadOptions)) . ") using the <i>stress-ng</i> utility"; 
    echo "</ul></p>";
    
    
    ob_flush();
    flush();

    echo "<hr class='my-4'><pre>";
    passthru($cmd);
    echo "</pre>";
    echo "<script>var link = document.getElementById('pleaseWait'); link.style.display = 'none'; link.style.visibility = 'hidden';</script>";
?>

<form role='form' method='get' action='index.php'>
  <input type='hidden' name='action' value='<?php echo $nextStep; ?>'/>

  <?php 
    foreach($loadOptions as $k=>$v) {
        echo "<input type='hidden' name='loadOptions[$k]' value='$v'/>";
    }
  ?>

  <button type="submit" name='button' value='next' class="btn btn-primary">OK</button>
</form>