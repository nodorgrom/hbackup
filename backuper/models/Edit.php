<?php
// include_once '/www/backuper/models/Exec.php';

  /**
    @ редактирование узла
   */
class Edit
{
  
  public function actionView($id){
 
    $id = intval($id);

    if ($id) {
      $db = Db::getConnection();
      $query = 'SELECT hostname, ip, pth_script, pth_exec FROM hosts WHERE id = ' . $id . ';';
      $result = $db->query($query);
      $result->setFetchMode(PDO::FETCH_ASSOC);
      $scriptData = $result->fetch();

      // prrr('', $scriptData);
    }

    if (!empty($_POST)) {

      // prrr('', $_POST);
      $prevPath = $scriptData['pth_script'];
      $prevHostname = $scriptData['hostname'];


      $db = Db::getConnection();

      $postLen = count($_POST);

      $update = prepq($_POST);
      $date = date('Y-m-d H:i:s');
      $d_update = '\'' . $date . '\'';
      $hostname = $update['node_edit_hostname'];
      $nodename = $update['node_edit_nodename'];
      $ip = $update['node_edit_ip'];
      $status = $update['node_edit_status'];
      $dir = $update['node_edit_dir'];
      $host_info = $update['node_edit_host_info'];
      $pth_script = $update['node_edit_script_path'];
      $pth_exec = $update['node_edit_script_cron'];

      $query = 'UPDATE hosts
                 SET
                 d_update= ' . $d_update . ',
                 hostname= ' . $hostname . ' ,
                 nodename= ' . $nodename . ' ,
                 ip= ' . $ip . ' ,
                 status= ' . $status . ',
                 dir= ' . $dir . ',
                 host_info= ' . $host_info . ',
                 pth_script= ' . $pth_script . ',
                 pth_exec= ' . $pth_exec . '
                 WHERE id = ' . $id . ';';

      if ($db->query($query)) {

        // prrr('', $_POST);
        // echo $id;


        $filename = str_replace("'", "", $prevPath) . str_replace("'", "", $prevHostname) . '.sh';
        $scriptToString = file_get_contents($filename);

        function get_string_between($string, $start, $end){
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }
        
        function toCompare($old, $new, $key) {
          // if ($key != "DIRS") {
            $new = str_replace("'", "", $new);
            $old = str_replace("'", "", $old);
            // $new = str_replace(" ", "", $new);
            // $old = str_replace(" ", "", $old);
            // return ($old != $new) ? "NEW: " . $new : "OLD" . $old;
          // }
          
          return array("new" => $new, "old" => $old);
        }

        function replace_in_file($filePath, $oldData, $newData) {
          $result = array('status' => 'Error', 'message' => '');

          if (file_exists($filePath) === TRUE) {
            if (is_writable($filePath)) {
              try {

                $fileContent = file_get_contents($filePath);
                $fileContent = str_replace($oldData, $newData, $fileContent);

                if (file_put_contents($filePath, $fileContent) > 0) {
                  $result['status'] = 'Success';
                } else {

                }
              } catch(Exception $e) {
                $result['message'] = 'Error: ' . $e;
              }
            } else {
              $result['message'] = 'File ' . $filePath . ' is not writable';
            }
          } else {
            $result['message'] = 'File ' . $filePath . ' does not exists'; 
          }
          return $result;
        }


        $fieldsNeedsToScript = 4;
        $firstAnchorForSlicing = array("SSH_IP=\"", "SSH_HOSTNAME='", "SDIR=\"", "DIRS=(");
        $lastAnchorForSlicing = array("\"", "'", "\"", ")");
        $old_data = array($ip, $hostname, $prevPath, $dir);

        while ($fieldsNeedsToScript--) {
          $parsed = get_string_between($scriptToString, $firstAnchorForSlicing[$fieldsNeedsToScript], $lastAnchorForSlicing[$fieldsNeedsToScript]);

          $key = substr($firstAnchorForSlicing[$fieldsNeedsToScript], 0, -2);

          if ($key == "DIRS") {
            $dirs = "";

            $dirsArray = explode(" ", $parsed);
            $lenDirs = count($dirsArray);

            for ($i = 0; $i < $lenDirs; $i++) {
              $dirs .= $dirsArray[$i] . " ";
            }

            $parsed = rtrim($dirs, " ");
          }


          if ($key == "SSH_HOSTNAME") {
            shell_exec("sudo mv " . $prevPath . $prevHostname . ".sh " . str_replace("'", "", $pth_script) . str_replace("'", "", $hostname) . ".sh");
          }

          $compared[] = toCompare($parsed, $old_data[$fieldsNeedsToScript], $key);
        }

        $lenCompared = count($compared);
        $filename = $prevPath . str_replace("'", "", $hostname) . ".sh";


        while ($lenCompared--) {
          $new = $compared[$lenCompared]['new'];
          $old = $compared[$lenCompared]['old'];

          if ($old != $new) {
            replace_in_file($filename, $old, $new);
          }

        }







        header('Location:https://b000313/hosts/' . $id);
      }

    }


    return true;
  }


  public function updateUserData($data) {
    
    $id = $data['id'];
    
    if (!empty($_POST)) {
      $password = '\'' . md5($_POST['user_edit_password']) . '\'';

      $db = Db::getConnection();
      $query = "UPDATE users SET `password` = " . $password . " WHERE `id` = " . $id . ";";
      $db->query($query);

      require_once ROOT . '/views/attentions/success.php';
      header('Refresh:1; url=https://b000313/hosts/tools', true, 303);

    }

  }

}