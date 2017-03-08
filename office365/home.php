<?php
  session_start();
  require('oauth.php');
  
  $loggedIn = false;
  $redirectUri = 'http://www.solucions-im.net/office365/authorize.php';
?>

<html>
  <head>
    <title>PHP Mail API Tutorial</title>
  </head>
  <body>
    <?php 
      if (!$loggedIn) {
    ?>
      <!-- User not logged in, prompt for login -->
      <p>Please <a href="<?php echo oAuthService::getLoginUrl($redirectUri)?>">sign in</a> with your Office 365 or Outlook.com account.</p>
    <?php
      }
      else {
    ?>
      <!-- User is logged in, do something here -->
      <p>Hello user!</p>
    <?php
      }
    ?>
  </body>
</html>