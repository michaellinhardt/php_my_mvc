<?php
class AuthModel extends CoreModel
{
	/*
	 * Cette class gére la connexion/déconnexion au back office
	 * Ainsi que la liste des droit attribué à un compte
	 * log_detail.LDID = 1 // ID des log de connexion
	 */
	public function AjaxAuth()
	{
		/*
		 * Connect un utilisateur via une requette Ajax
		 */
		// Si une des variable est vide
		if ( (empty($_POST['sLogin'])) || (empty($_POST['sPass'])) ) return 1 ;
		// Prépare et envoie la requete SQL
		$oSql = $this->oPDO->prepare('SELECT AID FROM bo_admin WHERE login=:login AND pass=:pass');
		$oSql->bindValue(':login', $_POST['sLogin']);
		$oSql->bindValue(':pass', $_POST['sPass']);
		$oSql->execute();
		$aResult = $oSql->fetch(PDO::FETCH_ASSOC);
		// Si aucun résulta ne correspond, erreur 2
		if (!$aResult)
		{
			// array( UID, LOGIN, PASS, SUCCESS );
			LogModel::logThis(1, array( '', $_POST['sLogin'], $_POST['sPass'], 0 ));
			return 2 ;
		}
		// Sinon on sauvegarde l'id utilisateur et on retourne 3
		$_SESSION['user_id'] = $aResult['AID'] ;
		// array( UID, LOGIN, PASS, SUCCESS );
		LogModel::logThis(1, array( $_SESSION['user_id'], $_POST['sLogin'], $_POST['sPass'], 1 ));
		return 3 ;
	}
	
	public function AjaxDeconnexion()
	{
		session_destroy();
		return 1 ;
	}
}