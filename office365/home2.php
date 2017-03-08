<?php
session_start();
  $loggedIn = false;
?>

<html>
	<head>
		<title>PHP Mail API Tutorial</title>
		<script src="https://secure.aadcdn.microsoftonline-p.com/lib/1.0.12/js/adal.min.js"></script>
		<script>
		  var ADAL = new AuthenticationContext({
			  instance: 'https://login.microsoftonline.com/',
			  tenant: 'common', //COMMON OR YOUR TENANT ID

			  clientId: '924bb029-03ef-4631-acad-9db854ce545e', //This is your client ID
			  redirectUri: 'http://www.solucions-im.net/office365/home2.php', //This is your redirect URI

			  callback: userSignedIn,
			  popUp: true
		  });

		  function signIn() {
			  ADAL.login();
		  }

		  function userSignedIn(err, token) {
			  console.log('userSignedIn called');
			  if (!err) {
				  console.log("token: " + token);
				  showWelcomeMessage();
			  }
			  else {
				  console.error("error: " + err);
			  }
		  }

		  function showWelcomeMessage() {
			  var user = ADAL.getCachedUser();
			  var divWelcome = document.getElementById('WelcomeMessage');
			  divWelcome.innerHTML = "Welcome " + user.profile.name;
		  }

		</script>
	</head>
	<body>
		<button id="SignIn" onclick="signIn()">Sign In</button>
		<h4 id="WelcomeMessage"></h4>
		<?php 
		if (!$loggedIn) {
		?>
		  <!-- User not logged in, prompt for login -->
		  <p>Please <a href="#">sign in</a> with your Office 365 or Outlook.com account.</p>
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