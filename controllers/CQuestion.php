<?php
class CQuestion
{
	public function __call($name, $arguments) {
		die('Неизвестное действие');
	}

	public function showpublished($pdo, $twig)
	{
		if (isset($_GET['themeid'])) {
			$themeId = clearInput($_GET['themeid']);
			$questions = Question::getPublishedQuestions($themeId,$pdo);
			$themes = Theme::getAllThemes($pdo);
			$currentTheme = new Theme();
			$currentTheme->getThemeById($themeId, $pdo);
			$template = $twig->loadTemplate('main.html');
			$params = array(
				'content' => 'question_published.html',
				'questions' => $questions,
				'currentTheme' => $currentTheme,
				'themes' => $themes
			);
			$template->display($params);
		}
	}

	public function add($pdo, $twig)
	{
		if ((isset($_GET['themeid'])) && (isset($_GET['email'])) && (isset($_GET['text']))){
			$themeId = clearInput($_GET['themeid']);
			$email = clearInput($_GET['email']);
			$text = clearInput($_GET['text']);
			$question = new Question();
			$question->addQuestion($themeId, $email, $text, $pdo);
			header('Location: index.php');
		}
		else {
			die("Ошибка добавления вопроса");
		}
		
	}	
}
?>
