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

  echo "timestamp,time taken,cue,cue memorised,gaming frequency,age,gender,star 1,button 1,moon 1,bow 1,instrumental 1,novel 1,star 2,button 2,moon 2,bow 2,instrumental 2,novel 2,star 3,button 3,moon 3,bow 3,instrumental 3,novel 3,star 4,button 4,moon 4,bow 4,instrumental 4,novel 4,total instrumental,total novel,";
  for ($i = 1; $i <= 23; $i++) {
    echo "sir q" . $i . ",";
  }
  echo "sir total,";
  for ($i = 1; $i <= 18; $i++) {
    echo "ocir q" . $i . ",";
  }
  echo "ocir total,";
  for ($i = 1; $i <= 7; $i++) {
    echo "gad7 q" . $i . ",";
  }
  echo "gad7 total,ip,proxy\n";

  if ($data) {
    foreach ($data as $row) {
      echo "" . date("Y-m-d H:i:s", $row['timestamp']) . ",";
      echo round(($row['endtime'] - $row['starttime']) / 1000) . ",";

      // cue
      $cue = $row['path'];
      echo $cue . ",";

      // memorised?
      $memorised = $row['meta']['answers'][1];
      if ($memorised != $cue) {
        echo "0," ;
      }
      else if ($memorised == $cue) {
        echo "1,";
      }
      else {
        echo "-,";
      }
      echo $row['meta']['answers'][0] . ",";
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

      // questionnaires
      if (count($row['sir']['answers']) == 23) {
        foreach ($row['sir']['answers'] as $sir) {
          echo $sir . ",";
        }
      }
      else {
        echo ",,,,,,,,,,,,,,,,,,,,,,,";
      }
      echo $row['sir']['total'] . ",";

      if (count($row['ocir']['answers']) == 18) {
        foreach ($row['ocir']['answers'] as $ocir) {
          echo $ocir . ",";
        }
      }
      else {
        echo ",,,,,,,,,,,,,,,,,,";
      }
      echo $row['ocir']['total'] . ",";

      if (count($row['gad7']['answers']) == 7) {
        foreach ($row['gad7']['answers'] as $gad7) {
          echo $gad7 . ",";
        }
      }
      else {
        echo ",,,,,,,";
      }
      echo $row['gad7']['total'] . ",";

      echo $row['ip'] . ",";
      echo $row['proxy']. "\n";
    }
  }
?>