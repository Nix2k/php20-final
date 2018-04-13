<?php
require_once __DIR__.'/routines.php';
require __DIR__.'/controllers/CAdmin.php';

$admin = new Admin();

if ((isset($_GET['contr'])) && ($_GET['contr']!='') && (isset($_GET['act'])) && ($_GET['act']!='')){
	$contr = clearInput($_GET['contr']);
	$act = clearInput($_GET['act']);
	switch ($contr) {
		case 'admin':
			if ($admin->isLogedin($pdo)) { #если пользователь залогинен
				switch ($act) {
					case 'manage':
						# управление администраторами - окно
						CAdmin::manage($pdo, $twig);
						break;
					case 'reg':
						# добавление администратора - форма
						CAdmin::registration($twig);
						break;
					case 'add':
						# добавление фдминистратора
						CAdmin::add($pdo);
						break;
					case 'logout':
						# выход администратора
						CAdmin::logout();
						break;
					case 'resetpass':
						# сброс пароля администратора - форма
						CAdmin::resetPassword($pdo, $twig);
						break;
					case 'setpass':
						# запись нового пароля администратора в БД
						CAdmin::setPassword($pdo);
						break;
					case 'delete':
						# удаление администратора
						CAdmin::delete($pdo);
						break;
					default:
						die('Неизвестное действие');
				}
			}
			else {
				switch ($act) {
					case 'auth':
						# авторизация администратора
						CAdmin::auth($pdo);
						break;
					case 'login':
						# вход администратора - форма
						CAdmin::login($twig);
						break;
					default:
						die('У вас недостаточно прав для выполнения данного действия');
				}
			}
			break;
		case 'theme':
			if ($admin->isLogedin($pdo)) { #если пользователь залогинен
				switch ($act) {
					case 'manage':
						# управление темами - окно
						CTheme::manage($pdo, $twig);
						break;
					case 'add':
						# добавление темы
						CTheme::add($pdo);
						break;
					case 'delete':
						# добавление темы
						CTheme::delete($pdo);
						break;
					default:
						die('Неизвестное действие');
				}
			}
			else {
				die('У вас недостаточно прав для выполнения данного действия');
			}
			break;
		default:
			die('Неизвестный объект');
	}
}
else { # если контроллер не передан
	if ($admin->isLogedin($pdo)) { #если пользователь уже залогинен
		$template = $twig ->loadTemplate('admin.html');
		$params = array('user'=>$_SESSION['admin']);
		$template->display($params);
	}
	else {
		$template = $twig ->loadTemplate('main.html');
		$params = array();
		$template->display($params);
	}
}
?>
