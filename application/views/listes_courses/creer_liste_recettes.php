<section>
	<?php if($this->session->flashdata('error_message')) { ?>
	<ul><li class="error_message"><?php echo $this->session->flashdata('error_message'); ?></li></ul>
	<?php }
	if($this->session->flashdata('confirm_message')) { ?>
		<ul><li class="confirm_message"><?php echo $this->session->flashdata('confirm_message'); ?></li></ul>
	<?php } ?>
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('listes_courses/lister', 'Listes de courses', 'title="Liste des recettes"'); ?></div>
    <form class="repeater" method="post" enctype="multipart/form-data">
		<ul class="repeater" data-repeater-list="recettes">
				<li data-repeater-item>
						<select class="select2" name="recette_id" required>
						<option value="">----------</option>
						<?php foreach($recettes as $recette) {
							echo "<option value=".$recette['recette_id'].">".$recette['recette_nom']."</option>";
						}; ?>
						</select>
					<input data-repeater-delete type="button" value="Supprimer"/>
				</li>
		</ul><input data-repeater-create id="repeater-button" type="button" value="Recette supplémentaire"/>
		<input type="submit" value="Valider" > <?php echo anchor('listes_courses/creer_liste_achats/'.$id_liste, 'Ignorer cette étape', 'title="Ignorer cette étape"'); ?>
    </form>
</section>
