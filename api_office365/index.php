

<?php
$client_id = '924bb029-03ef-4631-acad-9db854ce545e';
$client_secret = 'yKuJbceShjiHkBkSCnaWawS';
$redirect_uri = 'https://www.solucions-im.com/api_office365/oauth-hotmail.php';
$urls_ = 'https://login.live.com/oauth20_authorize.srf?client_id='.$client_id.'&scope=wl.signin%20wl.basic%20wl.emails%20wl.contacts_emails&response_type=code&redirect_uri='.$redirect_uri;
?>
<html>
<head>
<title>Export Hotmail Contacts Using PHP</title>
<link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="css/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container-fluid">
<h1>Export Hotmail Contacts Using PHP</h1>
<div id="login">
<div class="row">
<div class="col-md-12">
<h2 id="h2">Microsoft Sign-in</h2>
</div>
</div>
<div class="row">
<div class="col-md-12">
<a id="signin" href="<?php echo $urls_; ?>">ZZZ</a>
</div>
</div>
</div>
</div>
</body>
</html>

