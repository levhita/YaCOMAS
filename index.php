<?
	include "includes/conf.inc";
        include "includes/lib.php";
	imprimeEncabezado();
	imprimeCajaTop("100","Registro");
	aplicaEstilo();


print '
<p>�Gracias por tu inter�s en el Congreso!</p>
 
 <p>
 <a href="'.$rootpath.'/ponente/index.php?opc=1">Reg�stro de ponentes 
 </a>
 &nbsp;
 <a href="'.$rootpath.'/ponente/">Accesa a tu cuenta
 </a>

 <br/>
 Es necesario tu registro, mediante el cual podr�s enviar
 ponencias y estar informado del evento.</p>
 <p>
 <a href="'.$rootpath.'/asistente/index.php?opc=1">Reg�stro de asistentes
 </a>
 &nbsp;
 <a href="'.$rootpath.'/asistente/">Accesa a tu cuenta
 </a>
 <br/>
 Es necesario tu registro, mediante el cual podr�s realizar preinscripcion al Congreso y a los talleres
 y estar informado del evento.</p>
     
 <p><a href="'.$rootpath.'/lista/">Lista preliminar de ponencias</a>
 <br />
 Aqu� ver�s las ponencias que han sido enviadas, y el status en el que se encuentran dichas ponencias.</p>
';

imprimeCajaBottom(); 
imprimePie(); 
?>
