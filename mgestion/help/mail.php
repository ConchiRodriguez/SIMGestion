<?php

if ($option == 900){

$t1012 = "<strong>Modulo de Mailing</strong><br>";
$h1012 = " En este modulo podemos gestionar la comunicaci&oacute;n con nuestros clientes, proveedores y dem&aacute;s personas relacionadas con nuestra empresa a
 trav&eacute;s de correo convencional y electr&oacute;nico. As&iacute; como gestionar tambi&eacute;n la impresi&oacute;n de etiquetas para los sobres.";

$t10121 = "<strong>Administraci&oacute;n</strong><br>";
$h10121 = " Para enviar un e-mail o una carta es preciso su creaci&oacute;n en primer lugar. Para el envio de e-mails, adem&aacute;s, es necesario configurar un
 servidor para el envio de estos";

$t101210 = "<strong>Administraci&oacute; de cartas y e-mails</strong><br>";
$h101210 = " Aqu&Iacute; podemos visualizar, editar y eliminar todas las cartas y e-mails.";

$t101211 = "<strong>Nuevo/Editar Carta y E-mail</strong><br>";
$h101211 = " Para crear una nueva carta o e-mail deberemos elegir en primer lugar si se trata de uno u otro. Despu&eacute;s elegiremos un t&iacute;tulo
 para el documento. En la casilla <em>texto</em> es donde debemos escribir la carta o e-mail que queremos crear. Para darle estilo al
 texto tenemos a la derecha un peque&ntilde;o men&uacute; con las principales opciones. Para hacer un texo en negrita, por ejemplo, debemos clickar
 en [b] y escribir el texto desp&uacute;es, al acabar el texto en negrita debemos clickar en [/b]. Adem&aacute;s disponemos de \"etiquetas\" para la
 edici&oacute;n de cartas o e-mails dirigidos a m&aacute;s de un destinatarios. Estas etiquetas ser&aacute;n substituidas en la carta o e-mail por el dato correspondiente
 de cada uno de los destinatarios, personalizando as&iacute; cada carta o e-mail.
 <br> Una vez escrito el texto hemos de clickar en <em>A&ntilde;adir</em> y ya tendremos el documento disponible y listo para imprimir o enviar.";

$t1012200 = "<strong>Hist&oacute;rico</strong><br>";
$h1012200 = " Consulta de cualquier carta o e-mail enviado a un cliente. Solo es necesario elegir un cliente de la lista y el tipo de
 documento que deseamos consultar. Luego debemos clickar en <em>Buscar</em> y obtendremos una lista con los resultados.";

$t1012100 = "<strong>Selecci&oacute;n</strong><br>";
$h1012100 = " Con el buscador listamos en la pantalla los clientes a los deseamos enviar alg&uacute;n documento. Tambi&eacute;n podemos listar los
 contactos personales les cliente o solo el predeterminado para este. Podemos quitar de la selecci&oacute;n alg&uacute;n cliente en particular desativando
 la casilla activa correspondiente al cliente. Tambi&eacute;n podemos desativar o bien los clientes o bien los contactos con los botones
 <em>Marcar</em> y <em>Desmarcar</em>. Una vez elejidos los clientes deseados clickamos <em>Enviar</em>. En el caso de que deseemos
 enviar un e-mail o carta personal o imprimir una etiqueta de un solo cliente o contacto podemos acceder a trav&eacute;s de los iconos de la derecha.
 Estos envios no necesitan de una edici&oacute;n previa del documento, ya que el texto se escribe en el momento previo al envio o la impresi&oacute;n.";

$t1012110 = "<strong>Envio</strong><br>";
$h1012110 = " Para completar el envio o la impresi&oacute;n de un documento solo debemos elejir cual de ellos queremos, una carta, un e-mail o una
 etiqueta. Y tambi&eacute;n que carta, e-mail o etiqueta queremos imprimir o enviar seleccion&aacute;ndola de la lista.";


$texto = "t".$_GET["text"];
$texto2 = "h".$_GET["text"];
echo "<table cellpadding=\"12\">";
	echo "<tr>";
		echo "<td style=\"text-align: justify\">";
			echo "<br>".$$texto."<br>".$$texto2;
		echo "</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td style=\"text-align:center;\">";
			echo "<input type=button value=\"Cerrar\" onClick=\"javascript:window.close();\">";
		echo "</td>";
	echo "</tr>";
echo "</table>";

}


?>