<?php 

  // // include '../index.php';
  // include_once ROOT . '/models/Hosts.php';

  /**
   * 
   */
  class Delete
  {
    
    public function delNode($id) {
      
      $db = Db::getConnection();

      $query = 'DELETE FROM hosts WHERE id=' . $id . ';';
      $db->query($query);
    }

    public function scriptDelete($scriptName) {
      $scriptName = $scriptName . '.sh';
      $date = date('_Y_m_d_H_i_s');
      $exec = 'mv ';
      $pathSrc = ' /var/scripts/hbackup/nodes/';
      $pathDest = ' /var/scripts/hbackup/removed/';
      
      $isFile = $pathSrc . $scriptName;

      if (file_exists('/var/scripts/hbackup/nodes/' . $scriptName)) shell_exec($exec . $pathSrc . $scriptName . $pathDest . $scriptName . $date);
    }

  }
