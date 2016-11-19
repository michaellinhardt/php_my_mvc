<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//FR"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		<title><?php $this->lang('default_titre'); echo ' | '; $this->lang('titre_class')?></title>
		<link rel="shortcut icon" href="<?php echo IMG_HTTP; ?>favicon.png" type="image/x-icon" />
		<link rev="start" href="<?php echo ROOT_HTTP; ?>" title="Accueil" />
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_HTTP; ?>defaut.css">
		<!-- JQUERY START -->
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="http://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
		<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
		<!-- JQUERY END -->
		<!-- BOOSTRAP START -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<!-- BOOTSTRAP END -->
		<script type="text/javascript" src="<?php echo JS_HTTP; ?>dump.js"></script>
		<?php $this->head(); ?>
		<!-- JS CALL WHEN DOCUMENT IS READY -->
		<script type="text/javascript">$(document).ready(function(){  });</script>
		<!-- JS CALL WHEN DOCUMENT IS READY -->
	</head>
	<body>
		<?php include VIEWS_PATH . '/layout-navbar.php'; // inclue la bar de navigation ?>
		<div class="container">
			<?php $this->incView(); ?>
			<?= $this->aView['test'] ?>
			<!-- DIV DE CHARGEMENT AJAX ASYNC -->
			<div id="ajax_loading"></div>
			<!-- DIV D'ERREUR AJAX -->
			<div id="ajax_error"><p><?php $this->lang('ajax_error')?></p></div>
			<!-- DIV DE LA BANNIERE -->
		</div>
	</body>
</html>
