<?php
error_reporting(~E_ALL);

function mail365(){

	//Abre conexión IMAP
	$imap = imap_open ("{outlook.office365.com:993/imap/ssl/novalidate-cert}INBOX", "conchi.rodriguez@solucionsim.onmicrosoft.com", "9501Conchi") or die("No Se Pudo Conectar Al Servidor:" . imap_last_error());
#	$imap = imap_open ("{mail.solucions-im.net:143/imap/notls}INBOX", "proves@solucions-im.net", "Proves15") or die("No Se Pudo Conectar Al Servidor:" . imap_last_error());
	$checar = imap_check($imap);
	// Detalles generales de todos los mensajes del buzón.
	$resultados = imap_fetch_overview($imap,"1:{$checar->Nmsgs}",0);
	foreach ($resultados as $detalles) {
		$destinatario = utf8_decode(imap_utf8($detalles->to));
		$destinatario = str_replace('"','',$destinatario);
		$destinatario = str_replace("'","",$destinatario);
		$uid = $detalles->uid;
		$asunto = utf8_decode(imap_utf8($detalles->subject));
		$remitente = imap_utf8($detalles->from);
		$estructura = imap_fetchstructure($imap,$detalles->msgno);
		$flattenedParts = flattenParts($estructura->parts);
		if ($flattenedParts){
			foreach($flattenedParts as $partNumber => $part) {
				switch($part->type) {
					case 0:
						// the HTML or plain text part of the email
						$message = getPart($imap,$detalles->msgno, $partNumber, $part->encoding);
						// now do something with the message, e.g. render it
						$message = str_replace("</p>","\r\n",$message);
						$message = strip_tags($message,'\r\n');
						$message = str_replace("&nbsp;", "", $message);
						$message = trim($message)."yy";
						break;
					case 1:
						// multi-part headers, can ignore
						break;
					case 2:
						// attached message headers, can ignore
						break;
					case 3: // application
					case 4: // audio
					case 5: // image
						$filetipus = "image/";
					case 6: // video
					case 7: // other
						$filename = getFilenameFromPart($part);
						$filetipus .= $part->subtype;
						$filesize = $part->bytes;
						if($filename) {
							$file = getPart($imap,$detalles->msgno, $partNumber, $part->encoding);
						}
						break;
				}
			}
		} else {
			$message = imap_body($imap, $detalles->msgno)."xx";
		}


		echo $uid."-".$destinatario."-".$asunto."-".$remitente."-".$message."<br>";

	}
}

function getPart($connection, $messageNumber, $partNumber, $encoding) {
	$data = imap_fetchbody($connection, $messageNumber, $partNumber);
	switch($encoding) {
		case 0: return $data; // 7BIT
		case 1: return imap_8bit($data); // 8BIT
		case 2: return imap_binary($data); // BINARY
		case 3: return imap_base64($data); // BASE64
		case 4: return quoted_printable_decode($data); // QUOTED_PRINTABLE
		case 5: return $data; // OTHER
	}
}

function getFilenameFromPart($part) {
	$filename = '';
	if($part->ifdparameters) {
		foreach($part->dparameters as $object) {
			if(strtolower($object->attribute) == 'filename') {
				$filename = $object->value;
			}
		}
	}
	if(!$filename && $part->ifparameters) {
		foreach($part->parameters as $object) {
			if(strtolower($object->attribute) == 'name') {
				$filename = $object->value;
			}
		}
	}
	return $filename;
}

function flattenParts($messageParts, $flattenedParts = array(), $prefix = '', $index = 1, $fullPrefix = true) {
	foreach($messageParts as $part) {
		$flattenedParts[$prefix.$index] = $part;
		if(isset($part->parts)) {
			if($part->type == 2) {
				$flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix.$index.'.', 0, false);
			}
			elseif($fullPrefix) {
				$flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix.$index.'.');
			}
			else {
				$flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix);
			}
			unset($flattenedParts[$prefix.$index]->parts);
		}
		$index++;
	}
	return $flattenedParts;
}

?>