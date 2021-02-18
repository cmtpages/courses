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
    <?php if($this->session->flashdata('error_message')) { ?>
	<ul><li class="error_message"><?php echo $this->session->flashdata('error_message'); ?></li></ul>
	<?php }
	echo heading($section_title, 2); ?>
    <form action="modifier_motdepasse" method="post" enctype="multipart/form-data">
		<ul>
			<li>
                <label for="utilisateur_password_actuel" class="required">Mot de passe actuel</label>
				<input type="password" id="utilisateur_password_actuel" name="utilisateur_password_actuel" size="35" required>
				<?php echo form_error("utilisateur_password_actuel"); ?>
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
		<input type="submit" value="Valider" ><?php echo anchor('rayons/lister', 'Annuler', 'title="Retourner à la liste"'); ?>
    </form>
    
</section>
