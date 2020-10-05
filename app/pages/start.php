<p class="lead">It starts Apache Benchmark test, every request will consume the chosen resources.</p>
<p>Make sure that:<ul>
  <li>autoscaling options in WSP are set according to your needs
  <li>the app is redeployed after that.
</ul></p>

<?php require_once('lib/WebHelper.php'); ?>

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