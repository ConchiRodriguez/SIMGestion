<?php

include ("twitter_api.php");

function tweetConnect(){
	$settings = array(
		'oauth_access_token' => "518693584-kDupwY3ET4qvUThBFRLNTGVMZwpmu1lqvNyZ3ywB",
		'oauth_access_token_secret' => "KNaf2mYZrkCgGSS43K7sdINxVez2s7JadlLWAu6j447v3",
		'consumer_key' => "qroZzczyoemRODznEfOvJA",
		'consumer_secret' => "n2GZUSrV9yzpq7fzTrTP25DcmuM8f6iX1nepckutqw"
	);

	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
	$getfield = '?screen_name=Solucions_im&count=5';
	$requestMethod = 'GET';

	$twitter = new TwitterAPIExchange($settings);
	$twt = $twitter	->setGetfield($getfield)
					->buildOauth($url, $requestMethod)
					->performRequest();
	return $twt;
}


function tweetSim(){
	$twet = tweetConnect();
	$obj = json_decode($twet);
#	$tweet = var_dump($obj);
	foreach ($obj as $detalles) {
		$fecha=$detalles->created_at;
			list($dia_sem,$mes,$dia,$hora,$franja,$any)=explode(" ",$fecha);
#			List($any,$mes,$dia)=explode("-", $data);
			if ($mes == "Jan") {$mess = "Enero";}
			if ($mes == "Feb") {$mess = "Febrero";}
			if ($mes == "Mar") {$mess = "Marzo";}
			if ($mes == "Apr") {$mess = "Abril";}
			if ($mes == "May") {$mess = "Mayo";}
			if ($mes == "Jun") {$mess = "Junio";}
			if ($mes == "Jul") {$mess = "Julio";}
			if ($mes == "Aug") {$mess = "Agosto";}
			if ($mes == "Sep") {$mess = "Septiembre";}
			if ($mes == "Oct") {$mess = "Octubre";}
			if ($mes == "Nov") {$mess = "Noviembre";}
			if ($mes == "Dec") {$mess = "Diciembre";}
		$texto = $detalles->text;
		foreach ($detalles->entities->urls as $detalls) {
				$url = $detalls->url;
				$url_expand = $detalls->expanded_url;
		}

		$cadena = "<a href=\"".$url_expand."\" target=\"_blank\"><strong>".$url."</strong></a>";
		$texto2 = str_replace($url, $cadena, $texto);
		echo "<tr>";
			echo "<td class=\"news\">".$dia." ".$mess." ".$any." -&nbsp;</td>";
			echo "<td class=\"news2\">".$texto2."</td>";
		echo "</tr>";
	}
}

function tweetSimContacto(){
	$twet = tweetConnect(200);
	$obj = json_decode($twet);
#	$tweet = var_dump($obj);
	echo "<div align=\"left\">";
?>
<a href="https://twitter.com/Solucions_im" class="twitter-follow-button" data-show-count="false" data-lang="es" data-size="normal">Seguir a @Solucions_im</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<?php
	echo "</div><br>";
	echo "<div class=\"social\">";
	foreach ($obj as $detalles) {
		$fecha=$detalles->created_at;
			list($dia_sem,$mes,$dia,$hora,$franja,$any)=explode(" ",$fecha);
#			List($any,$mes,$dia)=explode("-", $data);
			if ($mes == "Jan") {$mess = "Enero";}
			if ($mes == "Feb") {$mess = "Febrero";}
			if ($mes == "Mar") {$mess = "Marzo";}
			if ($mes == "Apr") {$mess = "Abril";}
			if ($mes == "May") {$mess = "Mayo";}
			if ($mes == "Jun") {$mess = "Junio";}
			if ($mes == "Jul") {$mess = "Julio";}
			if ($mes == "Aug") {$mess = "Agosto";}
			if ($mes == "Sep") {$mess = "Septiembre";}
			if ($mes == "Oct") {$mess = "Octubre";}
			if ($mes == "Nov") {$mess = "Noviembre";}
			if ($mes == "Dec") {$mess = "Diciembre";}
		$texto = $detalles->text;
		foreach ($detalles->entities->urls as $detalls) {
				$url = $detalls->url;
				$url_expand = $detalls->expanded_url;
		}
		$icono = $detalles->user->profile_image_url;

		$cadena = "<a href=\"".$url_expand."\" target=\"_blank\"><strong>".$url."</strong></a>";
		$texto2 = str_replace($url, $cadena, $texto); 
			echo "<div style=\"float:left;width:16%;\"><img src=\"".$icono."\" alt=\"logo\"></div>&nbsp;".$dia." ".$mess." ".$any."<br>".$texto2."<br><br><br>";
	}
		echo "</div>";
}
?>
