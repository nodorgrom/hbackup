<?php session_start(); ?>
<?php if ($_SESSION['logged'] === 0 || !isset($_SESSION['logged'])) {
  header('Location: https://b000313/auth/login');
} ?>
<!DOCTYPE html>
<html>
<head>
  <title>Node <?php echo $hostsItem['nodename']; ?></title>
  <link rel="icon" type="image/png" href="/template/images/hbackup.ico">
  <link rel="stylesheet" type="text/css" href="/template/styles/main.css">
  <link rel="stylesheet" type="text/css" href="/template/styles/node.css">
</head>
<body>

  <?php 
    // NAVIGATION
    include ROOT . '/views/navigation/nav.html';
  ?>
  <h1 id="title"></h1>
  <hr>
  <div id="text"></div> 
  <div class="wrapper-table">
    <div class="table-handler">
      <form class="node-handlers">
        <input type="button" name="node_backup" value="сделать бэкап">
        <input type="button" name="node_on" value="активировать" <?php echo ($hostsItem['status']) ? "disabled=disabled" : ""?> >
        <input type="button" name="node_off" value="отключить" <?php echo ($hostsItem['status']) ? "" : "disabled=disabled"?>>
        <input type="button" name="node_delete" value="удалить">
      </form>
      <!-- <div class="result"></div> -->
      <!-- <div class="result2"></div> -->
    </div>
    <div class="node-detailed">
      <div class="host-detailed">
        <div class="host-name-detailed">
          <a href="/hosts/<?php echo $hostsItem['id']; ?>">
            <h2><p><?php echo $hostsItem['nodename']; ?></p></h2>
          </a>
        </div>

        <div class="host-row-detailed">       
          <div class="host-ceil-name">NODE ID:</div>
          <div class="host-ceil-data"><p><?php echo $hostsItem['id']; ?></p></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">CREATE:</div>
          <div class="host-ceil-data"><p><?php echo $hostsItem['d_create']; ?></p></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">LAST UPDATE:</div>
          <div class="host-ceil-data"><p><?php echo $hostsItem['d_update']; ?></p></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">CRON STATUS:</div>
          <div class="host-ceil-data data-handler='1'">
            <?php echo ($hostsItem['status']) ? "<p class=\"node-active\">активен</p>" : "<p class=\"node-deactivate\">неактивен</p>"; ?>
            <input type="hidden" name="node_edit_status" value="<?php echo $hostsItem['status']; ?>">
          </div>
        </div>
        <div class="host-row-detailed">
          <div class="host-ceil-name">ALL BACKUPS SIZE:</div>
          <div class="host-ceil-data"><p><?php echo $hostsItem['amo_backup']; ?></p></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">SIZE OF BACKUP:</div>
          <div class="host-ceil-data"><p><?php echo $hostsItem['size_backup']; ?></p></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">SCRIPT & DIR NAMES:</div>
          <div class="host-ceil-data"><p><?php echo $hostsItem['hostname']; ?></p></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">IP:</div>
          <div class="host-ceil-data"><p><?php echo $hostsItem['ip']; ?></p></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">DIRS:</div>
          <div class="host-ceil-data"><p><?php echo $hostsItem['dir']; ?></p></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">SCRIPT PATH:</div>
          <div class="host-ceil-data"><p><?php echo $hostsItem['pth_script']; ?></p></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">CROND PATH:</div>
          <div class="host-ceil-data"><p><?php echo $hostsItem['pth_exec']; ?></p></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name"><p>ABOUT THIS HOST:</p></div>
          <div class="host-ceil-data">

            <table class="node-details">
              <tr class="node-details--title">
                <th>Hostname</th>
                <th>OS</th>
                <th>Memtotal</th>
                <th>MemFree</th>
              </tr>

              <tr class="node-details--data">
                <td>energoservis.com</td>
                <td>CentOS release 6.5 (Final)</td>
                <td>1048576</td>
                <td>925340</td>
              </tr>

              <tr class="node-details--title">
                <th>Filesystem</th>
                <th>Size</th>
                <th>Used</th>
                <th>Avail</th>
                <th>Use%</th>
                <th>Mounted on</th>
              </tr>
              <tr class="node-details--data">
                <td>/dev/sda1</td>
                <td>9.8G</td>
                <td>7.7G</td>
                <td>1.6G</td>
                <td>83%</td>
                <td>/</td>
              </tr>

              <tr class="node-details--data">
                <td>tmpfs</td>
                <td>tmpfs</td>
                <td>tmpfs</td>
                <td>tmpfs</td>
                <td>tmpfs</td>
              </tr>

              <tr class="node-details--data">
                <td>/dev/sdb1</td>
              </tr>

              <tr>
                <td><a href="#" class="node-details--update">Обновить</a></td>
              </tr>
            </table>


          </div>
        </div>

        <div class="host-row-detailed">
          <a href="/hosts/edit/<?php echo $hostsItem['id']; ?>">
            <input class="node-edit-submit" type="submit" name="node_edit_submit" value="Редактировать">
          </a>
        </div>

      </div>
    </div>
  </div>


<script type="text/javascript" src="/template/scripts/main.js"></script>
</body>
</html>