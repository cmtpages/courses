<section>
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('listes_courses/lister', 'Listes de courses', 'title="Listes de courses"'); ?></div>
    <form action="<?php echo $post['liste_id']; ?>" method="post" enctype="multipart/form-data">
		<ul>
			<li>
				<label for="liste_nom"  class="required">Nom de la liste</label>
				<input type="text" id="rayon_nom" name="liste_nom" value="<?php echo $post['liste_nom']; ?>" size="35" required>
				<?php echo form_error("liste_nom"); ?>
			</li>
		</li>
		<input type="submit" value="Valider" ><?php echo anchor('listes_courses/lister', 'Annuler', 'title="Retourner aux listes de courses"'); ?>
    </form>
    
</section>
