<? 
include "../includes/lib.php";
include "../includes/conf.inc";
beginSession('A');
$idasistente=$_SESSION['YACOMASVARS']['asiid'];
 
$link=conectaBD();
$userQuery = 'SELECT nombrep FROM asistente 
		WHERE id="'.$idasistente.'"';
	$userRecords = mysql_query($userQuery) or err("No se pudo checar el asistente".mysql_errno($userRecords));
	$p = mysql_fetch_array($userRecords);
	$asistente_name=$p['nombrep'];

$fechaQueryE='SELECT * FROM fecha_evento ORDER BY fecha';
$fechaRecords = mysql_query($fechaQueryE) or err("No se pudo listar fechas de eventos ".mysql_errno($fechaRecords));

imprimeEncabezado();
aplicaEstilo();
print '<p class="yacomas_login">Login: '.$_SESSION['YACOMASVARS']['asilogin'].'&nbsp;<a class="rojo" href=signout.php>Desconectarme</a></P>';
$msg="Listado de eventos<br><small>".$asistente_name." Estos son tus talleres registrados</small>";

imprimeCajaTop("100",$msg);

// Inicio datos de Talleres 
// Ordenadas por dia 
while ($Qf_evento = mysql_fetch_array($fechaRecords))
	{
		print '<center>';
		print '<H1>'.$Qf_evento['fecha'].'</H1>';
		if (!empty($Qf_evento['descr']))
			print '<H3> Dia de: '.$Qf_evento['descr'].'</H3>';
		print '</center>';
		// Comienzo de detalle de talleres registrados para este dia
		print '
			<table border=0 align=center width=100%>
			<tr>
			<td bgcolor='.$colortitle.'><b>Taller</b>
			</td></td><td bgcolor='.$colortitle.'><b>Orientacion</b>
			</td></td><td bgcolor='.$colortitle.'><b>Hora</b>
			</td></td><td bgcolor='.$colortitle.'><b>Lugar</b>
			</td><td bgcolor='.$colortitle.'>&nbsp;</td>
			</tr>';
		$QAins='SELECT 	E.id_propuesta, P.duracion, P.id_ponente, EO.id_lugar, 
				EO.id_fecha, E.id_propuesta, AI.id_evento, PO.nombrep, 
				PO.apellidos, P.nombre, O.descr, EO.hora, L.nombre_lug 
			FROM 	ponente AS PO, 
				lugar AS L, 
				orientacion AS O, 
				inscribe AS AI, 
				evento AS E, 
				propuesta AS P, 
				evento_ocupa AS EO  
			WHERE 	AI.id_evento=E.id AND 
				E.id_propuesta=P.id AND 
				AI.id_evento=EO.id_evento AND 
				P.id_orientacion=O.id AND 
				EO.id_lugar=L.id AND 
				P.id_ponente=PO.id AND 
				EO.id_fecha="'.$Qf_evento['id'].'" AND 
				AI.id_asistente="'.$idasistente.'" 
			GROUP BY AI.id_evento ORDER BY EO.hora';

		$AIeventoRecords= mysql_query($QAins) or err("No se pudo listar eventos de esta fecha".mysql_errno($eventoRecords));
		$color=1;
		while ($Qf_event= mysql_fetch_array($AIeventoRecords))
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
			print '<td bgcolor='.$bgcolor.'><a class="azul" href="Vponencia.php?vopc='.$Qf_event['id_ponente'].' '.$Qf_event['id_propuesta'].' '.$_SERVER['REQUEST_URI'].'">'.$Qf_event["nombre"].'</a>';
			retorno();
			print '<small><a class="rojo" href="Vponente.php?vopc='.$Qf_event['id_ponente'].' '.$_SERVER['REQUEST_URI'].'">'.$Qf_event["nombrep"].' '.$Qf_event["apellidos"].'</a></small>';
			
			print '</td><td bgcolor='.$bgcolor.'>'.$Qf_event["descr"];
			print '</td><td bgcolor='.$bgcolor.'>'.$Qf_event["hora"].':00 - ';
			$hfin=$Qf_event["hora"]+$Qf_event["duracion"];
			print $hfin.':00';
			print '</td><td bgcolor='.$bgcolor.'>'.$Qf_event["nombre_lug"];
			print '</td><td bgcolor='.$bgcolor.'><small><a class="rojo" href="Btaller.php?vact='.$Qf_event['id_evento'].' '.$_SERVER['REQUEST_URI'].'" onMouseOver="window.status=\'Dar de baja\';return true" onFocus="window.status=\'Dar de baja\';return true" onMouseOut="window.status=\'\';return true">Dar de baja</a>';
			print '</td></tr>';
			
		}
		mysql_free_result($AIeventoRecords);
		print '</table>';	
	}
	mysql_free_result($fechaRecords);
	retorno();
	retorno();
	print '<center>
	<input type="button" value="Volver al menu" onClick=location.href="'.$rootpath.'/asistente/menuasistente.php">
	</center>';
imprimeCajaBottom();
imprimePie();
?>