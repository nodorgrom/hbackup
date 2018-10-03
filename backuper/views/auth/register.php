<!DOCTYPE html>
<html>
<head>
  <title>hBackup::Регистрация</title>
  <link rel="icon" type="image/png" href="/template/images/hbackup.ico">
  <link rel="stylesheet" type="text/css" href="/template/styles/main.css">
  <link rel="stylesheet" type="text/css" href="/template/styles/node.css">
</head>
<body>
 
  <div class="wrapper-table">

    <div class="node-detailed">
      <div class="host-detailed">

        <form method="POST">
          <div class="node-alert"><h2>Регистрация нового пользователя</h2></div>

          <div class="host-row-detailed">
            <div class="host-ceil-name">USERNAME:</div>
            <div class="host-ceil-data"><input type="text" name="auth_username" value="<?php if (isset($username)) echo $username; ?>" placeholder="Your username"></div>
          </div>

          <div class="host-row-detailed">
            <div class="host-ceil-name">PASSWORD:</div>
            <div class="host-ceil-data"><input type="password" name="auth_password" value="<?php if (isset($password)) echo $password; ?>" placeholder="Your password"></div>
          </div>

          <div class="host-row-detailed">
            <div class="host-ceil-name">RE-TYPE PASSWORD:</div>
            <div class="host-ceil-data"><input type="password" name="auth_re_password" value="<?php if (isset($rePassword)) echo $rePassword; ?>" placeholder="Re-type your password"></div>
          </div>

          <div class="host-row-detailed">
            <div class="host-ceil-name">E-MAIL:</div>
            <div class="host-ceil-data"><input type="text" name="auth_email" value="<?php if (isset($email)) echo $email; ?>" placeholder="Your e-mail"></div>
          </div>

          <div class="host-row-detailed">
            <a href="/auth/login">
              <input class="node-edit-submit" type="submit" name="auth_registration_submit" value="Регистрация">
            </a>
            <a href="#">
              <input class="node-edit-submit" type="submit" name="auth_enter_submit" value="Вход">
            </a>
          </div>
        </form>
      </div>
    </div>


  </div>


<script type="text/javascript" src="/template/scripts/main.js"></script>
</body>
</html>