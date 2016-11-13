<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//FR"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<title><?php $this->lang('defaut_titre') ; $this->lang('titre_class')?></title>
		<link rel="shortcut icon" href="<?php echo IMG_HTTP; ?>favicon.png" type="image/x-icon" />
		<link rev="start" href="<?php echo ROOT_HTTP; ?>" title="Accueil" />
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_HTTP; ?>defaut.css">
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_HTTP; ?>jquery.css">
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_HTTP; ?>superfish.css">
		<script type="text/javascript" src="<?php echo JS_HTTP; ?>jquery/jquery.js"></script>
		<script type="text/javascript" src="<?php echo JS_HTTP; ?>jquery/jqueryui.js"></script>
		<script type="text/javascript" src="<?php echo JS_HTTP; ?>superfish.js"></script>
		<script type="text/javascript" src="<?php echo JS_HTTP; ?>dump.js"></script>
		<?php $this->head(); ?>
		<script type="text/javascript">$(document).ready(function(){ jQuery('ul.sf-menu').superfish(); });</script>
	</head>
	<body>
		<!-- DIV DE CHARGEMENT AJAX ASYNC -->
		<div id="_ajaxLoading"></div>
		<!-- DIV D'ERREUR AJAX -->
		<div id="_ajaxError"><p><?php $this->lang('ajax_error')?></p></div>
		<!-- DIV DE LA BANNIERE -->
		<div id="_TopBanner">
			<a id="_TopBannerLogo" href="<?php echo ROOT_HTTP?>"><?php $this->lang('defaut_titre')?></a>
			<!-- DIV DU MENU -->
			<?php include VIEWS_PATH . '/menu.php' ; ?>
		</div>
		<hr class="_Clear"/>
		<div id="_Contenu">
			<?php $this->incView(); ?>
		</div>
	</body>
</html>