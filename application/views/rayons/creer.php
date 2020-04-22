<section>
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('rayons/lister', 'Liste des rayons', 'title="Liste des rayons"'); ?></div>
    <form action="creer" method="post" enctype="multipart/form-data">
		<ul>
			<li>
				<label for="rayon_nom" class="required">Nom du rayon</label>
				<input type="text" id="rayon_nom" name="rayon_nom" size="35" required>
				<?php echo form_error("rayon_nom"); ?>
			</li>
		</ul>
		<input type="submit" value="Valider" ><?php echo anchor('rayons/lister', 'Annuler', 'title="Retourner à la liste"'); ?>
    </form>
</section>
