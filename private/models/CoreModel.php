<?php
class CoreModel
{
	public function __construct()
	{
		/*
		 * Innitialise la connexion
		 */
		include CONFIG_PATH . '\DatabaseConfig.php' ;
		$this->oPDO = new PDO(
			'mysql:host=' . $aDbConfig['host'] . ';dbname=' . $aDbConfig['name'] ,
			$aDbConfig['user'],
			$aDbConfig['pass']
		);
		$this->oPDO->exec("SET CHARACTER SET utf8");
	}
	
	public function closeDb()
	{
		if (isset($this->oPDO)) $this->oPDO = NULL ;
	}
}