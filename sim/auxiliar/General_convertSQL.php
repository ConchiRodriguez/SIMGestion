<?php
error_reporting(~E_ALL);

function convertSQL($sql) { 
	$basededatos = "mysql";
#	$basededatos = "mssql";

	if ($basededatos == "mysql") {
		$sql2 = $sql;
	}

	if ($basededatos == "mssql") {
		$sql2 = $sql;
		for($i=0; $i<strlen($sql); $i++) {
			if ($sql[$i] == "'") {

				if( (($sql[$i+1] > chr(47)) and ($sql[$i+1] < chr(58))) and (($sql[$i+2] > chr(47)) and ($sql[$i+2] < chr(58))) and (($sql[$i+3] > chr(47)) and ($sql[$i+3] < chr(58))) and (($sql[$i+4] > chr(47)) and ($sql[$i+4] < chr(58))) and ($sql[$i+5] == chr(45)) and (($sql[$i+6] > chr(47)) and ($sql[$i+6] < chr(58))) and (($sql[$i+7] > chr(47)) and ($sql[$i+7] < chr(58))) and ($sql[$i+8] == chr(45)) and (($sql[$i+9] > chr(47)) and ($sql[$i+9] < chr(58))) and (($sql[$i+10] > chr(47)) and ($sql[$i+10] < chr(58))) )  {
					$sql2[$i+1] = $sql[$i+9];
					$sql2[$i+2] = $sql[$i+10];
					$sql2[$i+3] = "/";
					$sql2[$i+4] = $sql[$i+6];
					$sql2[$i+5] = $sql[$i+7];
					$sql2[$i+6] = "/";
					$sql2[$i+7] = $sql[$i+1];
					$sql2[$i+8] = $sql[$i+2];
					$sql2[$i+9] = $sql[$i+3];
					$sql2[$i+10] = $sql[$i+4];
				}
				
			}

		}
	}
	return $sql2;
}

?>