<?php 
/*
@ print
*/
function prrr($param="", $data) {
  echo $param;
  echo "<pre>";
  print_r($data);
  echo "</pre>";
}



/*
@ quotes wrapper
*/
function prepq($array) {
  $formatted = array();

  foreach ($array as $key => $value) {
    $data = strtolower(trim($value));
    $formatted[$key] = '\'' . $data . '\'';
  }

  return $formatted;
}


/*
@ auto logout
*/
function autoLogout($sess) {
  if (time() - $sess['timestamp'] > $sess['idletime']) {
    session_destroy();
    session_unset();
  }
}

/*
@ human readable time
*/
function hrTime($time) {
  $result = '';

  if ($time) {
    $result = $time . ' sec';
  }

  return $result;
}