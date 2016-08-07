<?php
  require_once("config.php");

  header('Content-Type: application/json');
  $output = array();
  $results = array();

  if (!function_exists('json_esc')) {
      function json_esc($input, $esc_html = true) {
          $result = '';
          if (!is_string($input)) {
              $input = (string) $input;
          }

          $conv = array("\x08" => '\\b', "\t" => '\\t', "\n" => '\\n', "\f" => '\\f', "\r" => '\\r', '"' => '\\"', "'" => "\\'", '\\' => '\\\\');
          if ($esc_html) {
              $conv['<'] = '\\u003C';
              $conv['>'] = '\\u003E';
          }

          for ($i = 0, $len = strlen($input); $i < $len; $i++) {
              if (isset($conv[$input[$i]])) {
                  $result .= $conv[$input[$i]];
              }
              else if ($input[$i] < ' ') {
                  $result .= sprintf('\\u%04x', ord($input[$i]));
              }
              else {
                  $result .= $input[$i];
              }
          }

          return $result;
      }
  }


  if (isset($_GET['email']) && $_GET['email'] != "") {
    $email = urldecode($_GET['email']);
    $email = trim($email);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $output['success'] = false;
      $output['error'] = "invalid email: " . $email;
    }
    else {
      $results['timestamp'] = time();
      $results['email'] = json_esc($email);
      $results['ip'] = $_SERVER['REMOTE_ADDR'];
      $results['proxy'] = (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : "");

      $output['success'] = true;
      if (isset($_GET['debug'])) {
        $output['results'] = $results;
      }

      $file = file_get_contents(FILE_EMAILS . ".json");
      if ($file === false) {
        $file = "[]";
      }

      $data = json_decode($file);
      $data[] = $results;
      file_put_contents(FILE_EMAILS . ".json", json_encode($data));
    }
  }
  else {
    $output['success'] = false;
    $output['error'] = "no email address specified";
  }

  echo json_encode($output);
?>