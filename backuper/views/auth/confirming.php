<!DOCTYPE html>
<html lang="en">
<head>
  <title>hBackup::Подтверждение авторизации</title>
  <link rel="icon" type="image/png" href="/template/images/hbackup.ico">
  <link rel="stylesheet" type="text/css" href="/template/styles/main.css">
  <link rel="stylesheet" type="text/css" href="/template/styles/node.css">
</head> 
<body>
  <div class="wrapper-table">

  <div class="node-detailed">
    <div class="host-detailed">
      <form method="POST">
        <div class="node-alert">
          <h2>Подтверждение регистрации</h2>
          <div class="confirming-user-data">
            <div>Пользователь:&nbsp;<span><?php echo $newUserData['username'] ?></span></div>
            <div>E-mail:&nbsp;<span><?php echo $newUserData['email'] ?></span></div>
          </div>
        </div>

        <div class="host-row-detailed center">
          <input class="node-edit-submit" type="submit" name="user_registration_confirm" value="Подтвердить регистрацию">
          <input class="node-edit-submit" type="submit" name="user_registration_delete" value="Удалить пользователя">
        </div>
      </form>
    </div>
  </div>
</body>
</html>
