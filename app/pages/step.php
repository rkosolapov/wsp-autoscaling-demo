<h4><?php echo $title; ?></h4>
<p>Resources to consume: <?php echo implode(',', array_keys($loadOptions)); ?></p>
<p>Please set the following autoscaling options: <?php echo $stepOptionsDescription; ?> </p>

<form role='form' method='get' action='index.php'>
  <input type='hidden' name='action' value='<?php echo $nextStep; ?>'/>

  <?php 
    foreach($loadOptions as $k=>$v) {
        echo "<input type='hidden' name='loadOptions[$k]' value='$v'/>";
    }
  ?>

  <button type="submit" name='button' value='next' class="btn btn-primary">Go!</button>
</form>

<?php

