<? 
	include "../includes/lib.php";
	include "../includes/conf.inc";
	imprimeEncabezado();
	aplicaEstilo();
	imprimeCajaTop("100","Lista preliminar de ponencias");
	print '<hr>';

$link=conectaBD();
$QSquery = 'SELECT * FROM prop_status ORDER BY ID'; 
$resultQS=mysql_query($QSquery);
$indice=0;
while ($QSfila=mysql_fetch_array($resultQS)) {
	$stat_array[$indice]['id']=$QSfila['id'];
	$stat_array[$indice]['descr']=$QSfila['descr'];
	$indice++;
}
mysql_free_result($resultQS);

//
// Status 7 es Eliminado
// Seleccionamos todos los que no esten eliminados ni esten programados
// Tal vez podriamos mejorar esta cosa para no depender directamente de que el status siempre sea dado en el codigo
//
$userQueryP ='	SELECT 	P.id AS id_ponencia, 
			P.nombre AS ponencia,
			P.tpropuesta, 
			P.id_ponente, 
			PO.nombrep, 
			PO.apellidos, 
			S.descr AS status 
		FROM 	propuesta AS P, 
			ponente AS PO, 
			prop_status AS S 
		WHERE 	P.id_ponente=PO.id AND 
			P.id_status=S.id AND 
			id_status != 7 
		ORDER BY P.tpropuesta,P.id_ponente,P.reg_time';
$userRecordsP = mysql_query($userQueryP) or err("No se pudo listar propuestas".mysql_errno($userRecords));
// Inicio datos de Ponencias
print '
	<table border=0 align=center width=100%>
	<tr>
	<td bgcolor='.$colortitle.'><b>Ponencia</b></td><td bgcolor='.$colortitle.'><b>Tipo</b>
	</td><td bgcolor='.$colortitle.'><b>Status</b></td>
	</tr>';
	

	$color=1;
	while ($fila = mysql_fetch_array($userRecordsP))
	{
		if ($color==1) 
		{
			$bgcolor=$color_renglon1;
			$color=2;
		}
		else 
		{
			$bgcolor=$color_renglon2;
			$color=1;
		}
		print '<tr>
		<td bgcolor='.$bgcolor.'><a class="azul" href="Vponencia.php?vopc='.$fila['id_ponente'].' '.$fila['id_ponencia'].' '.$_SERVER['REQUEST_URI'].'">'.$fila["ponencia"].'</a>';
		print '<br><small><a class="rojo" href="Vponente.php?vopc='.$fila['id_ponente'].' '.$_SERVER['REQUEST_URI'].'">'.$fila['nombrep'].' '.$fila['apellidos'].'</a></small>';
		
	
		print '</td><td bgcolor='.$bgcolor.'>';
		if ($fila['tpropuesta']=="C")
		    echo "Conferencia";
		else
		    echo "Taller";
		
		print '</td><td bgcolor='.$bgcolor.'>';
		print '<small>'.$fila['status'].'</small>';
	
		// Una vez que la ponencia fue aceptada (id 5)
		// La ponencia no se le puede modificar el status ni eliminar 
		// A menos que sea el administrador principal 
		print '</td>';
		print '</tr>';
		
	}
	print '</table>';
	retorno();
	retorno();
	print '<center>
	<input type="button" value="Continuar" onClick=location.href="../">
	</center>';
	imprimeCajaBottom(); 
	imprimePie(); 
?>