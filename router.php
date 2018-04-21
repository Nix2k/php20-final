<?php
require_once __DIR__.'/routines.php';
require __DIR__.'/controllers/CAdmin.php';

if (!((isset($_GET['contr'])) && ($_GET['contr']!='') && (isset($_GET['act'])) && ($_GET['act']!=''))){
	$contr = 'admin';
	$methodName = 'manage';
}
else {
	$contr = clearInput($_GET['contr']);
	$methodName = clearInput($_GET['act']);
}
$className = 'C'.ucfirst($contr);
$controller = new $className();
$controller->$methodName($pdo, $twig);
?>
