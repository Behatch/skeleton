<?php error_reporting(E_ALL); ?>

You have sent a <?php print $_SERVER['REQUEST_METHOD']; ?> request.

<?php if(sizeof($_REQUEST) == 0): ?>
  <br />No parameter received.
<?php else: ?>
  <br /><?php print sizeof($_REQUEST); ?> parameter(s) received.
  <?php foreach($_REQUEST as $key => $value): ?>
    <br /><?php print $key ?> : <?php print $value; ?>
  <?php endforeach; ?>
<?php endif; ?>

<?php $body = file_get_contents('php://input'); ?>
<?php if($body == null): ?>
  <br />No body received.
<?php else: ?>
  <br />Body : <?php print $body; ?>
<?php endif; ?>