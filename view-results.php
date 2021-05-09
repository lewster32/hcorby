<?php
  require_once("config.php");

  if ($_REQUEST["p"] !== RESULTS_PASSWORD) {
    header('HTTP/1.0 403 Forbidden');
    die('You are not allowed to access this file.');   
  }
        
  function get_ratio($d) {
    $count1 = 0;
    $count2 = 0;
    
    foreach ($d as $result) {
      if (!is_invalid($result)) {
        if ($result['path'] == "1") {
          $count1++;
        }
        else if ($result['path'] == "2") {
          $count2++;
        }
      }
    }
    
    return $count1 . ":" . $count2;
  }

  $data = json_decode(file_get_contents(FILE_RESULTS . ".json"), true);
?>
<html>
<head>
  <title>Result data</title>
  <style>
    body, html {
      font-family: sans-serif;
      margin: .66em;
      background-color: #fff;
      color: #444;
    }
    .bugged {
      color: #f00;
    }

    table, tr, td, th {
      border: 0;
    }
    table {
      width: 100%;
      border-top: 1px solid #888;
      border-bottom: 1px solid #888;
    }
    thead th {
      border-bottom: 1px solid #888;
    }
    td, th {
      padding: .66em .33em;
      text-align: center;
    }
    tbody tr:hover {
      background-color: #ffc !important;
    }
    tbody tr:nth-child(odd) {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <p><a href="csv-results.php?p=<?php echo RESULTS_PASSWORD;?>">Download as CSV</a> - <?php echo count($data); ?> completed results</p>
  <table cellpadding="4" cellspacing="0" border="1">
    <thead>
      <tr>
        <th>Timestamp</th>
        <th>Participant Code</th>
        <th>Time taken</th>
        <th>Cue</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Instrumental</th>
        <th>Novel</th>
        <th>IP</th>
      </tr>
    </thead>
    <tbody>
<?php


  if ($data) {
    foreach ($data as $row) {
?>
      <tr>
<?php
      echo "<td>" . date("Y-m-d H:i:s", $row['timestamp']) . "</td>";
      echo "<td>" . $row['code'] . "</td>";
      echo "<td>" . round(($row['endtime'] - $row['starttime']) / 1000) . "</td>";
      echo "<td>" . $row['path'] . "</td>";
      echo "<td>" . $row['age'] . "</td>";
      echo "<td>" . $row['gender'] . "</td>";
      echo "<td>" . $row['instrumental'] . "</td>";
      echo "<td>" . $row['novel'] . "</td>";
      echo "<td>" . $row['ip'] . "</td>";
    }
?>
  </tr>
<?php
  }
?>
</tbody>
</table>
</body>
</html>