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
  
  // if the below is set to 1, the game will always display the scarcity cue at the beginning
  // if on the other hand it is set to 2, the game will always show the 'control' intro
  // if left at 0, it will randomly assign each participant with an even distribution
  define("FORCE_PATH", 2);
  
  // set the email of the person who should be contacted in the event of any problems
  define("ADMIN_EMAIL", "lew@rotates.org");
?>