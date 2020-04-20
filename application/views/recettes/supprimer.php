<section>
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('recettes/lister', 'Liste des recettes', 'title="Liste des recettes"'); ?></div>
	Confirmer la suppression de la recette « <?php echo $recette['recette_nom']; ?> » ?
    <form action="<?php echo $recette['recette_id']; ?>" method="post" enctype="multipart/form-data">
		<input type="submit" name="confirm_delete" value="Confimer" ><?php echo anchor('recettes/lister', 'Annuler', 'title="Retourner à la liste"'); ?>
    </form>
</section>
