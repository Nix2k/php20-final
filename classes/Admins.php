<?php
class Admins
{
	private $allAdmins;

	public function getAllAdmins($pdo)
	{
		$sql = 'SELECT id FROM admin';
		$data = $pdo->query($sql);
		if ($data) {
			$this->allAdmins = array();
			foreach ($data as $value) {
				$admin = new Admin();
				$admin->getUserById($value['id'], $pdo);
				$this->allAdmins[] = $admin;
			}
			return true;
		}
		else {
			return false;
		}
	}

	public function printAllAdmins()
	{
		foreach ($this->allAdmins as $value) {
			$value->printUserForInfo();
		}
	}
}

?>
