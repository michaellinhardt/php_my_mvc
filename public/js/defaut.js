$(document).ready(function(){
	/*
	 * Innitialisation des variables:
	 */
	sAjaxResponse = '' ;
	/*
	 * Initialisation des dialogues:
	 */
	initAjaxDial();
	// Deconnexion
	$('#_Deconnexion').click(function(){ ajaxAsync('connexion/deconnexion', {}, 'goHome'); });
});

function goHome(iStatu)
{
	/*
	 * Renvoie à la page d'accueil (utiliser pour les déco)
	 */
	if (iStatu==1) window.location.href = sBaseurl ;
	else ajaxError();
}

function ajaxError()
{
	 // Affiche un message d'erreur Ajax
	$('#_ajaxError').dialog('open');
}

function initAjaxDial()
{
	/*
	 * Innitialise la boite de chargement Ajax
	 * et la boite d'erreur par defaut Ajax
	 */
	$('#_ajaxLoading').dialog({
		title: '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ' + oLang['ajax_loading'],
		modal: true,
		resizable: false,
		draggable: false,
		height: 0,
		autoOpen: false
	});
	// Masque le bouton pour fermer la boite
	$('#_ajaxLoading').parent().find('.ui-dialog-titlebar-close').css('display', 'none');
	/*
	 * Innitialise la boite d'erreur Ajax
	 */
	$('#_ajaxError').dialog({
		title: '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ' + oLang['ajax_error_title'],
		modal: true,
		resizable: false,
		draggable: false,
		height: 'auto',
		autoOpen: false
	});
}

function ajaxLoading(iStatu)
{
	/*
	 * Affiche ou masque la boite de chargement ajax
	 * ajaxLoading() ; Masque la fenetre
	 * ajaxLoading(1) ; Affiche la fenetre
	 */
	if ( (iStatu==undefined) || (iStatu==0) )
	{
		$('#_ajaxLoading').dialog('close');
	}
	else
	{
		$('#_ajaxLoading').dialog('open');
	}
}

function ajaxAsync(sPath, oData, sFunc, bDisplayBox)
{
	/*
	 * Requette ajax par defaut
	 * ex: ajaxAsynx( 'index/ajaxmethod', oData, 'function_de_retour' );
	 */
	// Affiche la boite de chargement
	if (bDisplayBox==undefined) bDisplayBox = true ;
	window['sDataAjaxAsync'] = '' ;
	if (bDisplayBox) ajaxLoading(1);
	// Initialise
	if (sFunc==undefined) sFunc = false ;
	// Dans le cas ou on à pas définie oData
	if ( oData == undefined ) oData = {} ;
	// Requete ajax
	$.ajax({
		url: sBaseurl + sPath, // Url  appellé
		async: false, // Mode synchrone (OBLIGATOIRE)
		type: "POST", // Methode pour envoyer les donné
		data: (oData), // Les donné  à envoyer
		success: function(sData) // Fonction executé en cas de réponse
		{
		if (bDisplayBox) ajaxLoading(0); // Cacche la fenetre de chaargement
			sAjaxResponse = sData ; // Stock le retour pour l'envoyer à une fonction
			window['sDataAjaxAsync'] = sData ; // Stock le retour pour le renvoyer à la fonction
			if (sFunc==false) // Renvoie le retour du script
				window['sDataAjaxAsync'] = sAjaxResponse ;
			else
			{
				window[sFunc](sAjaxResponse) ; // Renvoie le retour du script a une fonction
				return true ;
			}
		},
		error: function(){ // Fonction executé si pas de réponse 
			if (bDisplayBox) ajaxLoading(0);
			ajaxError(); // Affiche le message d'erreur par defaut
			return false ;
		}
	});
	return window['sDataAjaxAsync'] ; // Dans le cas ou il n'y à pas d'erreur et pas de fonction de retour
}

function alertVar()
{
	/*
	 * Fonction de débuguage, créer une alert affichant
	 * la valeur de plusieur variable
	 * ex: alertVar(var1,var2,var3);
	 */
	sVar = '' ;
	for ( i = 0; i < arguments.length; i++)
	{
		sVar += '[ i'+i+' ] ' + arguments[i] + "\n" ;
	}
	alert(sVar) ;
}

function emptyVar()
{
	/*
	 * Renvoie true si au moins une variable transmit est vide
	 * ex: if (emptyVar(Var1,Var2)) { alert('Une variable est vide'); }
	 */
	for ( i = 0; i < arguments.length; i++)
	{
		if ((arguments[i]=='') || (arguments[i]==undefined)) return true ;
	}
	return false ;
}