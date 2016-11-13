<?php
/*
 * Cette class est le "processeur" ou "driver" de l'app, elle commande 
 * les différente class successivement utilisé dans l'app
 * comme le ferais le controller avec le model et la view
 */
class Bootstrap
{
	private $oRoutage ; // Contient la class de routage
	private $oController ; // Contient la class qui gère les controller
	private $oView ; // Contient la class qui gère les views
	private $aView ; // Variable transmit du controller à la view
	/*
	 * *mSetView Détermine l'affichage de la view
	 * true ou false pour oui et non
	 * 'string' pour cibler une view différente de celle par defaut
	 */
	private $mSetView ;
	private $mSetLayout ; // Même fonctionnement que $mSetView mais pour le layout
	private $bRequestDispatch ; // détermine si le controller à déjà était chargé ou non

	public function __construct()
	{
		session_start() ;
		/*
		 * Si $_SESSION['bRequestDispatch'] = true, alors le Controller à déjà était innitialisé
		 * Dans se cas on ne peut plus rediriger l'utilisateur que par la method
		 * header(); dans le cas contraire, on peu le rediriger en changeant le contenu
		 * de $_SESSION['class'] et $_SESSION['method']
		 */
		$_SESSION['bRequestDispatch'] = false ;
	}

	public function run()
	{
		/*
		 * Lance et pilote l'application
		 * NB: Tout les if method_exists permette de lancer des fonction propre à chaque application
		 * avant et/ou après chaque étape du bootstrap
		 */
		// Charge la config de l'application (et non du site)
		if (method_exists('PluginAppModel', 'beforeConfig')) PluginAppModel::beforeConfig() ;
		$this->getConfig() ;
		if (method_exists('PluginAppModel', 'afterConfig')) PluginAppModel::afterConfig() ;
		DebugAppModel::resetDebug() ; // Reset les log de debuguage
		DebugAppModel::logDetail() ; // Log les détail si la config le demande
		// Initialise le routage (récupére la class et la method)		
		if (method_exists('PluginAppModel', 'beforeRoutage')) PluginAppModel::beforeRoutage() ;
		$this->setRoutage() ;
		if (method_exists('PluginAppModel', 'afterRoutage')) PluginAppModel::afterRoutage() ;
		// Initialise le controller
		if (method_exists('PluginAppModel', 'beforeController')) PluginAppModel::beforeController() ;
		$this->initController() ;
		if (method_exists('PluginAppModel', 'afterController')) PluginAppModel::afterController() ;
		// Innitialise la view
		if (method_exists('PluginAppModel', 'beforeView')) PluginAppModel::beforeView() ;
		$this->initView() ;
		if (method_exists('PluginAppModel', 'afterView')) PluginAppModel::afterView() ;
	}

	private function getConfig()
	{
		/*
		 * Charge et applique la configuration de l'application
		 */
		require_once COREAPP_PATH . '/configs/CoreConfigs.php' ;
		ini_set( 'display_errors', DISPLAY_ERRORS ) ;
	}

	private function setRoutage()
	{
		/*
		 * Pilote le model de routage, il permet de lire la requette HTTP de l'utilisateur
		 * et de savoir quel couple class/method dois être lancé
		 */
		$this->oRoutage = new RoutageAppModel( ) ;
		$this->oRoutage->getRequest() ;
		$this->oRoutage->formatRequest() ;
		$this->oRoutage->verifRequest() ;
		$this->oRoutage->logThis() ;
	}

	private function initController()
	{
		/*
		 * Instancie la class gérant les controller et la pilote
		 */
		$this->oController = new CoreAppController( ) ;
		$this->oController->setConfig() ;
		/*
		 * $_SESSION['bRequestDispatch'] = true car à partir d'ici on ne peut plus
		 * rediriger l'utilisateur, sauf avec la method header();
		 */
		$_SESSION['bRequestDispatch'] = true ;
		$this->oController->setResponse() ;
		$this->oController->initResponse() ;
		$this->oController->startMethod() ;
		$this->oController->urlMethod() ;
		$this->oController->endMethod() ;
		$this->oController->getControllerParam() ;
		$this->oController->logThis() ;
		/*
		 * Récupére les variables à transmettre à la view
		 */
		if ( isset( $this->oController->aView ) ) $this->aView = $this->oController->aView ;
		$this->mSetView = $this->oController->mSetView ;
		$this->mSetLayout = $this->oController->mSetLayout ;
	}

	private function initView()
	{
		/*
		 * Instancie la class gérant la view et la pilote
		 */
		$this->oView = new CoreAppView( ) ;
		/*
		 * Injecte les variables du controller
		 * NB: A propos de setLayout et setView (transmis par lecontroller)
		 * si setLayout/setView = true -> la class va utiliser le layout/view associé
		 * si setLayout/setView = false -> la classe ne va pas les utiliser
		 * si setLayout/setView = string -> la class va chercher le fichier en question
		 */
		$this->oView->mSetLayout = $this->mSetLayout ;
		$this->oView->mSetView = $this->mSetView ;
		$this->oView->aView = $this->aView ;
		/*
		 * Pilote la class
		 */
		$this->oView->getLang() ;
		$this->oView->display() ;
	}
}