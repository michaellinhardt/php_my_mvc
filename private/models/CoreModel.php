<?php
class CoreModel
{
	public function __construct()
	{
		/*
		 * Innitialise la connexion
		 */
		include CONFIG_PATH . '/DatabaseConfig.php' ;
		$this->oPDO = new PDO(
			'mysql:host=' . $aDbConfig['host'] . ';dbname=' . $aDbConfig['name'] ,
			$aDbConfig['user'],
			$aDbConfig['pass']
		);
		return ;
		$this->oPDO->exec("SET CHARACTER SET utf8");
	}

	public function closeDb()
	{
		return ;
		if (isset($this->oPDO)) $this->oPDO = NULL ;
	}

	public function __destruct()
	{
		return ;
		self::closeDb();
	}
}
