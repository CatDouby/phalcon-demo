<h2>Sign using this form</h2>

<?php echo $this->tag->form('signup/register') ?>

	<p>
		<label for="name">Name</label>
		<?php echo $this->tag->textField("name") ?>
	</p>

	<p>
		<label for="name">E-Mail</label>
		<?php echo $this->tag->textField("email") ?>
	</p>

	<p>
		<?php echo $this->tag->submitButton("Register") ?>
	</p>

</form>
<?php echo Phalcon\Tag::form('register') ?>
<div>
	<?php echo Phalcon\Tag::passwordField('passwd') ?>
	<?php echo Phalcon\Tag::submitButton('Go') ?>
</div>
</form>
