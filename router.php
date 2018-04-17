<?php
require_once __DIR__.'/routines.php';
require __DIR__.'/controllers/CAdmin.php';

if ((isset($_GET['contr'])) && ($_GET['contr']!='') && (isset($_GET['act'])) && ($_GET['act']!='')){
	$contr = clearInput($_GET['contr']);
	$methodName = clearInput($_GET['act']);
	$className = 'C'.ucfirst($contr);
	$controller = new $className();
	$controller->$methodName($pdo, $twig);
}
else { # если контроллер не передан
	$admin = new Admin();
	if ($admin->isLogedin($pdo)) { #если пользователь уже залогинен
		CAdmin::manage($pdo, $twig);
	}
	else {
		$template = $twig ->loadTemplate('main.html');
		$params = array('themes' => Theme::getAllThemes($pdo));
		$template->display($params);
	}
}
?>
