<?php session_start(); ?>
<?php if ($_SESSION['logged'] === 0 || !isset($_SESSION['logged'])) {
  header('Location: https://b000313/auth/login');
} ?>
<!DOCTYPE html>
<html>
<head>
  <title>Node::Add</title>
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
    <form class="node-detailed" method="POST" action="../models/Add.php">
      <div class="host-detailed">
        <div class="node-alert">
          <h2>Заполните необходимые поля</h2>
        </div>
        <div class="host-row-detailed">
          <div class="host-ceil-name">ID:</div>
          <div class="host-ceil-data">
            <input type="hidden" name="node_add_id" value="<?php echo $hostsItemAdd[0]; ?>"><?php echo $hostsItemAdd[0]; ?>
          </div>
        </div>
        <div class="host-row-detailed">
          <div class="host-ceil-name">NODE NAME:</div>
          <div class="host-ceil-data">
            <input type="text" name="node_add_nodename" value="">
          </div>
        </div>
        <div class="host-row-detailed">
          <div class="host-ceil-name">SCRIPT & DIR NAMES:</div>
          <div class="host-ceil-data">
            <input type="text" name="node_add_hostname" value="" placeholder="example.com">
          </div>
        </div>
        <div class="host-row-detailed">
          <div class="host-ceil-name">IP:</div>
          <div class="host-ceil-data"><input type="text" name="node_add_ip" value="" placeholder=""></div>
        </div>
        <div class="host-row-detailed">
          <div class="host-ceil-name">DIRS:</div>
          <div class="host-ceil-data"><input type="text" name="node_add_dir" value="/etc/ /var/ /home/" placeholder="/etc/ /var/ /home/"></div>
        </div>
        <div class="host-row-detailed hidden">
          <div class="host-ceil-name">STATUS:</div>
          <div class="host-ceil-data">
            <input type="radio" id="inactive" name="node_add_status_on_off" checked="checked" value="0">
            <label for="inactive">Неактивен</label>
            <input type="radio" id="active" name="node_add_status_on_off" value="1">
            <label for="active">Активен</label>
          </div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">ABOUT THIS HOST:</div>
          <div class="host-ceil-data">
            <input type="text" name="node_add_info" value="cpu; mem; avg;">
          </div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">SCRIPT PATH:</div>
          <div class="host-ceil-data"><input type="text" name="node_add_script_path" value="/var/scripts/hbackup/nodes/" placeholder="/var/scripts/hbackup/"></div>
        </div>

        <div class="host-row-detailed">
          <div class="host-ceil-name">CROND PATH:</div>
          <div class="host-ceil-data"><input type="text" name="node_add_script_cron" value="/etc/cron.daily/" placeholder="/etc/cron.daily/"></div>
        </div>

        <div class="host-row-detailed">
          <button class="node-add-submit" type="submit" name="node_add_submit" value="1">Добавить</button>
        </div>
      </div>

    </form>
  </div>
  
  
</body>
</html>