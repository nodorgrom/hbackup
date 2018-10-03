<?php 

  include_once '/www/backuper/models/Exec.php';

  /**
    @ добавление
   */
  class Add
  {

    public function addNewNode() {
      $db = Db::getConnection();

      $date = date('Y-m-d H:i:s');
      $d_create = '\'' . $date . '\'';
      $d_update = '\'' . $date . '\'';
      $amo_backup = 'none';
      $size_backup = 'none';


      $last_order = Exec::orders();

      // $_POST['node_add_hostname'] = str_replace(" ", "_", $_POST['node_add_nodename']);

      $res = prepq($_POST);

      $res['node_add_order'] = $last_order[0] + 1;
      $res['node_add_new'] = 1;

      $ip = gethostbyname(htmlspecialchars(trim($_POST['node_add_hostname'])));

      if (empty($_POST['node_add_ip'])) {
        $res['node_add_ip'] = "'" . $ip . "'";
      }

      $query = 'INSERT INTO hosts (
       `order`,
       new,
       d_create,
       d_update,
       hostname,
       nodename,
       ip,
       status,
       active,
       dir,
       amo_backup,
       size_backup,
       host_info,
       pth_script,
       pth_exec
        ) VALUES ( '
         . $res['node_add_order'] . ','
         . $res['node_add_new'] . ','
         . $d_create . ','
         . $d_update . ','
         . $res['node_add_hostname'] . ','
         . $res['node_add_nodename'] . ','
         . $res['node_add_ip'] . ','
         . $res['node_add_status_on_off'] . ','
         . $res['node_add_submit'] . ','
         . $res['node_add_dir'] . ','
         . '\'' . $amo_backup . '\'' . ','
         . '\'' . $size_backup. '\'' . ','
         . $res['node_add_info'] . ','
         . $res['node_add_script_path'] . ','
         . $res['node_add_script_cron'] . ' );';


      // exit($query);

      $result = $db->query($query);


      return true;
    }


    public function maxId() {
      $db = Db::getConnection();

      $query = 'SELECT MAX(id) FROM hosts;';
      $maxId = $db->query($query);
      $result = $maxId->fetch();
      return $result;
    }

  }

  $scriptCreate = $_POST;
  $execute->scriptCreate($scriptCreate);


  Add::addNewNode();
  $maxId = Add::maxId();

  header('Location:https://b000313/hosts/' . $maxId[0]);
  exit();