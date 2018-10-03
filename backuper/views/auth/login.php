<!DOCTYPE html>
<html lang="en">
<head>
  <title>hBackup::Авторизация</title>
  <link rel="icon" type="image/png" href="/template/images/hbackup.ico">
  <link rel="stylesheet" type="text/css" href="/template/styles/main.css">
  <link rel="stylesheet" type="text/css" href="/template/styles/node.css">
</head> 
<body>
  <div class="wrapper-table">
    

    <div class="node-detailed">
      <div class="host-detailed">
        <form method="POST">
          <div class="node-alert"><h2>Вход</h2></div>

          <div class="host-row-detailed">
            <div class="host-ceil-name">Login:</div>
            <div class="host-ceil-data"><input type="text" name="login_username" value="<?php echo $username; ?>" placeholder="Login"></div>
          </div>

          <div class="host-row-detailed">
            <div class="host-ceil-name">Password:</div>
            <div class="host-ceil-data"><input type="password" name="login_password" value="" placeholder="Password"></div>
          </div>

          <div class="host-row-detailed">
            <a href="#">
              <input class="node-edit-submit" type="submit" name="login_enter_submit" value="Войти">
            </a>
            <a href="#">
              <input class="node-edit-submit" type="submit" name="login_registration_submit" value="Регистрация">
            </a>
          </div>
        </form>




      </div>
    </div>


    <?php if(isset($newUser) && !empty($newUser)) include_once '/www/backuper/views/attentions/notice.php';?>


  </div>

</body>
</html>