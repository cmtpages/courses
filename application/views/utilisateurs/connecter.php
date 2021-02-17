<section>
    <?php if($this->session->flashdata('error_message')) { ?>
        <ul><li class="error_message"><?php echo $this->session->flashdata('error_message'); ?></li></ul>
        <?php }
        if($this->session->flashdata('confirm_message')) { ?>
            <ul><li class="confirm_message"><?php echo $this->session->flashdata('confirm_message'); ?></li></ul>
	<?php } ?>
	<?php echo heading($section_title, 2); ?>
    <form action="connecter" method="post" enctype="multipart/form-data">
		<ul>
			<li>
				<label for="utilisateur_login" class="required">Nom d'utilisateur</label>
				<input type="text" id="utilisateur_login" name="utilisateur_login" size="35" required>
				<?php echo form_error("utilisateur_login"); ?>
			</li>
			<li>
				<label for="utilisateur_password" class="required">Mot de passe</label>
				<input type="text" id="utilisateur_password" name="utilisateur_password" size="35" type="password" required>
				<?php echo form_error("utilisateur_password"); ?>
			</li>
		</ul>
		<input type="submit" value="Valider" ><?php echo anchor('utilisateurs/connecter', 'Annuler', 'title="Retourner à la liste"'); ?>
    </form>
</section>
