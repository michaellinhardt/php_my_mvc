<div class="row">
	<form class="form-horizontal" method="post" action="<?= ROOT_HTTP ?>inscription/submit">
		<fieldset>

		<legend><h2><?php $this->lang('TITLE') ?></h2></legend>

		<div class="form-group">
			<label class="col-md-4 control-label" for="textinput"><?php $this->lang('NAME') ?></label>
			<div class="col-md-4">
			<input id="name" name="name" placeholder="<?php $this->lang('NAME_LEGEND') ?>" class="form-control input-md" required value="<?= $this->aView['name'] ?>" type="text" autofocus>
			<span class="help-block"> </span>
			</div>
		</div>

		<!-- Text input-->
		<div class="form-group">
			<label class="col-md-4 control-label" for="textinput"><?php $this->lang('EMAIL') ?></label>
			<div class="col-md-4">
				<input id="email" name="email" placeholder="<?php $this->lang('EMAIL_LEGEND') ?>" class="form-control input-md" required value="<?= $this->aView['email'] ?>" type="email">
				<span class="help-block"> </span>
			</div>
		</div>

		<!-- Text input-->
		<div class="form-group">
			<label class="col-md-4 control-label" for="textinput"><?php $this->lang('PASSWORD') ?></label>
			<div class="col-md-4">
				<input id="passwd" name="passwd" placeholder="<?php $this->lang('PASSWORD_LEGEND') ?>" class="form-control input-md" required type="password">
				<span class="help-block"> </span>
			</div>
		</div>

		<!-- Text input-->
		<div class="form-group">
			<label class="col-md-4 control-label" for="textinput"><?php $this->lang('PASSWORD_CONFIRM') ?></label>
			<div class="col-md-4">
				<input id="passwd2" name="passwd2" placeholder="<?php $this->lang('PASSWORD_CONFIRM_LEGEND') ?>" class="form-control input-md" required type="password">
				<span class="help-block"> </span>
			</div>
		</div>

		<!-- Button -->
		<div class="form-group">
			<label class="col-md-4 control-label" for="singlebutton"> </label>
			<div class="col-md-4">
				<button id="submit" name="submit" class="btn btn-primary"><?php $this->lang('SUBMIT') ?></button>
			</div>
		</div>

		<?php
		if ($this->aView['return'] > 0)
		{
			echo '<p class="bg-danger">';
			if ($this->aView['return'] == 1)
				echo $this->lang('EMPTY_FIELD');
			else if ($this->aView['return'] == 2)
				echo $this->lang('BAD_PASSWD');
			else if ($this->aView['return'] == 3)
				echo $this->lang('BAD_NAME');
			else if ($this->aView['return'] == 4)
				echo $this->lang('BAD_MAIL');
			else if ($this->aView['return'] == 5)
				echo $this->lang('BAD_NAME2');
			else if ($this->aView['return'] == 6)
				echo $this->lang('BAD_PASSWD2');
			echo '</p>';
		}
		?>

		</fieldset>
	</form>
</div>
