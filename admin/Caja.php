<?php  
define('TO_ROOT', '..');
include TO_ROOT . "/includes/lib.php";
include TO_ROOT . "/includes/conf.inc.php";
include TO_ROOT . "/includes/xajax_server.php";

beginSession('R');
$tabs = array(
	0 => array("pbusqueda",'B�squeda de Persona'),
	1 => array("precibo",'Recibo'),
); 
$tab_option = (empty($_GET['tab']))?0:$_GET['tab'];
$tab = $tabs[$tab_option][0];

$View = new View($tab, "pagos"); 
$View->assign('tabs', $tabs);
$View->assign('tab_option', $tab_option);

include TO_ROOT ."/admin/$tab.php";
$View->display();
?>
