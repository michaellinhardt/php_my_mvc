<form class="form-signin form-connexion" method="post" action="<?= ROOT_HTTP ?>connexion/auth">
	<h2 class="form-signin-heading">Identifiez vous..</h2>
	<label for="user" class="sr-only">Utilisateur</label>
	<input type="text" value="<?= $this->aView['user'] ?>" id="user" name="user" class="form-control" placeholder="Nom de client" required autofocus>
	<input type="password" value="<?= $this->aView['passwd'] ?>" id="passwd" name="passwd" class="form-control" placeholder="Mot de passe" required>
	<button class="btn btn-lg btn-primary btn-block" name="submit" id="submit" type="submit">Connection</button>
	<?php
	if (isset($this->aView['first']))
		echo '<p class="bg-success">'.$this->lang('FIRST_CONNEXION').'</p>';
	else if ($this->aView['return'] > 0)
	{
		echo '<p class="bg-danger">';
		if ($this->aView['return'] == 1)
			echo $this->lang('EMPTY_FIELD');
		else if ($this->aView['return'] == 2)
			echo $this->lang('NO_ACCOUNT');
		echo '</p>';
	}
	?>
</form>
