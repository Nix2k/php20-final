<?php
class Themes
{
	private $allThemes;

	public function getAllThemes($pdo)
	{
		$sql = 'SELECT id FROM theme';
		$data = $pdo->query($sql);
		if ($data) {
			$this->allTheses = array();
			foreach ($data as $value) {
				$theme = new Theme();
				$theme->getThemeById($value['id'], $pdo);
				$this->allThemes[] = $theme;
			}
			return true;
		}
		else {
			return false;
		}
	}

	public function printAllThemes()
	{
		foreach ($this->allThemes as $value) {
			$value->printThemeForInfo();
		}
	}
}

?>
