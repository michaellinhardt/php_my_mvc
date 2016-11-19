<?php
class DeconnexionController
{
	public function IndexMethod()
	{
		session_destroy();
		header('Location: '. ROOT_HTTP . 'connexion');
		exit();
	}
}
