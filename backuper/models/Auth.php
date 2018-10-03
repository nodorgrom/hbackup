<?php 

/**
 * 
 */
class Auth
{
  
  public function getUserData($username) {

    $db = Db::getConnection();
    $result = $db->query('SELECT * FROM users WHERE username = \'' . $username . '\';');
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $user = $result->fetch();

    if ($user) {
      return $user;
    }

    return false;

  }


  /**
    @ добавление нового пользователя
   */
    public function addNewUser($userData) {
      
      $username = strtolower($userData['auth_username']);

      $existsUser = Auth::getUserData($username);



      if (empty($existsUser)) {
        $db = Db::getConnection();

        $username = '\'' . $userData['auth_username'] . '\'';
        $password = '\'' . $userData['auth_password'] . '\'';
        $email = '\'' . $userData['auth_email'] . '\'';


        $query = "INSERT INTO users (id, full_name, email, username, password) 
                    VALUES (''" . ", " . $username . ", " . $email . "," . $username . ", " . "MD5(" . $password . "));";

        $res = $db->query($query);
        if ($res) {

          $db = Db::getConnection();
          $query = "SELECT `id` FROM users WHERE `username` = " . $username . " AND `email` = " . $email . " AND `confirmed` = 0;";
          $result = $db->query($query);
          $result->setFetchMode(PDO::FETCH_ASSOC);
          $newUserID = $result->fetch();

          $id = $newUserID['id'];

          shell_exec('/var/scripts/hbackup/letters/newuser.sh ' . $username . " " . $email . " " . $id);
          header('Location: https://b000313/auth/login');
        }
        
      } else {
        return false;
      }



    }

}