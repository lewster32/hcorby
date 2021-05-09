<?php
  require_once("config.php");

  if ($_REQUEST["p"] !== RESULTS_PASSWORD) {
    header('HTTP/1.0 403 Forbidden');
    die('You are not allowed to access this file.');   
  }
  
  $data = json_decode(file_get_contents(FILE_RESULTS . ".json"), true);

  header('Content-Description: File Transfer');
  header('Content-type: application/octet-stream');
  header('Content-Disposition: attachment; filename="csv-results-' . date("Y-m-d_H-i-s") . '.csv"');
  header('Content-Transfer-Encoding: binary');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Expires: 0');
  header('Pragma: public');

  echo "timestamp,participant code,time taken,cue,age,gender,star 1,button 1,moon 1,bow 1,instrumental 1,novel 1,star 2,button 2,moon 2,bow 2,instrumental 2,novel 2,star 3,button 3,moon 3,bow 3,instrumental 3,novel 3,star 4,button 4,moon 4,bow 4,instrumental 4,novel 4,total instrumental,total novel,ip,proxy\n";

  if ($data) {
    foreach ($data as $row) {
      echo "" . date("Y-m-d H:i:s", $row['timestamp']) . ",";
      echo $row['code'] . ",";
      echo round(($row['endtime'] - $row['starttime']) / 1000) . ",";

      // cue
      $cue = $row['path'];
      echo $cue . ",";

      echo $row['age'] . ",";
      echo $row['gender'] . ",";

      echo $row['levels']['dungeon']['pickups']['star'] . ",";
      echo $row['levels']['dungeon']['pickups']['button'] . ",";
      echo $row['levels']['dungeon']['pickups']['moon'] . ",";
      echo $row['levels']['dungeon']['pickups']['bow'] . ",";
      echo $row['levels']['dungeon']['instrumental'] . ",";
      echo $row['levels']['dungeon']['novel'] . ",";

      echo $row['levels']['underwater']['pickups']['star'] . ",";
      echo $row['levels']['underwater']['pickups']['button'] . ",";
      echo $row['levels']['underwater']['pickups']['moon'] . ",";
      echo $row['levels']['underwater']['pickups']['bow'] . ",";
      echo $row['levels']['underwater']['instrumental'] . ",";
      echo $row['levels']['underwater']['novel'] . ",";

      echo $row['levels']['meadow']['pickups']['star'] . ",";
      echo $row['levels']['meadow']['pickups']['button'] . ",";
      echo $row['levels']['meadow']['pickups']['moon'] . ",";
      echo $row['levels']['meadow']['pickups']['bow'] . ",";
      echo $row['levels']['meadow']['instrumental'] . ",";
      echo $row['levels']['meadow']['novel'] . ",";

      echo $row['levels']['sky']['pickups']['star'] . ",";
      echo $row['levels']['sky']['pickups']['button'] . ",";
      echo $row['levels']['sky']['pickups']['moon'] . ",";
      echo $row['levels']['sky']['pickups']['bow'] . ",";
      echo $row['levels']['sky']['instrumental'] . ",";
      echo $row['levels']['sky']['novel'] . ",";

      echo $row['instrumental'] . ",";
      echo $row['novel'] . ",";

      echo $row['ip'] . ",";
      echo $row['proxy']. "\n";
    }
  }
?>