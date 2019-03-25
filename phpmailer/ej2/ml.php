<?php
echo "HOLA";

require "PHPMailer.php";
echo "HOLA";
require "SMTP.php";
echo "HOLA";
$mail = new PHPMailer\PHPMailer\PHPMailer();
echo "HOLA";

$mail->IsSMTP(); //Establece que el correo para enviar el mensaje a es través de SMTP, Si se establece en true, otras opciones también están disponibles. (verdadero, falso o en blanco)
$mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta o de lo contrario False
$mail->SMTPSecure = 'tls';
$mail->Port = '587';
$mail->Host = 'smtp.serviciodecorreo.es';
$mail->Username = 'soporte@solucions-im.com';
$mail->Password = 'Multi12';
$mail->SMTPDebug = 3;
//Indicamos cual es nuestra dirección de correo y el nombre que
//queremos que vea el usuario que lee nuestro correo
$mail->From = "soporte@solucions-im.com";
$mail->FromName = "soporte@solucions-im.com";
$mail->Sender = "soporte@solucions-im.com";
$mail->Subject = "prueba";
$mail->cuerpo = "esto es una prueba \r \n";
$mail->AddAddress("conchi.rodriguez@multivia.com","prueba");

$body = "Hola, este es un… \r \n";
$mail->IsHTML(true);//Para indicar si el mensaje contiene HTML:
$mail->Body = $body;
$mail->Send();
// Notificamos al usuario del estado del mensaje

if(!$mail->Send()) {
echo "Error: " . $mail->ErrorInfo;
} else {
echo "Mensaje enviado correctamente";
}
?>
