<section>
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('listes_courses/lister', 'Listes de courses', 'title="Listes de courses"'); ?></div>
	Confirmer la suppression de la liste de courses « <?php echo $liste['liste_nom']; ?> » ?
    <form action="<?php echo $liste['liste_id']; ?>" method="post" enctype="multipart/form-data">
		<input type="submit" name="confirm_delete" value="Confimer" ><?php echo anchor('listes_courses/lister', 'Annuler', 'title="Retourner aux listes de courses"'); ?>
    </form>
</section>
