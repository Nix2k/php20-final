<?php
class CTheme
{
	public function manage($pdo, $twig)
	{
		$themes = new Themes();
		if ($themes->getAllThemes($pdo)) {
			$template = $twig->loadTemplate('admin.html');
			$params = array('user'=>$_SESSION['admin'], 'content' => 'theme_manage.html', 'themes' => $themes);
			$template->display($params);
		}
		else {
			die("Не получена информация о темах");
		}
	}

	public function add($pdo)
	{
		if (isset($_GET['name'])) {
			$name = clearInput($_GET['name']);
			$theme = new Theme();
			if ($theme->getThemeByName($name, $pdo)) {
				die("Тема с таким названием уже существует");
			}
			$theme->addTheme($name, $pdo);
			header('Location: index.php?contr=theme&act=manage');
		}
		else {
			die("Ошибка добавления темы");
		}	
	}

	public function delete($pdo)
	{
		if (isset($_GET['id'])) {
			$id = clearInput($_GET['id']);
			$theme = new Theme();
			$theme->getThemeById($id, $pdo);
			$theme->deleteMe($pdo);
			header('Location: index.php?contr=theme&act=manage');
		}
		else {
			die('Не удалось удалить тему');
		}
	}
	
}
?>
