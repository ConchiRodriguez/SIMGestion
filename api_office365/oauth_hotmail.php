

<?php
//function for parsing the curl request
session_start();
$client_id = '924bb029-03ef-4631-acad-9db854ce545e';
$client_secret = 'yKuJbceShjiHkBkSCnaWawS';
$redirect_uri = 'https://www.solucions-im.com/api_office365/oauth-hotmail.php';
//$redirect_uri = 'http://locahost/export-hotmail-contacts/oauth-hotmail.php';
$auth_code = $_GET["code"];
$fields=array(
'code'=> urlencode($auth_code),
'client_id'=> urlencode($client_id),
'client_secret'=> urlencode($client_secret),
'redirect_uri'=> urlencode($redirect_uri),
'grant_type'=> urlencode('authorization_code')
);
$post = '';
foreach($fields as $key=>$value) { $post .= $key.'='.$value.'&'; }
$post = rtrim($post,'&');
$curl = curl_init();
curl_setopt($curl,CURLOPT_URL,'https://login.live.com/oauth20_token.srf');
curl_setopt($curl,CURLOPT_POST,5);
curl_setopt($curl,CURLOPT_POSTFIELDS,$post);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,TRUE);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
$result = curl_exec($curl);
curl_close($curl);
$response = json_decode($result);
if(isset($response->access_token)){
$_SESSION['access_token'] = $response->access_token;
$accesstoken = $_SESSION['access_token'];
}
if(isset($_GET['code']))
{
$accesstoken = $_SESSION['access_token'];
}
$url = 'https://apis.live.net/v5.0/me/contacts?access_token='.$accesstoken;
$response = file_get_contents($url);
$response = json_decode($response, true);
$data = $response['data'];
?>

<html>
<head>
<title>Export Hotmail Contacts Using PHP</title>
<link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="css/style.css" rel="stylesheet" type="text/css"/>
<script src="js/logout.js" type="text/javascript"></script>
<meta name="robots" content="noindex, nofollow">
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-43981329-1']);
_gaq.push(['_trackPageview']);
(function () {
var ga = document.createElement('script');
ga.type = 'text/javascript';
ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(ga, s);
})();
</script>
</head>
<body>
<div class="container-fluid">
<h1>Export Hotmail Contacts Using PHP</h1>
<div id="login">
<div id="h2" class="h2 row">
<div class="csv col-md-3"><a href ="http://formget.com/tutorial/export-hotmail-contacts/download.php?<?php echo http_build_query($data); ?>" id="download">HOLA</a></div>
<div class="col-md-6"><h2><span>Hotmail Contacts</span></h2></div>
<div class="col-md-3"><a href ="#" onclick="caller()" id="logout"><img class="img-responsive" src="images/button-power_green.png"></a></div>
</div>
<div class="row">
<div class="col-md-12">
<table cellspacing='0'>
<thead>
<td>Name</td>
<td>Email</td>
</thead>
<?php
foreach ($response['data'] as $emails) {?>
<tr>
<td><?php echo $emails['name']; ?></td>
<td><?php print_r($emails['emails']['preferred']); ?></td>
</tr>
<?php }
?>
</table>
</div>
</div>
</div>
</div>
</body>
</html>

