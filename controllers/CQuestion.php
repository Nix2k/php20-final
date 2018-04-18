<?php
class CQuestion
{
	public function __call($name, $arguments) {
		die('Неизвестное действие');
	}

	public function showallintheme($pdo, $twig)
	{
		$admin = new Admin();
		if (!$admin->isLogedin($pdo)) header('Location: index.php?contr=admin&act=login');
		if (isset($_GET['themeid'])) {
			$themeId = clearInput($_GET['themeid']);
			$questions = Question::getAllQuestions($themeId,$pdo);
			$currentTheme = new Theme();
			$currentTheme->getThemeById($themeId, $pdo);
			$template = $twig->loadTemplate('admin.html');
			$params = array(
				'content' => 'question_all_in_theme.html',
				'questions' => $questions,
				'currentTheme' => $currentTheme
			);
			$template->display($params);
		}	
	}

	public function showall($pdo, $twig)
	{
		$admin = new Admin();
		if (!$admin->isLogedin($pdo)) header('Location: index.php?contr=admin&act=login');
		$template = $twig->loadTemplate('admin_header.html');
		$params = array();
		$template->display($params);
		$themes = Theme::getAllThemes($pdo);
		foreach ($themes as $theme) {
			$themeId = $theme->getId();
			$questions = Question::getAllQuestions($themeId,$pdo);
			$template = $twig->loadTemplate('question_all_in_theme.html');
			$params = array(
				'questions' => $questions,
				'currentTheme' => $theme
			);
			$template->display($params);
		}
		$template = $twig->loadTemplate('admin_footer.html');
		$params = array();
		$template->display($params);	
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

	public function delete($pdo, $twig)
	{
		$admin = new Admin();
		if (!$admin->isLogedin($pdo)) header('Location: index.php?contr=admin&act=login');
		if (isset($_GET['questionid'])) {
			$questionId = clearInput($_GET['questionid']);
			$question = new Question();
			$question->getQuestionById($questionId, $pdo);
			$question->deleteme($pdo);
		}
		header('Location: index.php?contr=question&act=showall');
	}
	
	public function block($pdo, $twig)
	{
		$admin = new Admin();
		if (!$admin->isLogedin($pdo)) header('Location: index.php?contr=admin&act=login');
		if (isset($_GET['questionid'])) {
			$questionId = clearInput($_GET['questionid']);
			$question = new Question();
			$question->getQuestionById($questionId, $pdo);
			$question->block($pdo);
		}
		header('Location: index.php?contr=question&act=showall');	
	}

	public function unblock($pdo, $twig)
	{
		$admin = new Admin();
		if (!$admin->isLogedin($pdo)) header('Location: index.php?contr=admin&act=login');
		if (isset($_GET['questionid'])) {
			$questionId = clearInput($_GET['questionid']);
			$question = new Question();
			$question->getQuestionById($questionId, $pdo);
			$question->unblock($pdo);
		}
		header('Location: index.php?contr=question&act=showall');
	}

	public function answer($pdo, $twig)
	{
		$admin = new Admin();
		if (!$admin->isLogedin($pdo)) header('Location: index.php?contr=admin&act=login');
		if (isset($_GET['questionid'])){
			$questionId = clearInput($_GET['questionid']);
			$question = new Question();
			$question->getQuestionById($questionId, $pdo);
			$template = $twig->loadTemplate('admin.html');
			$params = array(
				'content' => 'answer.html',
				'question' => $question
			);
			$template->display($params);
		}
	}

	public function addanswer($pdo, $twig)
	{
		$admin = new Admin();
		if (!$admin->isLogedin($pdo)) header('Location: index.php?contr=admin&act=login');
		if ((isset($_GET['questionid'])) && (isset($_GET['answer']))){
			$questionId = clearInput($_GET['questionid']);
			$answer = clearInput($_GET['answer']);
			$question = new Question();
			$question->getQuestionById($questionId, $pdo);
			$question->answer($answer,$pdo);
			header('Location: index.php?contr=question&act=showall');
		}
		else {
			die("Ошибка добавления ответа");
		}
	}

}
?>
