<?php
class StrModel extends CoreModel
{
	public function tronquer($sChaine, $iLongueur, $sSymbol = '...' )
	{
		/*
		 * Tronque une chaine de caractére
		 */
		if (strlen($sChaine) > $iLongueur)
		{
			$sChaine = substr($sChaine, 0, $iLongueur);
			$last_space = strrpos($sChaine, " ");
			$sChaine = substr($sChaine, 0, $last_space).$sSymbol;
		}
		
		return $sChaine;
	}
	
	public function httpName( $sChaine )
	{
		/*
		 * Transforme une chaine en nom conforme HTTP
		 */
		$sChaine = strtr($sChaine, 
			'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
			'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
     	$sChaine = preg_replace('/([^.a-z0-9]+)/i', '-', $sChaine);
     	
     	return $sChaine ;
	}
	
	public function is_NumPortable( $sTel )
	{
		$sTel = str_replace( '.', '', $sTel ) ;
		$sTel = str_replace( ' ', '', $sTel ) ;
		$sTel = str_replace( ',', '', $sTel ) ;
		$sTel = str_replace( '-', '', $sTel ) ;
		if ( !preg_match( '/^06\d{8}$/', $sTel ) ) return false ;
		if ($sTel=='0600000000') return false ;
		if ($sTel=='0611111111') return false ;
		if ($sTel=='0622222222') return false ;
		if ($sTel=='0633333333') return false ;
		if ($sTel=='0644444444') return false ;
		if ($sTel=='0655555555') return false ;
		if ($sTel=='0666666666') return false ;
		if ($sTel=='0677777777') return false ;
		if ($sTel=='0688888888') return false ;
		if ($sTel=='0699999999') return false ;
		if ($sTel=='0612345678') return false ;
		return $sTel ;
	}
	
	public function is_NumFix( $sTel )
	{
		$sTel = str_replace( '.', '', $sTel ) ;
		$sTel = str_replace( ' ', '', $sTel ) ;
		$sTel = str_replace( ',', '', $sTel ) ;
		$sTel = str_replace( '-', '', $sTel ) ;
		if ( !preg_match( '/01\d{7,9}/', $sTel ) ) return false ;
		if ($sTel=='0100000000') return false ;
		if ($sTel=='0111111111') return false ;
		if ($sTel=='0122222222') return false ;
		if ($sTel=='0133333333') return false ;
		if ($sTel=='0144444444') return false ;
		if ($sTel=='0155555555') return false ;
		if ($sTel=='0166666666') return false ;
		if ($sTel=='0177777777') return false ;
		if ($sTel=='0188888888') return false ;
		if ($sTel=='0199999999') return false ;
		if ($sTel=='0112345678') return false ;
		if ($sTel=='0123456789') return false ;
		return $sTel ;
	}
	
	public function strMinLen( $sString, $iLongueur )
	{
		if (strlen($sString)<$iLongueur) return false ;
		else return true ;
	}
	
	public function strMaxLen( $sString, $iLongueur )
	{
		if (strlen($sString)>$iLongueur) return false ;
		else return true ;
	}
	
	public function isAlphaNum( $sString )
	{
		/*
		 * Vérifie que la chaine contiens que des caractére Alphanumérique
		 */
		preg_match( '/^[[:alnum:]]+$/', $sString, $aResult ) ;
		if (!empty($aResult)) return true ;
		else return false ;
	}
	
	public function isNum( $sString )
	{
		/*
		 * Vérifie que la chaine contiens que des caractére Alphanumérique
		 */
		preg_match( '/^[[:digit:]]+$/', $sString, $aResult ) ;
		if (!empty($aResult)) return true ;
		else return false ;
	}
	
	public function isMail( $sString )
	{
		if ( !filter_var( $sString, FILTER_VALIDATE_EMAIL) ) return false ;
		else return true ;
	}
	
	public function generatePass( $iNbChar )
	{
		/*
		 * Génération d'un mot de pass
		 */
		$sCharList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@";
		$iCharListNb = strlen($sCharList) ;
		// On créer une boucle qui séléctionne $iNbChar fois un caractére au hasard dans la chaine
		$sReturn = '' ;
		for($u = 1; $u <= $iNbChar; $u++)
		{
			// on choisie un nombre au hasard entre 0 et le nombre de caractéres de la chaine
			$iChar = mt_rand( 0,( $iCharListNb - 1 ) ) ;
			// on ecrit  le résultat
			$sReturn .= $sCharList[$iChar];
		}
		return $sReturn ;
	}
	
	function getCleRib($sCodeBanque, $sCodeGuichet, $sNumeroCompte)
	{
		// Variables locales
		$iCleRib = 0;
		$sCleRib = '';
		 
		// Calcul de la clé RIB à partir des informations bancaires
		$sNumeroCompte = strtr(strtoupper($sNumeroCompte), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ','12345678912345678923456789');
		$iCleRib = 97 - (int) fmod (89 * $sCodeBanque + 15 * $sCodeGuichet + 3 * $sNumeroCompte, 97);
		 
		// Valeur de retour
		if($iCleRib<0)
		{
			$sCleRib = '0'. (string)$iCleRib;
		}
		else
		{
			$sCleRib = (string) $iCleRib;
		}
		 
		return $sCleRib;
	}
}