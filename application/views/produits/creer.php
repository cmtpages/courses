
<section>
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('produits/lister', 'Liste des produits', 'title="Liste des produits"'); ?></div>
	<form action="creer" method="post" enctype="multipart/form-data">
		<ul>
			<li>
				<label for="produit_nom" class="required">Nom du produit</label>
				<input type="text" id="produit_nom" name="produit_nom" size="35" required>
				<?php echo form_error("produit_nom"); ?>
			</li>
			<li>
				<label for="rayon_id" class="required">Nom du rayon</label>
				<select class="select2" name="rayon_id" id="rayon_id" required>
					<option value="">----------</option>
					<?php foreach($rayons as $rayon) {
						echo "<option value=".$rayon['rayon_id']." ";
						if(isset($post) and $rayon['rayon_id'] == $post['rayon_id']) echo 'selected';
						echo ">".$rayon['rayon_nom']."</option>";
					}; ?>
				</select>
			</li>
		</ul>
		<input type="submit" value="Valider" ><?php echo anchor('produits/lister', 'Annuler', 'title="Retourner à la liste"'); ?>
    </form>
</section>
