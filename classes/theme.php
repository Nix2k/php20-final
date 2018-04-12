<?php
	class Theme
	{
		private $id;
		private $name;
		private $numOfQuestion;
		private $published;
		private $unanswered;

		public function getThemeById($id, $pdo)
		{
			$sql = "SELECT * FROM theme WHERE id=".$id;
			$data = $pdo->query($sql);
			if ($data) {
				foreach ($data as $value) {
					$this->id = $value['id'];
					$this->name = $value['theme'];
				}
				$sql = "SELECT * FROM question WHERE themeId=".$this->id;
				$data = $pdo->query($sql);
				if ($data) 
					$this->numOfQuestion = $data->rowCount();
				else
					$this->numOfQuestion = 0;
				$sql = "SELECT * FROM question WHERE themeId=".$this->id." AND answerId IS NOT NULL AND blocked IS NULL";
				$data = $pdo->query($sql);
				if ($data)
					$this->published = $data->rowCount();
				else
					$this->published = 0;
				$sql = "SELECT * FROM question WHERE themeId=".$this->id." AND answerId IS NULL";
				$data = $pdo->query($sql);
				if ($data)
					$this->unanswered = $data->rowCount();
				else
					$this->unanswered = 0;
				return true;
			}
			return false;
		}

		public function getThemeByName($name, $pdo)
		{
			$sql = "SELECT * FROM theme WHERE theme='".$name."'";
			$data = $pdo->query($sql);
			if ($data) {
				if ($data->rowCount()==0)
					return false;
				foreach ($data as $value) {
					$this->id = $value['id'];
					$this->name = $value['theme'];
				}
				return true;
			}
			return false;
		}

		public function addTheme($name, $pdo)
		{
			$this->name = $name;
			$sql = "INSERT INTO theme (theme) VALUES ('".$this->name."')";
			return $pdo->exec($sql);
		}

		public function printThemeForInfo()
		{
			echo "<tr>
				<td>$this->name</td>
				<td>$this->numOfQuestion</td>
				<td>$this->published</td>
				<td>$this->unanswered</td>
				<td><a href='index.php?contr=theme&act=delete&id=$this->id'>Удалить</a></td>
			</tr>";
		}

		public function getId ()
		{
			return $this->id;
		}

		public function getName ()
		{
			return $this->name;
		}

		public function deleteMe($pdo)
		{
			$sql = "DELETE FROM theme WHERE id=".$this->id;
			if ($pdo->exec($sql)==1) {
				return true;
			}
			else {
				return false;
			}
		}

	}
?>
