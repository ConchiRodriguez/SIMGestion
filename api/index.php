<?php

$clientId = "924bb029-03ef-4631-acad-9db854ce545e";
$clientSecret = "yKuJbceShjiHkBkSCnaWawS";
$authority = "https://login.microsoftonline.com";
$authorizeUrl = '/common/oauth2/v2.0/authorize?client_id=%1$s&redirect_uri=%2$s&response_type=code&scope=%3$s';
$tokenUrl = "/common/oauth2/v2.0/token";


$retorno = CallAPI('GET','https://outlook.office.com/api/v2.0/me/messages');

var_dump ($retorno);


// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value
function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}
?>