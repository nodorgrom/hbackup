<?php session_start(); ?>
<?php if ($_SESSION['logged'] === 0 || !isset($_SESSION['logged'])) {
  header('Location: https://b000313/auth/login');
} ?>
<!DOCTYPE html>
<html>
<head>
  <title>Node <?php echo $hostsItemEdit['hostname']; ?>::Edit</title>
  <link rel="icon" type="image/png" href="/template/images/hbackup.ico">
  <link rel="stylesheet" type="text/css" href="/template/styles/node.css">
  <link rel="stylesheet" type="text/css" href="/template/styles/main.css">
</head>
<body>

  <?php 
    // NAVIGATION
    include ROOT . '/views/navigation/nav.html';
  ?>

  <div class="wrapper-table">
    <form class="node-detailed" method="POST">
      <div class="host-detailed">
        <div class="host-name-detailed">
          <a href="/hosts/<?php echo $hostsItemEdit['id']; ?>">
            <h2><?php echo $hostsItemEdit['hostname']; ?></h2>
          </a>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">NODENAME:</div>
          <div class="host-ceil-data"><input type="text" name="node_edit_nodename" value="<?php echo $hostsItemEdit['nodename']; ?>"></div>
        </div>


        <div class="host-row-detailed">
          <div class="host-ceil-name">CREATE:</div>
          <div class="host-ceil-data"><?php echo $hostsItemEdit['d_create']; ?></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">LAST UPDATE:</div>
          <div class="host-ceil-data"><?php echo $hostsItemEdit['d_update']; ?></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">CRON STATUS:</div>
          <div class="host-ceil-data <?php echo ($hostsItemEdit['status']) ? "active" : "inactive"; ?>">
            <?php echo ($hostsItemEdit['status']) ? "<p class=\"node-active\">активен</p>" : "<p class=\"node-deactivate\">неактивен</p>"; ?>
            <input type="hidden" name="node_edit_status" value="<?php echo $hostsItemEdit['status']; ?>">
          </div>
        </div>

<!--         <div class="host-row-detailed">
          <div class="host-ceil-name">BACKUP IS:</div>
          <div class="host-ceil-data <?php echo ($hostsItemEdit['active']) ? "active" : "inactive"; ?>">
            <?php echo ($hostsItemEdit['active']) ? "<p class=\"node-active\">активен</p>" : "<p class=\"node-deactivate\">неактивен</p>"; ?>
          </div>
        </div> -->

        <div class="host-row-detailed">
          <div class="host-ceil-name">ALL BACKUPS SIZE:</div>
          <div class="host-ceil-data"><?php echo $hostsItemEdit['amo_backup']; ?></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">SIZE OF BACKUP:</div>
          <div class="host-ceil-data"><?php echo $hostsItemEdit['size_backup']; ?></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">SCRIPT & DIR NAMES::</div>
          <div class="host-ceil-data"><input type="text" name="node_edit_hostname" value="<?php echo $hostsItemEdit['hostname']; ?>"></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name"><p>ABOUT THIS HOST:</p></div>
          <div class="host-ceil-data">
            <textarea class="node-edit-textarea" cols="24" rows="5" name="node_edit_host_info" wrap><?php echo $hostsItemEdit['host_info']; ?></textarea>
          </div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">IP:</div>
          <div class="host-ceil-data"><input type="text" name="node_edit_ip" value="<?php if(empty($hostsItemEdit['ip'])) $hostsItemEdit['ip'] = gethostbyname(htmlspecialchars(trim($hostsItemEdit['hostname']))); echo $hostsItemEdit['ip']; ?>"></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">DIRS:</div>
          <div class="host-ceil-data"><input type="text" name="node_edit_dir" value="<?php echo $hostsItemEdit['dir']; ?>"></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">SCRIPT PATH:</div>
          <div class="host-ceil-data"><input type="text" name="node_edit_script_path" value="<?php echo $hostsItemEdit['pth_script']; ?>"></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">CROND PATH:</div>
          <div class="host-ceil-data"><input type="text" name="node_edit_script_cron" value="<?php echo $hostsItemEdit['pth_exec']; ?>"></div>
        </div>

        <div class="host-row-detailed">
          <input class="node-edit-submit" type="submit" name="node_edit_submit" value="обновить">
        </div>
      </div>

    </form>
  </div>


<!-- <script type="text/javascript" src="/template/scripts/main.js"></script> -->

</body>
</html>