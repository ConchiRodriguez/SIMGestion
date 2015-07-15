<?php


if ($option == 2) { 
	if ($soption == 0) {
	?>
<center>
<form action="http://mail.multivia.com/src/redirect.php" method="post">
	<table bgcolor="#ffffff" border="0" width="350">
		<tr>
			<td bgcolor="#DCDCDC" align="center"><b>Ingreso a mail.multivia.com</b></td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF" align="left">
				<table bgcolor="#ffffff" align="center" border="0" width="100%">
					<tr>
						<td align="right" width="30%">Nombre:</td>
						<td align="left" width="*"><input type="text" name="login_username" value="" /></td>
					</tr>
					<tr>
						<td align="right" width="30%">Clave:</td>
						<td align="left" width="*">
						<input type="password" name="secretkey" />
						<input type="hidden" name="js_autodetect_results" value="SMPREF_JS_OFF" />
						<input type="hidden" name="just_logged_in" value="1" />
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="left"><center><input type="submit" value="Ingreso" /></center></td>
		</tr>
	</table>
</form>
</center>
	
<?php
	}
}

?>