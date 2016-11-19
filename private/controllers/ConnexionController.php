<?php
class ConnexionController
{
	public function __construct()
	{
		$this->oUser = new UserModel();
	}

	public function IndexMethod()
	{
		$this->aView['user'] = (!isset($_POST['user'])) ? '' : $_POST['user'];
		$this->aView['return'] = 0;
	}

	public function FirstMethod()
	{
		$this->IndexMethod();
		$this->mSetView = 'connexion/index.php' ;
		$this->aView['first'] = 1;
	}

	public function AuthMethod()
	{
		$this->IndexMethod();
		$this->mSetView = 'connexion/index.php' ;
		if (!isset($_POST['user']) || !isset($_POST['passwd']) || empty($_POST['user']) || empty($_POST['passwd']))
			$this->aView['return'] = 1;
		else if (!$this->oUser->auth($_POST['user'], $_POST['passwd']))
			$this->aView['return'] = 2;
		else
			$this->sRedirect = ROOT_HTTP;
	}

	public function __destruct()
	{
		$this->oUser = NULL;
	}
}
