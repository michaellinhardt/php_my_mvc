<?php
class InscriptionController
{
	public function __construct()
	{
		$this->oUser = new UserModel();
	}

	public function IndexMethod()
	{
		$this->aView['name'] = (!isset($_POST['name'])) ? '' : $_POST['name'];
		$this->aView['email'] = (!isset($_POST['email'])) ? '' : $_POST['email'];
		$this->aView['return'] = 0;
	}

	public function SubmitMethod()
	{
		$this->IndexMethod();
		$this->mSetView = 'inscription/index.php' ;
		$oStr = new StrModel();
		if (!$oStr->isPost('name') || !$oStr->isPost('email') || !$oStr->isPost('passwd') || !$oStr->isPost('passwd2'))
			$this->aView['return'] = 1;
		else if ($_POST['passwd'] != $_POST['passwd2'])
			$this->aView['return'] = 2;
		else if ($this->oUser->existName($_POST['name']))
			$this->aView['return'] = 3;
		else if (!$oStr->isMail($_POST['email']))
			$this->aView['return'] = 4;
		else if (!$oStr->strMinLen($_POST['name'], 4))
			$this->aView['return'] = 5;
		else if (!$oStr->strMinLen(trim($_POST['passwd']), 8))
			$this->aView['return'] = 6;
		else
		{
			$this->oUser->add($_POST['name'], $_POST['email'], trim($_POST['passwd']));
			$this->sRedirect = ROOT_HTTP . 'connexion/first';
		}
		$oStr = NULL;
	}

	public function __destruct()
	{
		$this->oUser = NULL;
	}
}
