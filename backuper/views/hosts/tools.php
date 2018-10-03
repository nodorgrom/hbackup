<?php session_start(); ?>
<?php if ($_SESSION['logged'] === 0 || !isset($_SESSION['logged'])) {
  header('Location: https://b000313/auth/login');
} ?>
<!DOCTYPE html>
<html>
<head>
  <title>hBackup::Tools</title>
  <link rel="icon" type="image/png" href="/template/images/hbackup.ico">
  <link rel="stylesheet" type="text/css" href="/template/styles/main.css">
  <link rel="stylesheet" type="text/css" href="/template/styles/node.css">
</head>
<body>
  <?php 
    // NAVIGATION
    include ROOT . '/views/navigation/nav.html';
  ?>
 
  <div class="wrapper-table">

    <div class="node-detailed">
      <div class="host-detailed">

        <div class="host-row-detailed">       
          <div class="host-ceil-name">USERNAME:</div>
          <div class="host-ceil-data"><p><?php echo $_SESSION['username']; ?></p></div>
        </div>

        <div class="host-row-detailed">       
          <div class="host-ceil-name">PASSWORD:</div>
          <div class="host-ceil-data"><p>*****</p></div>
        </div>

        <div class="host-row-detailed">       
          <div class="host-ceil-name">E-MAIL:</div>
          <div class="host-ceil-data"><p>empty</p></div>
        </div>

        <div class="host-row-detailed">       
          <div class="host-ceil-name">SESSION TIME:</div>
          <div class="host-ceil-data"><p><?php $format = hrTime($_SESSION['idletime']); echo $format; ?></p></div>
        </div>

        <div class="host-row-detailed">
          <a href="/hosts/tools/edit/">
            <input class="node-edit-submit" type="submit" name="node_edit_submit" value="редактировать">
          </a>

          <a href="/auth/login/">
            <input class="node-edit-submit" type="submit" name="node_edit_logout" value="выйти">
          </a>

        </div>





      </div>
    </div>


  </div>


<script type="text/javascript" src="/template/scripts/main.js"></script>
</body>
</html>