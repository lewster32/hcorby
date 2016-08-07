<?php
  require_once("config.php");

  if ($_REQUEST["p"] !== RESULTS_PASSWORD) {
    header('HTTP/1.0 403 Forbidden');
    die('You are not allowed to access this file.');   
  }

  date_default_timezone_set('Europe/London');
  $data = json_decode(file_get_contents(FILE_EMAILS . ".json"), true);

  header('Content-Description: File Transfer');
  header('Content-type: application/octet-stream');
  header('Content-Disposition: attachment; filename="csv-emails-' . date("Y-m-d_H-i-s") . '.csv"');
  header('Content-Transfer-Encoding: binary');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Expires: 0');
  header('Pragma: public');

  echo "timestamp,email,ip address,proxied ip address\n";

  if ($data) {
    foreach ($data as $row) {
      echo "" . date("Y-m-d H:i:s", $row['timestamp']) . ",";
      echo $row['email'] . ",";
      echo $row['ip'] . ",";
      echo $row['proxy']. "\n";
    }
  }
?>