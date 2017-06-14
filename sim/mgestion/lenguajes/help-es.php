<?php

if ($option == 800){

$t1001 = "<strong>Modulo de Contenidos</strong><br>";
$h1001 = " En este modulo podemos gestionar los contenidos que queramos que aparezcan en nuestra pagina web o en nuestro programa web. Aqui podemos agregar contenidos,
 es decir, tanto noticias como articulos de interes para nuestros empleados como para nuestros clientes.";

$t10011 = "<strong>Grupos de Contenidos</strong><br>";
$h10011 = " Para crear un grupo de contenido nuevo solo debemos introducir el nombre del grupo en la casilla en blanco y clickar en el boton de <em>nuevo grupo</em>.
 Si adem�s queremos que el contenido del grupo sea visible para los usuarios web deberemos poner la casilla <em>visible</em> en SI.
<br>A la hora de visualizar los grupos en la pantalla general, si hemos puesto un SI en la casilla <em>general</em>, veremos los cinco �ltimos contenidos del grupo.
 Por �ltimo tenemos la casilla <em>articulo</em> que nos indicar� si el contenido del grupo es de noticias o de art�culos.<br>Si son art�culos, la fecha no quedar�
 reflejada en el contenido ya que esta no es de inter�s por ser textos intemporales. Por contra, en una noticia si, ya que es importante saber la fecha del suceso
 de la noticia.";

$t100112 = "<strong>Administraci� de contenidos</strong><br>";
$h100112 = " Aqu� podemos ver todos los grupos existentes y sus contenidos. Podremos tanto eliminar como editar los contenidos de cada grupo. Cuanto editamos un
 contenido podemos asociarle un elemento ya subido con el men� de la derecha. Debemos elegir el elemento que queremos subir en el desplegable y luego clickar en
 <em>incluir elemento</em>; debemos tener cuidado al relizar esta acci�n, ya que si hemos hecho alg�n cambio en el texto y no lo hemos guardado antes, se perder�.";

$t100115 = "<strong>Nuevo/Editar contenido</strong><br>";
$h100115 = " Para mandar un nuevo contenido deberemos elegir una fuente, un grupo, un idioma y un titulo. En la casilla <em>texto</em> es donde debemos escribir el
 articulo o noticia que queremos crear. Para darle estilo al texto tenemos a la derecha un peque�o men� con las principales opciones. Para hacer un texo en negrita,
 por ejemplo, debemos clickar en [b] y escribir el texto desp�es, al acabar el texto en negrita debemos clickar en [/b].
 <br> Una vez escrito el texto hemos de clickar en <em>A�adir</em> y ya tendremos el contenido disponible. Desde la opci�n <em>Contenidos</em>
 podemos editar o borrar el contenido que hemos mandado. Solo debemos modificar cualquier dato y clickar <em>Modificar</em>. Adem�s, aqu� tambi�n podemos a�adir los
 elementos que deseemos al contenido en cuesti�n. Para ello solo necesitamos seleccionarlos en el desplegable y clickar en <em>Incluir Elemento</em>. Despu�s podemos
 visualizar el elemento para asegurarnos que es el deseado, incluirlo directamente en el contenido o eliminarlo.";

$t100130 = "<strong>Fuentes de Contenidos</strong><br>";
$h100130 = " La fuente de un contenido es desde donde obtenemos la informaci�n para el mismo. Para introducir una nueva fuente, solo debemos introducir el nombre en la
 primera casilla de la izquierda y clickar en <em>nueva fuente</em>.
<br> Si lo deseamos, podemos incluir como datos adicionales la direcci�n web de la fuente y un banner. Los banners deben guardarse en la carpeta llamada PICS/BANNER.
<br> Tambi�n tenemos la opci�n de hacer visible o no la fuente y sus contenidos a los usuarios de la web con la casilla <em>visible</em>. Podemos eliminar una fuente
 siempre y cuando no tenga ning�n contenido relacionado con ella.
<br> A la derecha de la pantalla podemos ver el identificador de la fuente
 y cuantos contenidos tiene relacionados.";

$t100140 = "<strong>Usuarios de Contenidos</strong><br>";
$h100140 = " Lista de los usuarios y si est�n autorizados a mandar contenidos o no. Si somos administrador del modulo podemos conceder o retirar permisos al resto de
 usuarios y a nosotros mismos. Un usuario con permiso para un grupo solo puede acceder a sus propios contenidos para editarlos o borrarlos. Si ademas somos
 administrador del grupo, tambi�n podemos acceder a los contenidos de los dem�s usuarios.";

$t100150 = "<strong>Elementos de Contenidos</strong><br>";
$h100150 = "Los elementos de un contenido son imagenes, videos y documentos que sirven para ilustrar o complementar un contenido. Para a�adir un elemento a un
 contenido primero hemos de subirlo desde esta pantalla.
 <br> Debemos elegir que tipo de archivo queremos subir (.DOC, .PDF, imegen, video), depu�s buscarlo en nuestro ordenador con el bot�n <em>examinar</em> y una vez
 encontrado y seleccionado clickamos en <em>subir elemento</em>. Estos elementos se guardan en la carpeta /UPLOADS y pueden ser utilizados en m�s de un contenido.
<br> Para asociar un elemento a un contenido debemos dirigirnos a <em>administraci�n de contenidos</em>.";


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