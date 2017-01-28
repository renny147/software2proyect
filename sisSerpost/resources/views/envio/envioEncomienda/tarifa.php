<?php 

	include("conexion.php");
	$con=mysql_connect($host,$user,$pw) or die("Problemas al conectar server");

	mysql_select_db($db,$con) or die("Problemas al conectar db");
	$registro=mysql_query("select  tarifa  from zona where iddepartamento_entrega='$_POST[val1] and  where nombre='$_POST[val2] and where idpeso='$_POST[val3]   '") or die("Problemas en consulta:".mysql_error());

	while ($reg = mysql_fetch_array($registro)) {//nos trae los datos de la tabla en forma ordenada
		
		echo $reg['TARIFA']."<br>";//TIENE QUE ESTAR EN MAYUSCULAS :()
		
	}

	

 ?>