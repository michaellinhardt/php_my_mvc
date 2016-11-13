<?php
class LanguageAppModel
{
	public $aLang ;
	private $sLangPath ;

	public function setLang()
	{
		/*
		 * Charge la langue de l'application
		 * Soit par defaut, soit par la requette de l'utilisateur
		 */
		if ( !isset( $_SESSION['lang'] ) ) $_SESSION['lang'] = strtolower( DEFAUT_LANG ) ;
		$this->sLangPath = PRIVATE_PATH . '/langs/' . $_SESSION['lang'] . '/' ;
		if ( !is_dir( realpath( $this->sLangPath ) ) ) $_SESSION['lang'] = strtolower( DEFAUT_LANG ) ;
		$this->sLangPath = PRIVATE_PATH . '/langs/' . $_SESSION['lang'] . '/' ;
	}
	
	public function incLang( $sIncFile )
	{
		/*
		 * Inclue un fichier de lang supplémentaire,
		 * en plus de celle par defaut et de celle lié à la requette user
		 */
		// Récupére le nom de lang demandé
		$sIncFile = ucfirst( strtolower( $sIncFile ) ) ;
		// Vérifie que ce nom ne correspond ni a la class par defaut ni à la classe courante
		if ( ( $sIncFile != $_SESSION['class'] ) && ( $sIncFile != 'Defaut' ) )
		{
			if (!isset($_SESSION['aIncLang'])) $_SESSION['aIncLang'] = array();
			if (!isset($_SESSION['aIncLang'][$sIncFile])) $_SESSION['aIncLang'][$sIncFile] = true ;
		}
	}

	public function getLang()
	{
		/*
		 * Charge le fichier de lang par defaut et celui lié au controller
		 * puis les stock dans un même tableau
		 * Si la variable $_POST['LangToJs'] est définie,
		 * 	alors on envoie le contenue de la langue en json
		 * Inclue également les lang demandé par la fonction $this->incLang()
		 */
		$sRequestLang = (isset( $_POST['PhpLangToJs'] )) ? strtolower( $_POST['PhpLangToJs'] ) : strtolower( $_SESSION['class'] ) ;
		$sRequestLang = ucfirst( $sRequestLang ) ;
		DebugAppModel::logThis( __FILE__, __LINE__, 'Langue chargé: ' . $_SESSION['lang'] . ' - sRequestLang: ' . $sRequestLang ) ;
		if ( !is_dir( $this->sLangPath ) )
		{
			DebugAppModel::logThis( __FILE__, __LINE__, 'Dossier introuvable: ' . $this->sLangPath ) ;
			return false ;
		}
		if ( !is_file( $this->sLangPath . 'DefautLang.php' ) )
			DebugAppModel::stopApp( __FILE__, __LINE__, 'Impossible de trouver le fichier lang par defaut: DefautLang.php' );
		else require_once $this->sLangPath . 'DefautLang.php' ;
		if ( !is_file( $this->sLangPath . $sRequestLang . 'Lang.php' ) ) ${$sRequestLang . 'Lang'} = array() ;
		else require_once $this->sLangPath . $sRequestLang . 'Lang.php' ;
		/*
		 * Merge les deux table de lang
		 */
		$this->aLang = array_merge( $DefautLang, ${$sRequestLang . 'Lang'} ) ;
		/*
		 * Inclue les lang demandé par $this->incLang();
		 */
		if (isset($_SESSION['aIncLang']))
		{
			foreach ( $_SESSION['aIncLang'] as $sKey => $bValue )
			{
				if ($_SESSION['aIncLang'][$sKey]==true)
				{
					$sLangFilePath = $this->sLangPath . $sKey . 'Lang.php' ;
					if (is_file($sLangFilePath))
					{
						require_once $sLangFilePath ;
						$this->aLang = array_merge( $this->aLang, ${$sKey . 'Lang'}) ;
					}
					else DebugAppModel::stopApp(__FILE__, __LINE__, 'Impossible d\'inclure le fichier de lang: '.$sLangFilePath) ;
				}
			}
		}
		if ( AUTO_HTMLENTITIES_LANG )
		{
			foreach ( $this->aLang as $sKey => $sValue )
			{
				$this->aLang[$sKey] = htmlentities( $sValue ) ;
			}
		}
	}

	public function lang($aArguments)
	{
		/*
		 * Cette fonction s'utilise via la method $this->lang(); du controller view
		 * renvoie le contenu du tableau $this->aLang pour la clé donné dans $aArguments[0]
		 * puis remplace les occurence {1} par $aArguments[1] et {2} par $aArguments[2], etc ...
		 */
		foreach ( $aArguments as $sKey => $sValue )
		{
			if ( $sKey == 0 ) $sReturn = $this->aLang[$sValue] ;
			else
			{
				$sReturn = str_replace( '{' . $sKey . '}', $sValue, $sReturn ) ;
			}
		}
		return $sReturn ;
	}
}