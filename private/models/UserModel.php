
<?php
class UserModel extends CoreModel
{
	/*
	 * Cette class gére la connexion/déconnexion au back office
	 * Ainsi que la liste des droit attribué à un compte
	 * log_detail.LDID = 1 // ID des log de connexion
	 */
	
	public function getAllJob()
	{
		return $this->oPDO->query('SELECT * FROM bo_job')->fetchAll(PDO::FETCH_ASSOC) ;
	}
	
	public function getAllFai()
	{
		return $this->oPDO->query('SELECT * FROM bo_fai')->fetchAll(PDO::FETCH_ASSOC) ;
	}
	
	public function getAllMobile()
	{
		return $this->oPDO->query('SELECT * FROM bo_mobile')->fetchAll(PDO::FETCH_ASSOC) ;
	}
	
	public function DebugUserReset()
	{
		unset($_SESSION['iDebugUser']) ;
		unset($_SESSION['iDeleteUser']) ;
		return true ;
	}
	
	public function DebugUser()
	{
		// Initialisation
		if (!isset($_SESSION['iDebugUser']))
		{
			$aRequest = $this->oPDO->query('SELECT COUNT(*) FROM users')->fetch();
			$aReturn['iNbUserDrupal'] = $aRequest[0] ;
			$aRequest = $this->oPDO->query('SELECT COUNT(*) FROM bo_user')->fetch();
			$aReturn['iNbUser'] = $aRequest[0] ;
			$_SESSION['iDebugUser'] = 0 ;
			return $aReturn ;
		}
		
		// Récupère l'user ID à traité pour cette session
		$aUsers = $this->oPDO->query('SELECT * FROM users ORDER BY uid ASC LIMIT '.$_SESSION['iDebugUser'].',1')->fetch();
		if (!$aUsers) // Opération d'ajout / modification terminé
		{
			/*
			 * Supprime les entré en trop dans la table bo_user
			 */
			$oRequest = $this->oPDO->query('SELECT bo_user.UID FROM bo_user WHERE bo_user.UID NOT IN (SELECT UID FROM users WHERE UID=bo_user.UID) LIMIT 0,1')->fetch();
			if (!$oRequest) // Opération de suppression terminé
			{
				// Modifi l' AUTO_INCREMENT
				$oRequest = $this->oPDO->query('SELECT UID FROM bo_user ORDER BY UID DESC LIMIT 0,1')->fetch();
				$iAutoInc = intval($oRequest['UID']) + 1 ;
				$this->oPDO->query('ALTER TABLE `bo_user` AUTO_INCREMENT ='.$iAutoInc);
				$bEndUser = true ;
			}
			else
			{
				// Supprime cet user de bo_user (car ne se trouve pas dans users
				$aReturn['action'] = 3 ;
				$aReturn['UID'] = $oRequest['UID'] ;
				$this->oPDO->query('DELETE FROM bo_user WHERE UID='.$oRequest['UID']);
				$bEndUser = false ;
			}
			/*
			 * Supprime les entré en trop dans la table bo_user_adresse
			 */
			$oRequest = $this->oPDO->query('SELECT bo_user_adresse.UID FROM bo_user_adresse WHERE bo_user_adresse.UID NOT IN (SELECT UID FROM users WHERE UID=bo_user_adresse.UID) LIMIT 0,1')->fetch();
			if (!$oRequest) $bEndUserAdresse = true ; // Terminé
			else
			{
				// Supprime cet user de bo_user (car ne se trouve pas dans users
				$aReturn['action'] = 4 ;
				$aReturn['UID'] = $oRequest['UID'] ;
				$this->oPDO->query('DELETE FROM bo_user_adresse WHERE UID='.$oRequest['UID']);
				$bEndUserAdresse = false ;
			}
			if (($bEndUser) && ($bEndUserAdresse))
			{
				$this->oPDO->query('DELETE FROM bo_user_adresse WHERE UID=0');
				$aReturn['end'] = true ;
			}
			return $aReturn ; // Envoie le résulta (sois terminé, sois user supprimé)
		}
		// Définie si on ajoute ou modifie et prépare la requete
		$aCount = $this->oPDO->query('SELECT * FROM bo_user WHERE UID='.$aUsers['uid'])->fetch();
		$sRequest = 'UID=:UID, login=:login, pass=:pass, mail=:mail, model=:model, registered=:registered, tel_por=:tel_por, tel_fix=:tel_fix, tel_fax=""' ;
		if (!$aCount)
		{
			$sRequest = 'INSERT INTO bo_user SET ' . $sRequest ;
			$aReturn['action'] = 1 ;
		}
		else
		{
			$sRequest = 'UPDATE bo_user SET ' . $sRequest . ' WHERE UID='.$aUsers['uid'] ;
			$aReturn['action'] = 2 ;
		}
		/*
		 * Récupère les données dans ldapprov pour les inséré dans bo_user_info
		 */
		$oRequest = $this->oPDO->query('DELETE FROM bo_user_adresse WHERE UID='.$aUsers['uid'])->fetch();
		$aRequest = $this->oPDO->query('SELECT ldapprov.data FROM ldapprov WHERE uid='.$aUsers['uid'])->fetch();
		if ($aRequest)
		{
			// Capture le contenu du champ data
			preg_match_all( '/"(.*?)"/', $aRequest['data'], $aData );			
			// Supprime les entré puis les re-créer
			$oRequest = $this->oPDO->prepare('INSERT INTO bo_user_adresse SET adresse_rue=:adresse_rue, adresse_sup=:adresse_sup, cp=:cp, ville=:ville, pays=:pays, residence=:residence, batiment=:batiment, etage=:etage, chambre=:chambre, UID='.$aUsers['uid']);
			// Prépare les variable
			$sAdresseSup = '' ;
			$sAdresseRue = '' ;
			$sCp = '' ;
			$sVille = '' ;
			$sPays = '' ;
			$sResidence = '' ;
			$sBatiment = '' ;
			$sEtage = '' ;
			$sChambre = '' ;
			$iTel = '' ;			
			foreach($aData[1] as $iKey => $sValue)
			{
				// Capture les donné du champ data
				$iKeyNext = $iKey + 1 ;
				if ($sValue=='profile_adresse') $sAdresseRue = $aData[1][$iKeyNext] ;
				if ($sValue=='profile_adresse_complementaire') $sAdresseSup = $aData[1][$iKeyNext] ;
				if ($sValue=='profile_cp') $sCp = $aData[1][$iKeyNext] ;
				if ($sValue=='profile_city') $sVille = $aData[1][$iKeyNext] ;
				if ($sValue=='profile_pays') $sPays = $aData[1][$iKeyNext] ;
				if ($sValue=='profile_tel') $iTel = $aData[1][$iKeyNext] ;
				if ($sValue=='profile_residence') $sResidence = $aData[1][$iKeyNext] ;
				if ($sValue=='profile_batiment') $sBatiment = $aData[1][$iKeyNext] ;
				if ($sValue=='profile_etage') $sEtage = $aData[1][$iKeyNext] ;
				if ($sValue=='profile_num_chambre') $sChambre = $aData[1][$iKeyNext] ;
			}
			$oRequest->bindValue(':adresse_rue', $sAdresseRue );
			$oRequest->bindValue(':adresse_sup', $sAdresseSup );
			$oRequest->bindValue(':cp', $sCp );
			$oRequest->bindValue(':ville', $sVille );
			$oRequest->bindValue(':pays', $sPays );
			$oRequest->bindValue(':residence', $sResidence );
			$oRequest->bindValue(':batiment', $sBatiment );
			$oRequest->bindValue(':etage', $sEtage );
			$oRequest->bindValue(':chambre', $sChambre );
			$oRequest->execute();
		}
		if (!isset($iTel)) $iTel = '' ;
		$iTelType = substr($iTel, 0, 2) ; // Récupère les deux premier chiffre du num
		if ($iTelType=='06')
		{
			$iTelPor = $iTel ;
			$iTelFix = '' ;
		}
		else if ($iTelType=='01')
		{
			$iTelPor = '' ;
			$iTelFix = $iTel ;
		}
		else
		{
			$iTelPor = '' ;
			$iTelFix = '' ;
		}
		$oRequest = $this->oPDO->prepare($sRequest) ;
		// Construit les info de la table bo_user
		$oRequest->bindValue(':tel_por', $iTelPor);
		$oRequest->bindValue(':tel_fix', $iTelFix);
		$oRequest->bindValue(':UID', $aUsers['uid'] );
		$oRequest->bindValue(':login', $aUsers['name'] );
		$oRequest->bindValue(':pass', $aUsers['pass'] );
		$oRequest->bindValue(':mail', $aUsers['mail'] );
		// Récupère le role
		$aRole = $this->oPDO->query('SELECT RID FROM users_roles WHERE UID='.$aUsers['uid'])->fetch(PDO::FETCH_ASSOC);
		$sModel = ($aRole['RID']=='3') ? 'b2b' : 'b2c' ;
		$oRequest->bindValue(':model', $sModel) ;
		$oRequest->bindValue(':registered', date('Y-m-d', $aUsers['created']) );
		// Execute la requete
		$oRequest->execute();
		// Incrémente le compte et renvoie la réponse
		$_SESSION['iDebugUser']++ ;
		$aReturn['UID'] = $aUsers['uid'] ;
		return $aReturn ; // Envoie le résultat (ajouté ou modifié)
	}
}