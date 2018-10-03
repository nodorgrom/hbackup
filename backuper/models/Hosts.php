<?php 
/**
 * 
 */
class Hosts
{
  /*
    @ Возвращает один хост по id
    @ param integer id
  */
    public static function getHostsItemById($id) {
      // запрос к БД
      $id = intval($id);

      if ($id) {
        $db = Db::getConnection();

        $result = $db->query('SELECT * FROM hosts WHERE id = ' . $id);
        // $result->setFetchMode(PDO::FETCH_NUM);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $hostsList = $result->fetch();

        return $hostsList;

      }
    }  

  /*
    @ Возвращает массив из хостов
  */
    public static function getHostsList() {

      $db = Db::getConnection();
      $tasksList = array();
      // $result = $db->query("SELECT * FROM tasks;");
      // $result = $db->query("SELECT t1.* FROM tasks t1 INNER JOIN (SELECT hostname, MAX(date_start) AS date_start FROM tasks GROUP BY hostname) AS max USING (hostname, date_start);");
      // $result = $db->query("SELECT A.hostname, MAX(date_start) date_start, MAX(date_finish) date_finish, (select success from tasks where id = (select MAX(id) from tasks where hostname = A.hostname)) success, (select failure from tasks where id = (select MAX(id) from tasks where hostname = A.hostname)) failure, (select unknown from tasks where id = (select MAX(id) from tasks where hostname = A.hostname)) unknown from hosts A LEFT JOIN tasks B on A.hostname = B.hostname GROUP BY A.hostname;");
      $result = $db->query("SELECT A.hostname, MAX(B.date_start) date_start, MAX(B.date_finish) date_finish, B.success, B.failure, B.unknown from hosts A LEFT JOIN tasks B on A.hostname = B.hostname where B.id = (select MAX(id) from tasks where hostname = A.hostname) GROUP BY A.hostname;");

      $j = 0;
      while ($row = $result->fetch()) {
        $tasksList[$j]['hostname'] = $row['hostname'];
        $tasksList[$j]['date_start'] = $row['date_start'];
        $tasksList[$j]['date_finish'] = $row['date_finish'];
        $tasksList[$j]['success'] = $row['success'];
        $tasksList[$j]['failure'] = $row['failure'];
        $tasksList[$j]['unknown'] = $row['unknown'];
        // $tasksList[$j]['mode'] = $row['mode'];
        $j++;
      }

      $tasksLen = count($tasksList);

      $db = Db::getConnection();

      $hostsList = array();
      $result = $db->query('SELECT * FROM hosts');
      // $result = $db->query("SELECT distinct t1.id, t1.hostname, t1.nodename, t1.dir, t1.ip, t1.status, t1.last_update, t2.success, t2.failure, t2.unknown FROM hosts t1 LEFT JOIN tasks t2 ON t1.hostname=t2.hostname WHERE t2.date_start LIKE '" . $today . "%' ORDER BY t1.id;");

      $i = 0;
      while ($row = $result->fetch()) {
        $hostsList[$i]['id'] = $row['id'];
        $hostsList[$i]['hostname'] = $row['hostname'];
        $hostsList[$i]['nodename'] = $row['nodename'];
        $hostsList[$i]['dir'] = $row['dir'];
        $hostsList[$i]['ip'] = $row['ip'];
        $hostsList[$i]['status'] = $row['status'];

        $c = $tasksLen;
        while ($c--) {
          if($tasksList[$c]['hostname'] == $hostsList[$i]['hostname']) {
            $hostsList[$i]['date_start'] = $tasksList[$c]['date_start'];
            $hostsList[$i]['success'] = $tasksList[$c]['success'];
            $hostsList[$i]['failure'] = $tasksList[$c]['failure'];
            $hostsList[$i]['unknown'] = $tasksList[$c]['unknown'];
            // $hostsList[$i]['mode'] = $tasksList[$c]['mode'];
          }
          
        }


        // $hostsList[$i]['success'] = $row['success'];
        // $hostsList[$i]['failure'] = $row['failure'];
        // $hostsList[$i]['unknown'] = $row['unknown'];


        // if ($row['success'] > 0) {
        //   $hostsList[$i]['last_update'] = $row['success'];
        // } elseif ($row['failure'] > 0) {
        //   $hostsList[$i]['last_update'] = $row['failure'];
        // } else {
        //   $hostsList[$i]['last_update'] = $row['unknown'];
        // }


        $i++;
      }



      // return $tasksList;
      return $hostsList;


    }

    /*
      @ Получение самого старшего ID ( для добавления нового )
    */
    public function getMaxId() {
      $db = Db::getConnection();
      $maxId = intval(0);

      $result = $db->query('SELECT MAX(id) FROM hosts;');
      $result->setFetchMode(PDO::FETCH_NUM);
      $maxId = $result->fetch();

      $maxId[0] += 1;

      return $maxId;
    }


}