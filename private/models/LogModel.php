<?php
class LogModel extends CoreModel
{
	public function logThis( $iLCID, $aValue )
	{
		/*
		 * Innitialise la connexion
		 */
		include CONFIG_PATH . '\DatabaseConfig.php' ;
		$oPDO = new PDO(
			'mysql:host=' . $aDbConfig['host'] . ';dbname=' . $aDbConfig['name'] ,
			$aDbConfig['user'],
			$aDbConfig['pass']
		);
		// Créer la requette SQL
		$sSQL = 'INSERT INTO log_value SET LCID=:LCID' ;
		for( $i = 0 ; $i<10 ; $i++)
		{
			$sSQL .= ', value_' . $i . '=:value_' . $i ;
		}
		$sSQL .= ', ip=:ip, when=:when' ;
		$oSQL = $oPDO->prepare($sSQL) ;
		// Boucle destiné à logué toutes les value passé
		for( $i = 0 ; $i<10 ; $i++)
		{
			if (isset($aValue[$i]))
				$oSQL->bindValue( ':value_'.$i, $aValue[$i] );
			else
				$oSQL->bindValue( ':value_'.$i, '' );
		}
		// Log l'IP et l'id dans log_detail
		$oSQL->bindValue( ':when', date('Y-m-d') );
		$oSQL->bindValue( ':ip', $_SERVER['REMOTE_ADDR'] );
		$oSQL->bindValue( ':LCID', $iLCID );
		// Execute la requette et se déconnect
		$oSQL->execute();
		$oPDO = NULL ; // Déconnexion SQL
	}
	
	public function getAll()
	{
		$aLogDetail = $this->oPDO->query('SELECT * FROM log_detail')->fetchAll(PDO::FETCH_ASSOC);
		$this->oPDO = NULL ;
		return $aLogDetail ;
	}
	
	public function getInfo()
	{
		/*
		 * Récupère toutes les entré de log_value pour un LDID donné
		 * comprends une liste de paramètre transmis en POST
		 */
		// Construit le début de la requette
		$sSQL = 'SELECT * FROM log_value WHERE LDID=:LDID' ;
		// Option de trie
		if ( $_POST['sOrderBy'] == 'date' ) $sSQL .= ' ORDER BY date' ;
		elseif ( ( $_POST['sOrderBy'] > -1 ) || ( $_POST['sOrderBy'] < 10 ) ) $sSQL .= ' ORDER BY `value_' . $_POST['sOrderBy'].'`' ;
		else return 0 ; // Erreur
		if ($_POST['bDesc']) $sSQL .= ' DESC' ;
		else $sSQL .= ' ASC' ;
		// Détermine la page à afficher
		$sSQL .= ' LIMIT ' . $_POST['iPageStart'] . ',' . $_POST['iPageLimit'] ;
		// Lancement de la requette
		$oSQL = $this->oPDO->prepare($sSQL);
		$oSQL->bindValue(':LDID', $_POST['iLDID']);
		$oSQL->execute();
		$aValue = $oSQL->fetchAll(PDO::FETCH_ASSOC) ;
		return $aValue ;
	}
}