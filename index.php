<?php 
  require_once("config.php");
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8" />
<head>
  <title>Study</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <?php
    // If single play is active and we have an existing cookie
    if (SINGLE_PLAY && isset($_COOKIE['hstudy'])) {
  ?>
  <div id="debrief">
    <h1>Thank you for playing!</h1>
  </div>
  <?php } else { ?>
<div id="confirm">
  <h1 style="text-align: center">Write your participant code here</h1>
  <p style="text-align: center"><input type="text" id="code" /></p>
  <p style="text-align: center"><button>Continue</button></p>
</div>
<div id="ageform" style="display: none">
  <select id="age">
    <option value="" disabled selected>Age</option>
  </select>
  <button id="ageconfirm" />Continue</button>
</div>
<div id="game"></div>
<div id="debrief" style="display: none">
  <h1>Thank you for playing!</h1>
  <p id="message" style="display: none"></p>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/phaser/2.4.4/phaser.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>
  var adminEmail = '<?php echo ADMIN_EMAIL; ?>';
  var singlePlay = <?php echo SINGLE_PLAY ? 'true' : 'false'; ?>;
</script>
<script src="game.js"></script>
<script src="dungeon.js"></script>
<script src="underwater.js"></script>
<script src="meadow.js"></script>
<script src="sky.js"></script>
<?php }?>
</body>
</html>