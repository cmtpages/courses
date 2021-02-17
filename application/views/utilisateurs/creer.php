<script language='javascript' type='text/javascript'>
function same_passwords(input) {
    if (input.value != document.getElementById('utilisateur_password').value) {
        input.setCustomValidity('Les mots de passe de correspondent pas.');
    } else {
        // input is valid -- reset the error message
        input.setCustomValidity('');
    }
}
</script>

<section>
	<?php echo heading($section_title, 2); ?>
    <form action="creer" method="post" enctype="multipart/form-data">
		<ul>
			<li>
				<label for="utilisateur_login" class="required">Nom d'utilisateur</label>
				<input type="text" id="utilisateur_login" name="utilisateur_login" size="35" required value="<?php echo set_value('utilisateur_login'); ?>">
				<?php echo form_error("utilisateur_login"); ?>
			</li>
			<li>
				<label for="utilisateur_mail" class="required">Adresse mail</label>
				<input type="email" id="utilisateur_mail" name="utilisateur_mail" size="35" required value="<?php echo set_value('utilisateur_mail'); ?>">
				<?php echo form_error("utilisateur_mail"); ?>
			</li>
			<li>
				<label for="utilisateur_password" class="required">Mot de passe</label>
				<input type="password" id="utilisateur_password" name="utilisateur_password" size="35" required>
				<?php echo form_error("utilisateur_password"); ?>
			</li>
			<li>
				<label for="confirm_password" class="required">Mot de passe (confirmation)</label>
				<input type="password" id="confirm_password" name="confirm_password" size="35" oninput="same_passwords(this)" required>
				<?php echo form_error("confirm_password"); ?>
			</li>
		</ul>
		<input type="submit" value="Valider" ><?php echo anchor('utilisateurs/connecter', 'Annuler', 'title="Retourner à la liste"'); ?>
    </form>
</section>
