<?php
  require_once("config.php");

  header('Content-Type: application/json');
  $output = array();
  $results = array();

  if (isset($_GET['levels'])) {
    $instrumental = 0;
    $novel = 0;

    $results['levels'] = array();
    foreach ($_GET['levels'] as $level => $leveldata) {
      $results['levels'][$level] = array();
      $results['levels'][$level]['pickups'] = array();

      $results['levels'][$level]['pickups']['star'] = intval(($leveldata['pickups']['star']));
      $results['levels'][$level]['pickups']['button'] = intval(($leveldata['pickups']['button']));
      $results['levels'][$level]['pickups']['moon'] = intval(($leveldata['pickups']['moon']));
      $results['levels'][$level]['pickups']['bow'] = intval(($leveldata['pickups']['bow']));

      $results['levels'][$level]['instrumental'] = intval(($leveldata['instrumental']));
      $results['levels'][$level]['novel'] = intval(($leveldata['novel']));

      $instrumental += $results['levels'][$level]['instrumental'];
      $novel += $results['levels'][$level]['novel'];
    }
  }

  if (isset($_GET['age'])
    && isset($_GET['gender'])
    && isset($_GET['levels'])
    && isset($_GET['starttime'])
    && isset($_GET['endtime'])
    && isset($_GET['path']) && ($_GET['path'] == "1" || $_GET['path'] == "2")
    && isset($_GET['code'])
    ) {
	  $results['code'] = $_GET['code'];
	  $results['age'] = intval($_GET['age']);
	  $results['gender'] = ($_GET['gender'] === "male" ? "male" : "female");
	  $results['instrumental'] = $instrumental;
	  $results['starttime'] = round($_GET['starttime']);
	  $results['endtime'] = round($_GET['endtime']);
	  $results['novel'] = $novel;
	  $results['timestamp'] = time();
	  $results['path'] = intval($_GET['path']);
	  $results['ip'] = $_SERVER['REMOTE_ADDR'];
	  $results['proxy'] = (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : "");

	  $output['success'] = true;
	  if (isset($_GET['debug'])) {
		$output['results'] = $results;
	  }
	  
	  $file = file_get_contents(FILE_RESULTS . ".json");
	  if ($file === false) {
		$file = "[]";
	  }

	  $data = json_decode($file);
	  $data[] = $results;
	  file_put_contents(FILE_RESULTS . ".json", json_encode($data));
  }
  else {
    $output['success'] = false;
    $output['error'] = "invalid submission";
  }

  echo json_encode($output);
?>