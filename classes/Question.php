<?php
class Question
{
	private $id;
	private $themeId;
	private $email;
	private $text;
	private $answerId;
	private $blocked;
	private $date;

	public function getQuestionById($id, $pdo)
	{
		$sql = "SELECT * FROM question WHERE id=".$id;
		$data = $pdo->query($sql);
		if ($data) {
			foreach ($data as $question) {
				$this->id = $question['id'];
				$this->themeId = $question['themeId'];
				$this->email = $question['email'];
				$this->text = $question['text'];
				$this->answerId = $question['answerId'];
				$this->blocked = $question['blocked'];
				$this->date = $question['date'];
				return true;
			}
		}
		return false;
	}

	public function getPublishedQuestions($themeId, $pdo)
	{
		$sql = "SELECT id FROM question WHERE themeId=".$themeId." AND answerId IS NOT NULL AND blocked IS NULL";
		$data = $pdo->query($sql);
		if ($data){
			$questions = array();
			foreach ($data as $value) {
				$question = new Question();
				$question->getQuestionById($value['id'], $pdo);
				$questions[] = $question;
			}
			return $questions;
		}
		else
			return false;;
	}

	public function addQuestion($themeId, $email, $text, $pdo)
	{
		$this->themeId = $themeId;
		$this->email = $email;
		$this->text = $text;
		$sql = "INSERT INTO question (`themeId`, `email`, `text`) VALUES ('".$this->themeId."', '".$this->email."', '".$this->text."')";
		return $pdo->exec($sql);
	}

	public function getId()
	{
		return $this->id;
	}

	public function getThemeId()
	{
		return $this->themeId;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getText()
	{
		return $this->text;
	}

	public function getAnswerId()
	{
		return $this->answerId;
	}

	public function getBlocked()
	{
		return $this->blocked;
	}

	public function getDate()
	{
		return $this->date;
	}

}

?>
