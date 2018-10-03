<?php 
/**
 * 
 */
class Db
{

  public static function getConnection() {
    $paramsPath = ROOT . '/config/db_params.php';
    $params = include($paramsPath);


    $db_host = $params['host'];
    $db_name = $params['dbname'];
    $db_username = $params['user'];
    $db_password = $params['pass'];

    $db = new PDO("mysql:dbname=$db_name;host=$db_host", $db_username, $db_password);

    return $db;
  }

}