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



      <form method="POST">
        <div class="host-row-detailed">
          <div class="host-ceil-name">USERNAME:</div>
          <div class="host-ceil-data"><input type="text" name="user_edit_username" value="<?php echo $_SESSION['username'] ?>" disabled="disabled"></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">PASSWORD:</div>
          <div class="host-ceil-data"><input type="password" name="user_edit_password" value="" placeholder="Change password"></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">E-MAIL:</div>
          <div class="host-ceil-data"><input type="text" name="user_edit_email" value="email"></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">SESSION TIME:</div>
          <div class="host-ceil-data"><input type="text" name="user_edit_idletime" value="<?php echo $_SESSION['idletime'] ?>"></div>
        </div>

        <div class="host-row-detailed">
          <input class="node-edit-submit" type="submit" name="user_edit_submit" value="обновить">
        </div>
      <form>





      </div>
    </div>


  </div>


<script type="text/javascript" src="/template/scripts/main.js"></script>
</body>
</html>