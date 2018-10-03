<?php 

  include '../index.php';
  include_once ROOT . '/models/Hosts.php';
  include_once ROOT . '/models/Delete.php';
  // include_once ROOT . '/models/Edit.php';


  class Exec
  {

    /*
      @ Создание бэкапа
    */    

    public function makeBackup($nodeId, $action, $rootPass = "") {
      // Если первый раз создается узел, то будет запрошен root-password
      $newnode = $this->newnode($nodeId);
      $hostData = $this->scriptData($nodeId);
      $action = ($action == 1) ? "manual" : "auto";

      $fileName = "/var/scripts/hbackup/hosts/hosts";
      $fileContent = file_get_contents($fileName);

      $nodesCount = explode(";", $fileContent);
      unset($nodesCount[count($nodesCount) - 1]);
      $scriptsCount = count($nodesCount);

      shell_exec($hostData['pth_script'] . "starter.sh" . " " . $hostData['pth_script'] . " " . $hostData['hostname'] . " " . $action  . " " . $scriptsCount );

      // echo "Root pass is: " . $rootPass;

      // prrr('newNode: ',$newnode);



      if ($newnode['newnode'] == 1 && (empty($rootPass))) {
        include '../views/templates/pass.html';
      } else {
        // $this->hostsUpdateNew($nodeId);
        $ip = $hostData['ip'];
        // echo "sudo " . $hostData['pth_script'] . "starter.sh" . " " . $hostData['pth_script'] . " " . $hostData['hostname'] . " " . $action;
        // shell_exec("sudo /var/scripts/hbackup/rootinit.sh {$ip} \"{$rootPass}\"");
        shell_exec($hostData['pth_script'] . "starter.sh" . " " . $hostData['pth_script'] . " " . $hostData['hostname'] . " " . $action);
      }


    }


    /*
      @ Обновление статуса узла (новый-старый)
    */
    public function hostsUpdateNew($id) {
      $id = intval($id);

      if ($id) {
        $db = Db::getConnection();
        $query = 'UPDATE hosts SET `new` = 0 WHERE id = ' . $id . '';
        $result = $db->query($query);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->fetch();
      }
    }



    /*
      @ Обновление статуса
    */
    public function hostsUpdateStatus($id, $status) {
      $id = intval($id);
      $status = intval($status);

      if ($id) {
        $db = Db::getConnection();
        $query = 'UPDATE hosts SET status=' . $status . ' WHERE id=' . $id . '; ';
        $db->query($query);
      }
    }

    /*
      @ Получение: hostname, script_path, ip, cron_path
    */
    public function scriptData($id) {
      $id = intval($id);

      if ($id) {
        $db = Db::getConnection();
        $query = 'SELECT hostname, ip, pth_script, pth_exec FROM hosts WHERE id = ' . $id . ';';
        $result = $db->query($query);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $scriptData = $result->fetch();

        // prrr('', $scriptData);

        return $scriptData;
      }
    }

    /*
      @ Создается bash-скрипт файл с данными из Exec::scriptData()
    */
    public function scriptCreate($array) {

      // prrr('',$array);

      if (empty($array['node_add_ip'])) $array['node_add_ip'] = gethostbyname(htmlspecialchars(trim($array['node_add_hostname'])));

      $directories = array();
      $directories = explode(";", $array['node_add_dir']);

      for ($i = 0; $i < count($directories); $i++) {
        $directories[$i] = trim($directories[$i]);
        if(empty($directories[$i])) unset($directories[$i]);
      }

      // prrr('directories: ',$directories);

      if (!file_exists($array['node_add_hostname'])) {
        $array['node_add_hostname'] = strtolower(trim($array['node_add_hostname']));
        $fileName = strtolower(trim($array['node_add_script_path'])) . strtolower(trim($array['node_add_hostname'])) . '.sh';
        $fp = fopen($fileName, "w");
        chmod($fileName, 0777);

        /*
        @ Наполнение скрипта
        */

        $data = "#!/bin/bash\r\n";
        $data .= "case \"\$1\" in\r\n";
        $data .= "\t\"manual\") TOS=\"manual\";;\r\n";
        $data .= "\t\"auto\") TOS=\"auto\";;\r\n";
        $data .= "\t\"*\") TOS=\"auto\";;\r\n";
        $data .= "esac\r\n";
        $data .= "\r\n";
        $data .= "SSH_HOSTNAME=" . "'" . $array['node_add_hostname'] . "'\r\n";
        $data .= "SSH_IP=" . "\"" . $array['node_add_ip'] . "\"\r\n";
        $data .= "SDIR=" . "\"" . $array['node_add_script_path'] . "\"\r\n";
        $data .= "DIRS=(";

        for ($i = 0; $i < count($directories); $i++) { 
          if ($i == count($directories) - 1) {
            // $data .= "[" . $i . "]=/" . $directories[$i];
            $data .= $directories[$i];
          } else {
            $data .= $directories[$i] . " ";
          }
        }

        $data .= ")";

        $data .= "\r\n";
        $data .= "SLOG=" . "\"/var/scripts/hbackup/backuplogs/\$SSH_HOSTNAME.log\"\r\n";
        $data .= "BACKUP_DIR=\"/hbackup/\"\r\n";
        $data .= "DATE_TIME=`date '+%Y-%m-%d %H:%M:%S'`\r\n";
        $data .= "DATE=`date '+%Y-%m-%d'`\r\n";
        $data .= "\r\n";
        $data .= "source /var/scripts/hbackup/source/functions\r\n";
        $data .= "\r\n";
        $data .= "exec >> \$SLOG 2>&1\r\n";
        $data .= "\r\n";
        $data .= "echo \"START \${TOS^^} BACKUP\" >> \$SLOG\r\n";
        $data .= "hbackup \"\${DIRS[@]}\"\r\n";
        $data .= "echo \"type of script (\$0) is \$TOS\" >> \$SLOG\r\n";
        $data .= "\r\n";
        $data .= "source /var/scripts/hbackup/source/exec\r\n";
        $data .= "\r\n";
        $data .= "source /var/scripts/hbackup/source/cleaner.sh\r\n";
        $data .= "\r\n";

        // $data .= "function task_insert {\r\n";
        // $data .= "\tsudo echo \"INSERT INTO tasks (id, hostname, date_start, date_finish, success, failure, unknown, mode) VALUES ('', '\$1', '\$2', '\$3', '\$4','\$5','\$6','\$7');\" | mysql -u root backups\r\n";
        // $data .= "}\r\n";
        // $data .= "\r\n";
        // $data .= "function task_update {\r\n";
        // $data .= "\tsudo echo \"UPDATE tasks SET date_finish='\$1', success='\$2', failure='\$3', unknown='\$4' WHERE hostname='\$5' AND date_start LIKE '\$6%' AND unknown=1;\" | mysql -u root backups\r\n";
        // $data .= "}\r\n";
        // $data .= "\r\n";
        // $data .= "function hbackup {\r\n";
        // $data .= "\r\n";
        // $data .= "\tarr=(\"\$@\")\r\n";
        // $data .= "\tcounter=0\r\n";
        // $data .= "\tarrlen=\${#arr[@]}\r\n";
        // $data .= "\r\n";
        // $data .= "\tfor item in \"\${arr[@]}\"; do\r\n";
        // $data .= "\t\techo \"starting mkdir (\$BACKUP_DIR\$SSH_HOSTNAME/actual\$item)\" >> \$SLOG\r\n";
        // $data .= "\t\tsudo mkdir -p \$BACKUP_DIR\$SSH_HOSTNAME/actual\$item\r\n";
        // $data .= "\t\techo \"mkdir (\$BACKUP_DIR\$SSH_HOSTNAME/actual\$item): \$(result \$?)\" >> \$SLOG\r\n";
        // $data .= "\t\techo \"starting rsync\" >> \$SLOG\r\n";
        // $data .= "\t\tsudo rsync -avzhv -e \"ssh -p 2233\" root@\$SSH_IP:\$item \$BACKUP_DIR\$SSH_HOSTNAME/actual\$item --delete\r\n";
        // $data .= "\t\t\tRESOFRSYNC=\$?\r\n";
        // $data .= "\r\n";
        // $data .= "\t\t\techo \"rsync: \$(result \$?)(\$?)\" >> \$SLOG\r\n";
        // $data .= "\t\t\t\$REPLY\r\n";
        // $data .= "\r\n";
        // $data .= "\t\tif [ \${counter} -eq 0 ]; then\r\n";
        // $data .= "\t\t\ttask_insert \"\$SSH_HOSTNAME\" \"\$DATE_TIME\" \"\" 0 0 1 \"\$TOS\"\r\n";
        // $data .= "\t\tfi\r\n";
        // $data .= "\t\t(( counter++ ))\r\n";
        // $data .= "\tdone\r\n";
        // $data .= "}\r\n";
        // $data .= "\r\n";
        // $data .= "\r\n";
        // $data .= "function result {\r\n";
        // $data .= "\tcase \"\$1\" in\r\n";
        // $data .= "\t\t0) echo \"SUCCESS\";;\r\n";
        // $data .= "\t\t1) echo \"FAILURE\";;\r\n";
        // $data .= "\t\t2) echo \"ERROR\";;\r\n";
        // $data .= "\t\t*) echo \"DEFAULT case: perhaps error\";;\r\n";
        // $data .= "\tesac\r\n";
        // $data .= "}\r\n";
        // $data .= "\r\n";
        // $data .= "function makingDir {\r\n";
        // $data .= "\tsudo mkdir -p \$1\$2/01_this_week \$1\$2/02_two_weeks_ago \$1\$2/trash \$1\$2/actual\r\n";
        // $data .= "\tsudo chmod 777 \$1\$2/{01_this_week,02_two_weeks_ago,trash,actual}\r\n";
        // $data .= "}\r\n";
        // $data .= "\r\n";
        // $data .= "exec >> \$SLOG 2>&1\r\n";
        // $data .= "\r\n";
        // $data .= "echo \"START \${TOS^^} BACKUP\" >> \$SLOG\r\n";
        // $data .= "\r\n";
        // $data .= "hbackup \"\${DIRS[@]}\"\r\n";
        // $data .= "\r\n";
        // $data .= "\r\n";
        // $data .= "echo \"type of script (\$0) is \$TOS\" >> \$SLOG\r\n";
        // $data .= "\r\n";
        // $data .= "if [ \$TOS == \"auto\" ]; then\r\n";
        // $data .= "\r\n";

        // $data .= "\tif [ ! -d \"\$BACKUP_DIR\$SSH_HOSTNAME/01_this_week\" ]; then\r\n";
        // $data .= "\t\t\$(makingDir \$BACKUP_DIR \$SSH_HOSTNAME)\r\n";
        // $data .= "\tfi\r\n";
        // $data .= "\r\n";
        // $data .= "FILE=\$(find \$BACKUP_DIR\$SSH_HOSTNAME/01_this_week/*.tar.gz -mtime +6 -print)\r\n";
        // $data .= "\r\n";
        // $data .= "\tif [ -f \$BACKUP_DIR\$SSH_HOSTNAME/01_this_week/*.tar.gz ] && [ -f \$FILE ]; then\r\n";
        // $data .= "\t\tFILE=\$(ls -A \$BACKUP_DIR\$SSH_HOSTNAME/01_this_week/*.tar.gz | head -n 1)\r\n";
        // $data .= "\t\tsudo mv \$FILE \$BACKUP_DIR\$SSH_HOSTNAME/02_two_weeks_ago/\r\n";
        // $data .= "\t\tsudo tar -cvf \$BACKUP_DIR\$SSH_HOSTNAME/01_this_week/\$SSH_HOSTNAME\"_\"\$DATE.tar \$BACKUP_DIR\$SSH_HOSTNAME/actual/\r\n";
        // $data .= "\t\tsudo gzip -9 \$BACKUP_DIR\$SSH_HOSTNAME/01_this_week/\$SSH_HOSTNAME\"_\"\$DATE.tar\r\n";
        // $data .= "\telif [ ! -f \$BACKUP_DIR\$SSH_HOSTNAME/01_this_week/*.tar.gz ]; then\r\n";
        // $data .= "\t\tsudo tar -cvf \$BACKUP_DIR\$SSH_HOSTNAME/01_this_week/\$SSH_HOSTNAME\"_\"\$DATE.tar \$BACKUP_DIR\$SSH_HOSTNAME/actual/\r\n";
        // $data .= "\t\tsudo gzip -9 \$BACKUP_DIR\$SSH_HOSTNAME/01_this_week/\$SSH_HOSTNAME\"_\"\$DATE.tar\r\n";
        // $data .= "\tfi\r\n";
        // $data .= "\r\n";
        // $data .= "fi\r\n";
        // $data .= "\r\n";
        // $data .= "DATE_FINISH=`date '+%Y-%m-%d %H:%M:%S'`\r\n";
        // $data .= "\r\n";
        // $data .= "if [ \$RESOFRSYNC -gt 0 ]; then\r\n";
        // $data .= "\ttask_update \"\$DATE_FINISH\" 0 1 0 \"\$SSH_HOSTNAME\" \"\$DATE\"\r\n";
        // $data .= "else\r\n";
        // $data .= "\ttask_update \"\$DATE_FINISH\" 1 0 0 \"\$SSH_HOSTNAME\" \"\$DATE\"\r\n";
        // $data .= "fi\r\n";
        // $data .= "\r\n";
        // $data .= "echo \"FINISH \${TOS^^} BACKUP\" >> \$SLOG\r\n";

        fwrite($fp, $data);
        fclose($fp);

        // Удаляет ^M в конце каждой строки только что созданного скрипта
        shell_exec("sed -i -e \"s/\\r\$//\"" . " " . $fileName);
        /*
        @ Конец наполнения скрипта
        */
      }
      return true;
    }

    /*
    @ Добавление в CRON DAILY
    */
    public function cronAdd($nodeId) {
      $cronData = array();
      $cronData = $this->scriptData($nodeId);

      // prrr('', $cronData);

      $fileName = trim($cronData['pth_script']) . "../hosts/hosts";
      $fp = fopen($fileName, "a");

      $data = trim($cronData['hostname']) . ";";

      fwrite($fp, $data);
      fclose($fp);
    }

    /*
    @ Удаление из CRON DAILY
    */
    public function cronDel($nodeId) {
      $cronData = array();
      $cronData = $this->scriptData($nodeId);

      /*
      @ [pth_script] => /var/scripts/hbackup/
      @ [pth_exec] => /etc/cron.daily/
      */
      $pth_hosts = trim($cronData['pth_script']) . "../hosts/hosts";
      $fileName = $pth_hosts;
      $fr = file_get_contents($fileName);

      $w2replace = trim($cronData['hostname']) . ";";
      $w2put = "";

      $result = str_replace($w2replace, $w2put, $fr);

      file_put_contents($pth_hosts, $result);
    }


    public function orders() {
      $db = Db::getConnection();
      $query = 'SELECT MAX(`order`) as lastorder FROM hosts;';
      $res = $db->query($query);
      $lastorder = $res->fetch();
      return $lastorder;
    }

    public function newnode($id) {
      $id = intval($id);

      $db = Db::getConnection();
      $query = 'SELECT `new` as newnode FROM hosts WHERE id = ' . $id . ';';
      $res = $db->query($query);
      $newnode = $res->fetch();
      return $newnode;
    }

  }

  $execute = new Exec();


  prrr('this is POST: ', $_POST);

  // exit();
  if (isset($_POST['caramba'])) {
    echo 1;
  } 


  (!empty($_POST['node_id'])) ? $nodeId = intval($_POST['node_id']) : $nodeId = intval($_POST['node_add_id']);

  if (isset($_POST['backup'])) {
    $action = $_POST['backup'];
    $execute->makeBackup($nodeId, $action);
  } 

  if (isset($_POST['active'])) {
    $action = $_POST['active'];
    $execute->hostsUpdateStatus($nodeId, $action);
    $execute->cronAdd(intval($_POST['node_id']));
  }

  if (isset($_POST['inactive'])) {
    $action = $_POST['inactive'];
    $execute->hostsUpdateStatus($nodeId, $action);
    $execute->cronDel($nodeId);
  }

  if (isset($_POST['delete'])) {
    $delete = $_POST['delete'];
    $id = $_POST['node_id'];
    $scriptData = $execute->scriptData($id);
    $scriptName = $scriptData['hostname'];
    $execute->cronDel($id);
    Delete::scriptDelete($scriptName);
    Delete::delNode($id);
  }

  // Если первый раз создается узел, то будет запрошен root-password
  if (isset($_POST['passValue']) && !empty($_POST['passValue'])) {
    $rootPass = $_POST['passValue'];
    $action = 1;
    $execute->makeBackup($nodeId, $action, $rootPass);
  }