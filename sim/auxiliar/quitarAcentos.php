<?php
error_reporting(~E_ALL);


function quitarAcentos($string){
	return strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝªº','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUYao');
}

?>