<?php
require "phpmailer/class.phpmailer.php";

$mail = new PHPMailer;

$mail->ReturnPath = 'soporte@solucions-im.com';
$mail->From = 'soporte@solucions-im.com';
$mail->FromName = 'Soporte';
$mail->Subject  = 'First PHPMailer Message';
$mail->addAddress('conchi.rodriguez@multivia.com', 'Conchi Rodríguez');
$mail->MsgHTML('Provant email des de phpmailer.');
if(!$mail->send()) {
  echo 'Message was not sent.';
  echo 'Mailer error: ' . $mail->ErrorInfo;
} else {
  echo 'Message has been sent.';
}

?>