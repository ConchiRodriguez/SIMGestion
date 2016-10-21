<?php
require_once("fpdf.php");
	function Portada()	{		$this->SetFont('Arial','B',16);		$this->Cell(40,10,'¡Hola, Mundo!');	}
	function Contraportada()	{		$this->SetFont('Arial','B',16);		$this->Cell(40,10,'¡Adios, Mundo!');	}

?>
