<?php session_start(); ?>
<?php if ($_SESSION['logged'] === 0 || !isset($_SESSION['logged'])) {
  header('Location: https://b000313/auth/login');
} ?>
<?php autoLogout($_SESSION); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Hbackup - easy to backup your directories</title>
  <link rel="icon" type="image/png" href="/template/images/hbackup.ico">
  <link rel="stylesheet" type="text/css" href="/template/styles/main.css">
  <link rel="stylesheet" type="text/css" href="/template/styles/node.css">
</head>
<body>
  <div class="page">
    <div class="wrapper">

      <header>
        <?php 
          // NAVIGATION
          include ROOT . '/views/navigation/nav.html';
        ?>
      </header>

      <main>
        <div class="content">

          <div class="host">
            <div class="host-name">Hostname</div>
            <div class="host-row">IP address</div>
            <div class="host-row">Status</div>
            <div class="host-row">Last Backup</div>
            <div class="host-row">Last Backup Date</div>
            <div class="host-row">Edit</div>
          </div>
          
          <?php foreach($hostsList as $hostItem): ?>
          <div class="host">

            <div class="host-name">
              <a href="/hosts/<?php echo $hostItem['id']; ?>"><?php echo $hostItem['nodename']; ?></a>
            </div>

            <div class="host-row">
              <div class="host-ceil-data"><?php echo $hostItem['ip']; ?></div>
            </div>

            <div class="host-row">
              <div class="host-ceil-data <?php echo ($hostItem['status']) ? "active" : "inactive"; ?>">
                <?php echo ($hostItem['status']) ? "Активен" : "Неактивен"; ?>
              </div>
            </div>

            <div class="host-row">
              <div class="host-ceil-data 
                <?php
                  // if (($hostItem['success'] == NULL && $hostItem['failure'] == NULL && $hostItem['unknown'] == NULL) && (!isset($hostItem['success']) || !isset($hostItem['failure']) || !isset($hostItem['unknown']))) {
                  if (!isset($hostItem['success']) || !isset($hostItem['failure']) || !isset($hostItem['unknown'])) {
                    echo "unknown";
                  } elseif ($hostItem['success'] == NULL && $hostItem['failure'] == NULL && $hostItem['unknown'] == NULL) {
                    echo "unknown";
                  } elseif ($hostItem['success'] > 0) {
                    echo "active";
                  } elseif (isset($hostItem['success']) && ($hostItem['unknown'] == 0 || $hostItem['unknown'] == NULL) && ($hostItem['failure'] > 0 || $hostItem['failure'] == NULL)) {
                    echo "inactive";
                  } else {
                    echo "unknown";
                  }
                ?>">
                <?php
                  if ((!isset($hostItem['success'])) || ($hostItem['success'] == NULL && $hostItem['failure'] == NULL && $hostItem['unknown'] == NULL)) {
                    echo "Ожидание";
                  } elseif ($hostItem['success'] > 0) {
                    echo "Успешно";
                  } elseif (($hostItem['unknown'] == 0 || $hostItem['unknown'] == NULL) && ($hostItem['failure'] > 0 || $hostItem['failure'] == NULL)) {
                    echo "Неуспешно";
                  } else {
                    echo "В процессе (или прервано)";
                  }
                ?>
              </div>
            </div>

            <div class="host-row">
              <div class="host-ceil-data <?php 
                if(!isset($hostItem['success']) || !isset($hostItem['failure']) || !isset($hostItem['unknown'])) {
                  echo "unknown";
                } else {
                  echo ($hostItem['success']) ? "info" : "inactive";
                }
              ?>">
                <?php 
                  if (!isset($hostItem['success'])) {
                    echo "Ожидание";
                  } else {
                    echo $hostItem['date_start'];
                  }
                 ?>
              </div>
            </div>

            <div class="host-row">
              <div class="host-more">
                <a href="/hosts/<?php echo $hostItem['id']; ?>">
                  <img src="/template/images/edit.png">
                </a>
              </div>
            </div>

          </div>
          <?php endforeach; ?>

        </div>
        
      </main>


      <footer></footer>
    </div>
  </div>

</body>
</html>