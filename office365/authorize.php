<?php
  session_start();
  require_once('oauth.php');
  $auth_code = $_GET['code'];
  $redirectUri = 'http://www.solucions-im.net/office365/authorize.php';

  $tokens = oAuthService::getTokenFromAuthCode($auth_code, $redirectUri);
?>

<p>Access Token: <?php echo $tokens['access_token'] ?></p>