<?php
  // error reporting level
  error_reporting(0);

  // the timezone you're operating in
  date_default_timezone_set('Europe/London');

  // the password you will use to access the results
  define("RESULTS_PASSWORD", "DTpgxXAXx8W3nPSh");

  // the name of the files to store the results in (minus the extension)
  define("FILE_RESULTS", "PGW9M5h2gPnmn52fbfzfu63e");
  define("FILE_EMAILS", "ggkLGwfrxUrHaYb3SWgU8SxY");
    
  // set the email of the person who should be contacted in the event of any problems
  define("ADMIN_EMAIL", "lew@rotates.org");

  // if set to true, a cookie will be set on the player's computer once their results
  // are submitted which will prevent them playing the game again
  define("SINGLE_PLAY", false);
?>