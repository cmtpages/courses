<section>
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('utilisateurs/lister', 'Liste des utilisateurs', 'title="Liste des utilisateurs"'); ?></div>
	<dl>
        <dt>Nom d'utilisateur</dt><dd><?php echo $utilisateur['utilisateur_login']; ?></dd>
        <dt>Adresse mail</dt><dd><?php echo $utilisateur['utilisateur_mail']; ?></dd>
    </dl>
</section>
