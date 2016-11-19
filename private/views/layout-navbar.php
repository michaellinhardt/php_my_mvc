<?php $a = ' class="active"'; // définie un lien comme actif ?>
<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	<a class="navbar-brand" href="<?= ROOT_HTTP ?>"><?php $this->lang('navbar_title') ?></a>
	</div>
	<div id="navbar" class="navbar-collapse collapse">
		<ul class="nav navbar-nav">
			<?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) { ?>
			<li class="<?php if ($iPage == 4) echo 'active '; ?>dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administration <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="./admin.php?p=add">Ajout produit</a></li>
              </ul>
            </li>
			<?php } ?>
			<li<?php if ($iPage == 1) echo $a ?>><a href="<?= ROOT_HTTP ?>">Accueil</a></li>
			<li<?php if ($iPage == 2) echo $a ?>><a href="<?= ROOT_HTTP . 'about' ?>">A propos</a></li>
			<?php if ($iPage != 3 ) { ?>
				<li>
					<a data-toggle="modal" data-target="#myModal" href="#">
					Panier &nbsp;<span class="badge">3</span></a>
				</li>
			<?php } ?>
			<?php if ($iPage == 1) include './layout/sort.php'; ?>
			<?php if ($iPage == 1) include './layout/paginnation.php'; ?>
	  	</ul>
		<?php
			if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id']))
				echo '<a href="'.ROOT_HTTP.'inscription'.'" class="inscription btn btn-success btn-sm navbar-right" role="button">Inscription</a>&nbsp;<a href="'.ROOT_HTTP.'connexion'.'" class="inscription btn btn-primary btn-sm navbar-right" role="button">Connexion</a>';
			else
				echo '<button type="button" id="deco" data-toggle="modal" data-target="#deco_modal" class="btn btn-danger btn-sm navbar-right"><span class="glyphicon glyphicon-remove"></span></button>';
		?>
	</div>
  </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="deco_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php $this->lang('DISCONNECT_TITLE') ?></h4>
      </div>
      <div class="modal-body"><?php $this->lang('DISCONNECT') ?></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <a href="<?= ROOT_HTTP . 'deconnexion' ?>"><button type="button" class="btn btn-danger">Déconnection</button></a>
      </div>
    </div>
  </div>
</div>
