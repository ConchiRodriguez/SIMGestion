<?php 
error_reporting(~E_ALL);
if ($servidor == "iss"){
	date_default_timezone_set('Europe/Paris');
}

	include ("../config.php");
	foreach (glob("../auxiliar/*.php") as $filename)
	{
		include ($filename);
	}

### CONEXIO PLATAFORMA
$dbhandle = new mysqli($dbhost,$dbuname,$dbpass,$dbname);
$db = mysqli_select_db($dbhandle, $dbname) or die("Couldn't open database");

		$sqlcc = "select nombre,apellido1,apellido2 from sgm_clients_contactos where pred=1 and id_client=31";
		$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
		$rowcc = mysqli_fetch_array($resultcc);
		echo quitarAcentos($rowcc["apellido1"]);
		echo strtr($rowcc["apellido1"],'é','e');
		echo strtr(utf8_decode($rowcc["apellido1"]),utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝªº'),'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUYao');
$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
echo $texto = ereg_replace($no_permitidas, $permitidas ,$rowcc["apellido1"]);

?>
<html>
<body>
<?php
	echo factura_print_e($_GET["id"]);

	echo "<a href=\"".$urloriginal."/mgestion/efactura.xml\">facturae</a>";
#	header("Location: ".$urloriginal."/mgestion/efactura.xml");

function factura_print_e($id)
{
		global $db,$dbhandle;

		$idioma = strtolower($_POST["idioma"]);
		include ("lenguajes/factura-print-".$idioma.".php");

		$persona = array('J','F');
		$residencia = array('R','U','E');

		$sqlcabezera = "select * from sgm_cabezera where id=".$id;
		$resultcabezera = mysqli_query($dbhandle,convertSQL($sqlcabezera));
		$rowcabezera = mysqli_fetch_array($resultcabezera);

		$sqlx = "select * from sgm_clients where id=".$rowcabezera["id_cliente"];
		$resultx = mysqli_query($dbhandle,convertSQL($sqlx));
		$rowx = mysqli_fetch_array($resultx);

		$sqlsys = "select siglas from sgm_paises where id=".$rowx["id_pais"];
		$resultsys = mysqli_query($dbhandle,convertSQL($sqlsys));
		$rowsys = mysqli_fetch_array($resultsys);

		$sqldiv = "select abrev from sgm_divisas where id=".$rowcabezera["id_divisa"];
		$resultdiv = mysqli_query($dbhandle,convertSQL($sqldiv));
		$rowdiv = mysqli_fetch_array($resultdiv);

		$sqlcc = "select nombre,apellido1,apellido2 from sgm_clients_contactos where pred=1 and id_client=".$rowcabezera["id_cliente"];
		$resultcc = mysqli_query($dbhandle,convertSQL($sqlcc));
		$rowcc = mysqli_fetch_array($resultcc);

		$sqlele = "select * from sgm_dades_origen_factura";
		$resultele = mysqli_query($dbhandle,convertSQL($sqlele));
		$rowele = mysqli_fetch_array($resultele);
		
		$f = fopen('efactura.xml','w+');
		$content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$content .= "<fe:Facturae xmlns:ds=\"http://www.w3.org/2000/09/xmldsig#\" xmlns:fe=\"http://www.facturae.es/Facturae/2009/v3.2/Facturae\">\n";
		$content .= "	<FileHeader>\n";
		$content .= "		<SchemaVersion>3.2</SchemaVersion>\n";
		$content .= "		<Modality>I</Modality>\n";
		$content .= "		<InvoiceIssuerType>EM</InvoiceIssuerType>\n";
		$content .= "		<Batch>\n";
		$content .= "			<BatchIdentifier>".$rowcabezera["numero"]."/".$rowcabezera["version"]."</BatchIdentifier>\n";
		$content .= "			<InvoicesCount>1</InvoicesCount>\n";
		$content .= "			<TotalInvoicesAmount>\n";
		$content .= "				<TotalAmount>".number_format($rowcabezera["total"], 2, '.', '')."</TotalAmount>\n";
		$content .= "			</TotalInvoicesAmount>\n";
		$content .= "			<TotalOutstandingAmount>\n";
		$content .= "				<TotalAmount>".number_format($rowcabezera["total"], 2, '.', '')."</TotalAmount>\n";
		$content .= "			</TotalOutstandingAmount>\n";
		$content .= "			<TotalExecutableAmount>\n";
		$content .= "				<TotalAmount>".number_format($rowcabezera["total"], 2, '.', '')."</TotalAmount>\n";
		$content .= "			</TotalExecutableAmount>\n";
		$content .= "			<InvoiceCurrencyCode>EUR</InvoiceCurrencyCode>\n";
		$content .= "		</Batch>\n";
		$content .= "	</FileHeader>\n";
		$content .= "	<Parties>\n";
		$content .= "		<SellerParty>\n";
		$content .= "			<TaxIdentification>\n";
		$content .= "				<PersonTypeCode>J</PersonTypeCode>\n";
		$content .= "				<ResidenceTypeCode>R</ResidenceTypeCode>\n";
		$content .= "				<TaxIdentificationNumber>".$rowele["nif"]."</TaxIdentificationNumber>\n";
		$content .= "			</TaxIdentification>\n";
		$content .= "			<LegalEntity>\n";
		$content .= "				<CorporateName>".quitarAcentos(comillasInver($rowele["nombre"]))."</CorporateName>\n";
#		$content .= "				<TradeName>Solucions-IM</TradeName>\n";
#		$content .= "				<RegistrationData>\n";
#		$content .= "					<Book>1</Book>\n";
#		$content .= "					<RegisterOfCompaniesLocation>Barcelona</RegisterOfCompaniesLocation>\n";
#		$content .= "					<Sheet>B 421165</Sheet>\n";
#		$content .= "					<Folio>141</Folio>\n";
#		$content .= "					<Volume>42967</Volume>\n";
#		$content .= "					<AdditionalRegistrationData>Sin datos</AdditionalRegistrationData>\n";
#		$content .= "				</RegistrationData>\n";
		$content .= "				<AddressInSpain>\n";
		$content .= "					<Address>".quitarAcentos(comillasInver($rowele["direccion"]))."</Address>\n";
		$content .= "					<PostCode>".$rowele["cp"]."</PostCode>\n";
		$content .= "					<Town>".quitarAcentos(comillasInver($rowele["poblacion"]))."</Town>\n";
		$content .= "					<Province>".quitarAcentos(comillasInver($rowele["provincia"]))."</Province>\n";
		$content .= "					<CountryCode>ESP</CountryCode>\n";
		$content .= "				</AddressInSpain>\n";
		$content .= "				<ContactDetails>\n";
		$content .= "					<Telephone>".$rowele["telefono"]."</Telephone>\n";
#		$content .= "					<TeleFax></TeleFax>\n";
#		$content .= "					<WebAddress></WebAddress>\n";
		$content .= "					<ElectronicMail>".$rowele["mail"]."</ElectronicMail>\n";
#		$content .= "					<ContactPersons></ContactPersons>\n";
#		$content .= "					<CnoCnae></CnoCnae>\n";
#		$content .= "					<INETownCode></INETownCode>\n";
#		$content .= "					<AdditionalContactDetails></AdditionalContactDetails>\n";
		$content .= "				</ContactDetails>\n";
		$content .= "			</LegalEntity>\n";
		$content .= "		</SellerParty>\n";
		$content .= "		<BuyerParty>\n";
		$content .= "			<TaxIdentification>\n";
		$content .= "				<PersonTypeCode>".$persona[$rowx["tipo_persona"]]."</PersonTypeCode>\n";
		$content .= "				<ResidenceTypeCode>".$residencia[$rowx["tipo_residencia"]]."</ResidenceTypeCode>\n";
		$content .= "				<TaxIdentificationNumber>".$rowcabezera["nif"]."</TaxIdentificationNumber>\n";
		$content .= "			</TaxIdentification>\n";
		$content .= "			<AdministrativeCentres>\n";
	if ($rowx["dir3_oficina_contable"] != ''){
		$content .= "				<AdministrativeCentre>\n";
		$content .= "					<CentreCode>".$rowx["dir3_oficina_contable"]."</CentreCode>\n";
		$content .= "					<RoleTypeCode>01</RoleTypeCode>\n";
		$content .= "					<Name>".quitarAcentos(comillasInver($rowcc["nombre"]))."</Name>\n";
		$content .= "					<FirstSurname>".quitarAcentos(comillasInver($rowcc["apellido1"]))."</FirstSurname>\n";
		$content .= "					<SecondSurname>".quitarAcentos(comillasInver($rowcc["apellido2"]))."</SecondSurname>\n";

		$content .= "					<AddressInSpain>\n";
		$content .= "						<Address>".quitarAcentos(comillasInver($rowcabezera["direccion"]))."</Address>\n";
		$content .= "						<PostCode>".$rowcabezera["cp"]."</PostCode>\n";
		$content .= "						<Town>".quitarAcentos(comillasInver($rowcabezera["poblacion"]))."</Town>\n";
		$content .= "						<Province>".quitarAcentos(comillasInver($rowcabezera["provincia"]))."</Province>\n";
		$content .= "						<CountryCode>".$rowsys["siglas"]."</CountryCode>\n";
		$content .= "					</AddressInSpain>\n";
		$content .= "					<ContactDetails>\n";
		$content .= "						<Telephone>".$rowcabezera["telefono"]."</Telephone>\n";
		$content .= "						<TeleFax>".$rowx["fax"]."</TeleFax>\n";
		$content .= "						<WebAddress>".$rowx["web"]."</WebAddress>\n";
		$content .= "						<ElectronicMail>".$rowcabezera["mail"]."</ElectronicMail>\n";
		$content .= "					</ContactDetails>\n";
		$content .= "					<CentreDescription>Centro principal</CentreDescription>\n";
		$content .= "				</AdministrativeCentre>\n";

		$content .= "				<AdministrativeCentre>\n";
		$content .= "					<CentreCode>".$rowx["dir3_organo_gestor"]."</CentreCode>\n";
		$content .= "					<RoleTypeCode>02</RoleTypeCode>\n";
		$content .= "					<Name>".quitarAcentos(comillasInver($rowcc["nombre"]))."</Name>\n";
		$content .= "					<FirstSurname>".quitarAcentos(comillasInver($rowcc["apellido1"]))."</FirstSurname>\n";
		$content .= "					<SecondSurname>".quitarAcentos(comillasInver($rowcc["apellido2"]))."</SecondSurname>\n";
		$content .= "					<AddressInSpain>\n";
		$content .= "						<Address>".quitarAcentos(comillasInver($rowcabezera["direccion"]))."</Address>\n";
		$content .= "						<PostCode>".$rowcabezera["cp"]."</PostCode>\n";
		$content .= "						<Town>".quitarAcentos(comillasInver($rowcabezera["poblacion"]))."</Town>\n";
		$content .= "						<Province>".quitarAcentos(comillasInver($rowcabezera["provincia"]))."</Province>\n";
		$content .= "						<CountryCode>".$rowsys["siglas"]."</CountryCode>\n";
		$content .= "					</AddressInSpain>\n";
		$content .= "					<ContactDetails>\n";
		$content .= "						<Telephone>".$rowcabezera["telefono"]."</Telephone>\n";
		$content .= "						<TeleFax>".$rowx["fax"]."</TeleFax>\n";
		$content .= "						<WebAddress>".$rowx["web"]."</WebAddress>\n";
		$content .= "						<ElectronicMail>".$rowcabezera["mail"]."</ElectronicMail>\n";
		$content .= "					</ContactDetails>\n";
		$content .= "					<CentreDescription>Centro principal</CentreDescription>\n";
		$content .= "				</AdministrativeCentre>\n";

		$content .= "				<AdministrativeCentre>\n";
		$content .= "					<CentreCode>".$rowx["dir3_unidad_tramitadora"]."</CentreCode>\n";
		$content .= "					<RoleTypeCode>03</RoleTypeCode>\n";
		$content .= "					<Name>".quitarAcentos(comillasInver($rowcc["nombre"]))."</Name>\n";
		$content .= "					<FirstSurname>".quitarAcentos(comillasInver($rowcc["apellido1"]))."</FirstSurname>\n";
		$content .= "					<SecondSurname>".quitarAcentos(comillasInver($rowcc["apellido2"]))."</SecondSurname>\n";

		$content .= "					<AddressInSpain>\n";
		$content .= "						<Address>".quitarAcentos(comillasInver($rowcabezera["direccion"]))."</Address>\n";
		$content .= "						<PostCode>".$rowcabezera["cp"]."</PostCode>\n";
		$content .= "						<Town>".quitarAcentos(comillasInver($rowcabezera["poblacion"]))."</Town>\n";
		$content .= "						<Province>".quitarAcentos(comillasInver($rowcabezera["provincia"]))."</Province>\n";
		$content .= "						<CountryCode>".$rowsys["siglas"]."</CountryCode>\n";
		$content .= "					</AddressInSpain>\n";
		$content .= "					<ContactDetails>\n";
		$content .= "						<Telephone>".$rowcabezera["telefono"]."</Telephone>\n";
		$content .= "						<TeleFax>".$rowx["fax"]."</TeleFax>\n";
		$content .= "						<WebAddress>".$rowx["web"]."</WebAddress>\n";
		$content .= "						<ElectronicMail>".$rowcabezera["mail"]."</ElectronicMail>\n";
		$content .= "					</ContactDetails>\n";
		$content .= "					<CentreDescription>Centro principal</CentreDescription>\n";
		$content .= "				</AdministrativeCentre>\n";
	} else {
		$content .= "				<AdministrativeCentre>\n";
#		$content .= "					<CentreCode></CentreCode>\n";
#		$content .= "					<RoleTypeCode></RoleTypeCode>\n";
		$content .= "					<Name>".quitarAcentos(comillasInver($rowcc["nombre"]))."</Name>\n";
		$content .= "					<FirstSurname>".quitarAcentos(comillasInver($rowcc["apellido1"]))."</FirstSurname>\n";
		$content .= "					<SecondSurname>".quitarAcentos(comillasInver($rowcc["apellido2"]))."</SecondSurname>\n";

		$content .= "					<AddressInSpain>\n";
		$content .= "						<Address>".quitarAcentos(comillasInver($rowcabezera["direccion"]))."</Address>\n";
		$content .= "						<PostCode>".$rowcabezera["cp"]."</PostCode>\n";
		$content .= "						<Town>".quitarAcentos(comillasInver($rowcabezera["poblacion"]))."</Town>\n";
		$content .= "						<Province>".quitarAcentos(comillasInver($rowcabezera["provincia"]))."</Province>\n";
		$content .= "						<CountryCode>".$rowsys["siglas"]."</CountryCode>\n";
		$content .= "					</AddressInSpain>\n";
		$content .= "					<ContactDetails>\n";
		$content .= "						<Telephone>".$rowcabezera["telefono"]."</Telephone>\n";
		$content .= "						<TeleFax>".$rowx["fax"]."</TeleFax>\n";
		$content .= "						<WebAddress>".$rowx["web"]."</WebAddress>\n";
		$content .= "						<ElectronicMail>".$rowcabezera["mail"]."</ElectronicMail>\n";
		$content .= "					</ContactDetails>\n";
		$content .= "					<CentreDescription>Centro principal</CentreDescription>\n";
		$content .= "				</AdministrativeCentre>\n";
	}
		$content .= "			</AdministrativeCentres>\n";
	if ($rowx["tipo_persona"]==0){
		$content .= "			<LegalEntity>\n";
		$content .= "				<CorporateName>".quitarAcentos(comillasInver(substr($rowcabezera["nombre"],0,80)))."</CorporateName>\n";
#		$content .= "				<TradeName></TradeName>\n";
#		$content .= "				<RegistrationData>\n";
#		$content .= "					<Book></Book>\n";
#		$content .= "					<RegisterOfCompaniesLocation></RegisterOfCompaniesLocation>\n";
#		$content .= "					<Sheet></Sheet>\n";
#		$content .= "					<Folio></Folio>\n";
#		$content .= "					<Section></Section>\n";
#		$content .= "					<Volume></Volume>\n";
#		$content .= "					<AdditionalRegistrationData></AdditionalRegistrationData>\n";
#		$content .= "				</RegistrationData>\n";
	} elseif ($rowx["tipo_persona"]==1){
		$content .= "			<Individual>\n";
		$content .= "				<Name>".quitarAcentos(comillasInver($rowx["nombre"]))."</Name>\n";
		$content .= "				<FirstSurname>".quitarAcentos(comillasInver($rowx["cognom1"]))."</FirstSurname>\n";
		$content .= "				<SecondSurname>".quitarAcentos(comillasInver($rowx["cognom2"]))."</SecondSurname>\n";
	}
	
		$content .= "				<AddressInSpain>\n";
		$content .= "					<Address>".quitarAcentos(comillasInver($rowcabezera["direccion"]))."</Address>\n";
		$content .= "					<PostCode>".$rowcabezera["cp"]."</PostCode>\n";
		$content .= "					<Town>".quitarAcentos(comillasInver($rowcabezera["poblacion"]))."</Town>\n";
		$content .= "					<Province>".quitarAcentos(comillasInver($rowcabezera["provincia"]))."</Province>\n";
		$content .= "					<CountryCode>".$rowsys["siglas"]."</CountryCode>\n";
		$content .= "				</AddressInSpain>\n";
		$content .= "				<ContactDetails>\n";
		$content .= "					<Telephone>".$rowcabezera["telefono"]."</Telephone>\n";
		$content .= "					<TeleFax>".$rowx["fax"]."</TeleFax>\n";
		$content .= "					<WebAddress>".$rowx["web"]."</WebAddress>\n";
		$content .= "					<ElectronicMail>".$rowcabezera["mail"]."</ElectronicMail>\n";
		$content .= "				</ContactDetails>\n";

	if ($rowx["tipo_persona"]==0){
		$content .= "			</LegalEntity>\n";
	} elseif ($rowx["tipo_persona"]==1){
		$content .= "			</Individual>\n";
	}

	$content .= "		</BuyerParty>\n";
		$content .= "	</Parties>\n";
		$content .= "	<Invoices>\n";
		$content .= "		<Invoice>\n";
		$content .= "			<InvoiceHeader>\n";
		$content .= "				<InvoiceNumber>".$rowcabezera["numero"]."</InvoiceNumber>\n";
		$content .= "				<InvoiceSeriesCode>".$rowcabezera["version"]."</InvoiceSeriesCode>\n";
		$content .= "				<InvoiceDocumentType>FC</InvoiceDocumentType>\n";
		$content .= "				<InvoiceClass>OO</InvoiceClass>\n";
		$content .= "			</InvoiceHeader>\n";
		$content .= "			<InvoiceIssueData>\n";
		$content .= "				<IssueDate>".$rowcabezera["fecha"]."</IssueDate>\n";
#		$content .= "				<OperationDate></OperationDate>\n";
		$content .= "				<PlaceOfIssue>\n";
		$content .= "					<PostCode>".$rowele["cp"]."</PostCode>\n";
		$content .= "					<PlaceOfIssueDescription>".quitarAcentos(comillasInver($rowele["poblacion"]))."</PlaceOfIssueDescription>\n";
		$content .= "				</PlaceOfIssue>\n";
#		$content .= "				<InvoicingPeriod>\n";
#		$content .= "					<StartDate></StartDate>\n";
#		$content .= "					<EndDate></EndDate>\n";
#		$content .= "				</InvoicingPeriod>\n";
		$content .= "				<InvoiceCurrencyCode>".$rowdiv["abrev"]."</InvoiceCurrencyCode>\n";
		$content .= "				<TaxCurrencyCode>".$rowdiv["abrev"]."</TaxCurrencyCode>\n";
		$content .= "				<LanguageName>".$_POST["idioma"]."</LanguageName>\n";
		$content .= "			</InvoiceIssueData>\n";
		$content .= "			<TaxesOutputs>\n";
		$content .= "				<Tax>\n";
		$content .= "					<TaxTypeCode>01</TaxTypeCode>\n";
		$content .= "					<TaxRate>".number_format($rowcabezera["iva"], 2, '.', '')."</TaxRate>\n";
		$content .= "					<TaxableBase>\n";
		$content .= "						<TotalAmount>".number_format($rowcabezera["subtotaldescuento"], 2, '.', '')."</TotalAmount>\n";
		$content .= "					</TaxableBase>\n";
		$content .= "					<TaxAmount>\n";
		$content .= "						<TotalAmount>".number_format((($rowcabezera["subtotaldescuento"] / 100) * $rowcabezera["iva"]), 2, '.', '')."</TotalAmount>\n";
		$content .= "					</TaxAmount>\n";
#		$content .= "					<EquivalenceSurcharge></EquivalenceSurcharge>\n";
#		$content .= "					<EquivalenceSurchargeAmount>\n";
#		$content .= "						<TotalAmount></TotalAmount>\n";
#		$content .= "					</EquivalenceSurchargeAmount>\n";
		$content .= "				</Tax>\n";
		$content .= "			</TaxesOutputs>\n";
#		$content .= "			<TaxesWithheld>\n";
#		$content .= "				<Tax>\n";
#		$content .= "					<TaxTypeCode></TaxTypeCode>\n";
#		$content .= "					<TaxRate></TaxRate>\n";
#		$content .= "					<TaxableBase>\n";
#		$content .= "						<TotalAmount></TotalAmount>\n";
#		$content .= "					</TaxableBase>\n";
#		$content .= "					<TaxAmount>\n";
#		$content .= "						<TotalAmount></TotalAmount>\n";
#		$content .= "					</TaxAmount>\n";
#		$content .= "				</Tax>\n";
#		$content .= "			</TaxesWithheld>\n";

		$content .= "			<InvoiceTotals>\n";
		$content .= "				<TotalGrossAmount>".number_format($rowcabezera["subtotal"], 2, '.', '')."</TotalGrossAmount>\n";
		$content .= "				<GeneralDiscounts>\n";
		$content .= "					<Discount>\n";
		$content .= "						<DiscountReason>Descuento Factura</DiscountReason>\n";
	if ($rowcabezera["descuento"] > 0){
		$content .= "						<DiscountRate>".number_format($rowcabezera["descuento"], 4, '.', '')."</DiscountRate>\n";
	} else {
		$content .= "						<DiscountAmount>".number_format($rowcabezera["descuento_absoluto"], 6, '.', '')."</DiscountAmount>\n";
	}
		$content .= "					</Discount>\n";
		$content .= "				</GeneralDiscounts>\n";

		
		
		$content .= "				<TotalGeneralDiscounts>".number_format($rowcabezera["subtotal"]-$rowcabezera["subtotaldescuento"], 2, '.', '')."</TotalGeneralDiscounts>\n";
#		$content .= "				<TotalGeneralSurcharges></TotalGeneralSurcharges>\n";
		$content .= "				<TotalGrossAmountBeforeTaxes>".number_format($rowcabezera["subtotaldescuento"], 2, '.', '')."</TotalGrossAmountBeforeTaxes>\n";
		$content .= "				<TotalTaxOutputs>".number_format((($rowcabezera["subtotaldescuento"] / 100) * $rowcabezera["iva"]), 2, '.', '')."</TotalTaxOutputs>\n";
		$content .= "				<TotalTaxesWithheld>0.00</TotalTaxesWithheld>\n";
		$content .= "				<InvoiceTotal>".number_format($rowcabezera["total"], 2, '.', '')."</InvoiceTotal>\n";
		$content .= "				<TotalOutstandingAmount>".number_format($rowcabezera["total"], 2, '.', '')."</TotalOutstandingAmount>\n";
		$content .= "				<TotalExecutableAmount>".number_format($rowcabezera["total"], 2, '.', '')."</TotalExecutableAmount>\n";
		$content .= "			</InvoiceTotals>\n";
		$content .= "			<Items>\n";

	$sqlco = "select * from sgm_contratos where id=".$rowcabezera["id_contrato"];
	$resultco = mysqli_query($dbhandle,convertSQL($sqlco));
	$rowco = mysqli_fetch_array($resultco);

	$sqlcuerpo = "select * from sgm_cuerpo where idfactura=".$rowcabezera["id"];
	$resultcuerpo = mysqli_query($dbhandle,convertSQL($sqlcuerpo));
	while ($rowcuerpo = mysqli_fetch_array($resultcuerpo)){

		$content .= "				<InvoiceLine>\n";
	if ($rowco){
		$content .= "					<IssuerContractReference>".quitarAcentos(comillasInver(substr($rowco["descripcion"],0,20)))."</IssuerContractReference>\n";
		$content .= "					<IssuerContractDate>".$rowco["fecha_ini"]."</IssuerContractDate>\n";
		$content .= "					<IssuerTransactionReference>".substr($rowco["num_contrato"],0,20)."</IssuerTransactionReference>\n";
		$content .= "					<IssuerTransactionDate>".$rowco["fecha_ini"]."</IssuerTransactionDate>\n";
	}
#		$content .= "					<ReceiverContractReference></ReceiverContractReference>\n";
#		$content .= "					<ReceiverContractDate></ReceiverContractDate>\n";
		$content .= "					<ReceiverTransactionReference>".$rowcabezera["numero_cliente"]."</ReceiverTransactionReference>\n";
#		$content .= "					<ReceiverTransactionDate></ReceiverTransactionDate>\n";
#		$content .= "					<FileReference></FileReference>\n";
#		$content .= "					<FileDate></FileDate>\n";
#		$content .= "					<SequenceNumber></SequenceNumber>\n";
#		$content .= "					<DeliveryNotesReferences>\n";
#		$content .= "						<DeliveryNote>\n";
#		$content .= "							<DeliveryNoteNumber></DeliveryNoteNumber>\n";
#		$content .= "							<DeliveryNoteDate></DeliveryNoteDate>\n";
#		$content .= "						</DeliveryNote>\n";
#		$content .= "					</DeliveryNotesReferences>\n";
		$content .= "					<ItemDescription>".quitarAcentos(comillasInver($rowcuerpo["nombre"]))."</ItemDescription>\n";
		$content .= "					<Quantity>".$rowcuerpo["unidades"]."</Quantity>\n";
		$content .= "					<UnitOfMeasure>01</UnitOfMeasure>\n";
		$content .= "					<UnitPriceWithoutTax>".number_format($rowcuerpo["pvp"], 6, '.', '')."</UnitPriceWithoutTax>\n";
		$content .= "					<TotalCost>".number_format(($rowcuerpo["pvp"]*$rowcuerpo["unidades"]), 6, '.', '')."</TotalCost>\n";
		$content .= "					<DiscountsAndRebates>\n";
		$content .= "						<Discount>\n";
		$content .= "							<DiscountReason>Descuento Linea</DiscountReason>\n";
	if ($rowcuerpo["descuento"] > 0){
		$content .= "							<DiscountRate>".number_format($rowcuerpo["descuento"], 4, '.', '')."</DiscountRate>\n";
	} else {
		$content .= "							<DiscountAmount>".number_format($rowcuerpo["descuento_absoluto"], 6, '.', '')."</DiscountAmount>\n";
	}
		$content .= "						</Discount>\n";
		$content .= "					</DiscountsAndRebates>\n";
#		$content .= "					<Charges>\n";
#		$content .= "						<Charge>\n";
#		$content .= "							<ChargeReason></ChargeReason>\n";
#		$content .= "							<ChargeAmount></ChargeAmount>\n";
#		$content .= "						</Charge>\n";
#		$content .= "					</Charges>\n";
		$content .= "					<GrossAmount>".number_format($rowcuerpo["total"], 6, '.', '')."</GrossAmount>\n";
		$content .= "					<TaxesOutputs>\n";
		$content .= "						<Tax>\n";
		$content .= "							<TaxTypeCode>01</TaxTypeCode>\n";
		$content .= "							<TaxRate>".number_format($rowcabezera["iva"], 2, '.', '')."</TaxRate>\n";
		$content .= "							<TaxableBase>\n";
		$content .= "								<TotalAmount>".number_format($rowcuerpo["total"], 2, '.', '')."</TotalAmount>\n";
		$content .= "							</TaxableBase>\n";
		$content .= "							<TaxAmount>\n";
		$content .= "								<TotalAmount>".number_format((($rowcuerpo["total"] / 100) * $rowcabezera["iva"]), 2, '.', '')."</TotalAmount>\n";
		$content .= "							</TaxAmount>\n";
		$content .= "						</Tax>\n";
		$content .= "					</TaxesOutputs>\n";
	if ($rowco){
		$content .= "					<LineItemPeriod>\n";
		$content .= "						<StartDate>".$rowco["fecha_ini"]."</StartDate>\n";
		$content .= "						<EndDate>".$rowco["fecha_fin"]."</EndDate>\n";
		$content .= "					</LineItemPeriod>\n";
	}
#		$content .= "					<AdditionalLineItemInformation></AdditionalLineItemInformation>\n";
#		$content .= "					<SpecialTaxableEvent>\n";
#		$content .= "						<SpecialTaxableEventCode></SpecialTaxableEventCode>\n";
#		$content .= "						<SpecialTaxableEventReason></SpecialTaxableEventReason>\n";
#		$content .= "					</SpecialTaxableEvent>\n";
		$content .= "					<ArticleCode>".$rowcuerpo["codigo"]."</ArticleCode>\n";
		$content .= "				</InvoiceLine>\n";
	}
	$sqliban = "select * from sgm_dades_origen_factura_iban where id=".$rowcabezera["id_dades_origen_factura_iban"];
	$resultiban = mysqli_query($dbhandle,convertSQL($sqliban));
	$rowiban = mysqli_fetch_array($resultiban);

		$content .= "			</Items>\n";
		$content .= "			<PaymentDetails>\n";
		$content .= "				<Installment>\n";
		$content .= "					<InstallmentDueDate>".$rowcabezera["fecha_vencimiento"]."</InstallmentDueDate>\n";
		$content .= "					<InstallmentAmount>".number_format($rowcabezera["total"], 2, '.', '')."</InstallmentAmount>\n";
		$content .= "					<PaymentMeans>04</PaymentMeans>\n";
		$content .= "					<AccountToBeCredited>\n";
		$content .= "						<IBAN>".$rowiban["iban"]."</IBAN>\n";
#		$content .= "						<AccountNumber></AccountNumber>\n";
		$content .= "					</AccountToBeCredited>\n";
#		$content .= "					<BankCode></BankCode>\n";
#		$content .= "					<BranchCode></BranchCode>\n";
#		$content .= "					<BranchInSpainAddress>\n";
#		$content .= "						<Address></Address>\n";
#		$content .= "						<PostCode></PostCode>\n";
#		$content .= "						<Town></Town>\n";
#		$content .= "						<Province></Province>\n";
#		$content .= "						<CountryCode></CountryCode>\n";
#		$content .= "					</BranchInSpainAddress>\n";
#		$content .= "					<PaymentReconciliationReference></PaymentReconciliationReference>\n";
#		$content .= "					<AccountToBeDebited>\n";
#		$content .= "						<IBAN></IBAN>\n";
#		$content .= "						<BankCode></BankCode>\n";
#		$content .= "						<BranchCode></BranchCode>\n";
#		$content .= "					</AccountToBeDebited>\n";
#		$content .= "					<DebitReconciliationReference></DebitReconciliationReference>\n";
		$content .= "				</Installment>\n";
		$content .= "			</PaymentDetails>\n";
		$content .= "		</Invoice>\n";
		$content .= "	</Invoices>\n";
	
		$content .= "</fe:Facturae>\n";
		fwrite($f,$content,strlen($content));
		fclose($f);

}
?>


</body>
</html>
