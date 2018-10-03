<?php 
include_once ROOT . '/models/Auth.php';
/**
 * 
 */
class AuthController
{
  
  public function actionLogin() {
    session_start();

    if (isset($_SESSION['new_user_email'])) {
      $newUser = $_SESSION['new_user_email'];
    }

    $_SESSION['logged'] = 0;


    if (isset($_SESSION['logged']) && ($_SESSION['logged'] === 0)) {
      foreach ($_SESSION as $key => $value) {
        unset($_SESSION[$key]);
      }
    }

    if (!empty($_POST['login_username']) || !empty($_POST['login_password'])) {
      $username = $_POST['login_username'];
      $password = md5($_POST['login_password']);
    } else {
      $username = NULL;
      $password = NULL;
    }


    $user = Auth::getUserData($username);

    if (!empty($username) && ($username === $user['full_name']) && !isset($_SESSION['logged']) && $user['confirmed'] == 1) {

      if (!empty($password) && ($password === $user['password'])) {
        $_SESSION['username'] = $username;
        $_SESSION['logged'] = 1;
        $_SESSION['timestamp'] = time();
        $_SESSION['idletime'] = $user['idletime'];
        header('Location: https://b000313/hosts/');
      }
    }



    if (isset($_POST['login_registration_submit'])) {
      header('Location: https://b000313/auth/register');
    }

    require_once ROOT . '/views/auth/login.php';
    return true;

  }











  public function actionRegister() {
    session_start();

    if (!empty($_POST['auth_username'])) {
      $username = $_POST['auth_username'];
    }

    if (!empty($_POST['auth_password'])) {
      $password = $_POST['auth_password'];
    }

    if (!empty($_POST['auth_re_password'])) {
      $rePassword = $_POST['auth_re_password'];
    }

    if (!empty($_POST['auth_email'])) {
      $email = $_POST['auth_email'];
    }

    if (!empty($_POST['auth_registration_submit'])) {
      $reg = $_POST['auth_registration_submit'];
    }


    if (!empty($_POST['auth_username']) && !empty($_POST['auth_password']) && !empty($_POST['auth_re_password']) && !empty($_POST['auth_email']) && isset($_POST['auth_registration_submit'])) {
      $_SESSION['new_user_isset'] = 1;
      $_SESSION['new_user_email'] = $_POST['auth_email'];


      Auth::addNewUser($_POST);
      // header('Location: https://b000313/auth/login');
    }



    if (isset($_POST['auth_enter_submit'])) {
      header('Location: https://b000313/auth/login');
    }



    require_once ROOT . '/views/auth/register.php';
    return true;

  }





  public function actionConfirming() {
    session_start();

    $url = $_SERVER['REQUEST_URI'];
    $newUserID = explode('/', $url);

    $ID = $newUserID[count($newUserID) - 1];
    $db = Db::getConnection();
    $query = "SELECT `username`, `email`, `confirmed` FROM users WHERE id = " . $ID . ";";
    $result = $db->query($query);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $newUserData = $result->fetch();


    if ((isset($_SESSION) && $_SESSION['logged'] == 1) && (isset($newUserData) && $newUserData['confirmed'] == 0) && isset($ID)) {

      require_once ROOT . '/views/auth/confirming.php';

      if (!empty($_POST)) {
        if (isset($_POST['user_registration_confirm'])) {
          $newUserConfirm = $_POST['user_registration_confirm'];

          if ($newUserConfirm) {

            $db = Db::getConnection();
            $query = 'UPDATE users SET `confirmed` = 1 WHERE `id` = ' . $ID . '; ';
            $userConfirming = $db->query($query);

            if ($userConfirming) {
              shell_exec('/var/scripts/hbackup/letters/confirmeduser.sh');
              require_once ROOT . '/views/attentions/success.php';
              echo "<div class=\"success self\">Вы будете перенаправлены на главную страницу через 5 секунд</div>";
              header('Refresh:5; url=https://b000313/hosts', true, 303);
            } else {
              require_once ROOT . '/views/attentions/failure.php';
            }
          }
        }

        if (isset($_POST['user_registration_delete'])) {
          $newUserDelete = $_POST['user_registration_delete'];

          if ($newUserDelete) {

            $db = Db::getConnection();
            $query = 'DELETE FROM users WHERE `id` = ' . $ID . ';';

            $userDeleting = $db->query($query);

            if ($userDeleting) {
              require_once ROOT . '/views/attentions/success.php';
              echo "<div class=\"success self\">Вы будете перенаправлены на главную страницу через 5 секунд</div>";
              header('Refresh:5; url=https://b000313/hosts', true, 303);
            } else {
              echo "Пользователь НЕ был удален из базы hBackup. Ошибка!";
              require_once ROOT . '/views/attentions/failure.php';
            }

          }
        }




      }
    } else {
      header('Location: https://b000313/hosts');
    }




  }

}