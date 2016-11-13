<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//FR"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<title><?php $this->lang('default_titre'); echo ' | '; $this->lang('titre_class')?></title>
		<link rel="shortcut icon" href="<?php echo IMG_HTTP; ?>favicon.png" type="image/x-icon" />
		<link rev="start" href="<?php echo ROOT_HTTP; ?>" title="Accueil" />
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_HTTP; ?>defaut.css">
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_HTTP; ?>jquery.css">
		<script type="text/javascript" src="<?php echo JS_HTTP; ?>jquery/jquery.js"></script>
		<script type="text/javascript" src="<?php echo JS_HTTP; ?>jquery/jqueryui.js"></script>
		<script type="text/javascript" src="<?php echo JS_HTTP; ?>dump.js"></script>
		<?php $this->head(); ?>
		<script type="text/javascript">$(document).ready(function(){  });</script>
	</head>
	<body>
		<!-- DIV DE CHARGEMENT AJAX ASYNC -->
		<div id="ajax_loading"></div>
		<!-- DIV D'ERREUR AJAX -->
		<div id="ajax_error"><p><?php $this->lang('ajax_error')?></p></div>
		<!-- DIV DE LA BANNIERE -->
		<hr class="clear"/>
		<div id="content">
			<?php $this->incView(); ?>
		</div>
	</body>
</html>
