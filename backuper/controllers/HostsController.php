<?php 

include_once ROOT . '/models/Hosts.php';
include_once ROOT . '/models/Edit.php';
include_once ROOT . '/models/Auth.php';
/**
 * 
 */
class HostsController
{
  /*
    ВСЕ ХОСТЫ
  */
  public function actionList() {
    $hostsList = array();
    $hostsList = Hosts::getHostsList();

    

    require_once ROOT . '/views/hosts/index.php';

    return true;
  }


  /*
    ОДИН ХОСТ
  */
  public function actionView($id) {
    
    if ($id) {
      $hostsItem = array();
      $hostsItem = Hosts::getHostsItemById($id);

      require_once ROOT . '/views/hosts/node.php';
    }

    return true;
  }

  public function actionEdit($id) {
    if ($id) {
      $hostsItemEdit = array();
      $hostsItemEdit = Hosts::getHostsItemById($id);

      Edit::actionView($id);

      require_once ROOT . '/views/hosts/edit.php';
    }
    return true;
  }

  public function actionAdd() {
    
    $hostsItemAdd = Hosts::getMaxId();

    require_once ROOT . '/views/hosts/add.php';
    return true;
  }

  public function actionTools() {
    require_once ROOT . '/views/hosts/tools.php';
    return true;
  }

  public function actionToolsEdit() {
    session_start();
    
    $username = $_SESSION['username'];
    $userData = Auth::getUserData($username);

    $test = Edit::updateUserData($userData);

    require_once ROOT . '/views/hosts/tools-edit.php';
    return true;
  }


}