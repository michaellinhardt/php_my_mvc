<?php
class PluginAppModel
{
	/*
	 * Liste de fonction qui se glisse dans l'application à différent endroit
	 * Permet d'ajouter des morceau de code propre à chaque site,
	 * comme la vérification d'un utilisateur connecté ou non ...
	 */
	public function beforeConfig()
	{
	}

	public function afterConfig()
	{
	}
	public function beforeRoutage()
	{
	}

	public function afterRoutage()
	{
		/*
		 * Renvoie vers la page de connexion si on n'est pas connecté ...
		 */
		if ( (!isset($_SESSION['user_id'])) || (empty($_SESSION['user_id'])) )
		{
			if ( ( strtolower($_SESSION['class']) != 'connexion' ) && ( strtolower($_SESSION['class']) != 'e404' ) )
			{
				header('Location: '. ROOT_HTTP . 'connexion/') ;
				exit() ;
			}
		}
	}
	public function beforeController()
	{
	}

	public function afterController()
	{
	}
	public function beforeView()
	{
	}

	public function afterView()
	{
	}
}
