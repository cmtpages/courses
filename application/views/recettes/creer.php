<section>
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('recettes/lister', 'Liste des recettes', 'title="Liste des recettes"'); ?></div>
    <form class="repeater" action="creer" method="post" enctype="multipart/form-data">
		<ul>
			<li>
				<label for="recette_nom">Nom de la recette</label>
				<input type="text" id="recette_nom" name="recette_nom" size="35" required>
				<?php echo form_error("recette_nom"); ?>
			</li>
		</ul>
		<h3>Liste des ingrédients</h3>
		<ul class="repeater" data-repeater-list="ingredients">
			<li data-repeater-item>
					<select class="select2"  name="produit_id" required>
					<option value="">----------</option>
					<?php foreach($produits as $produit) {
						echo "<option value=".$produit['produit_id'].">".$produit['produit_nom']."</option>";
					}; ?>
					</select>
					<input type="number" value="0" step="any" id="ingredient_quantite" name="ingredient_quantite">
					<select name="unite_id">
					<?php foreach($unites as $unite) {
						echo "<option value=".$unite['unite_id'].">".$unite['unite_nom']."</option>";
					}; ?>
					</select>
				<input data-repeater-delete type="button" value="Supprimer"/>
				<?php echo form_error("ingredient_quantite"); ?>
			</li>
		</ul><input data-repeater-create id="repeater-button" type="button" value="Ingrédient supplémentaire"/>
		<h3>Instructions</h3>
		<textarea id="recette_instructions" name="recette_instructions" rows=35></textarea>
		<input type="submit" value="Valider" ><?php echo anchor('recettes/lister', 'Annuler', 'title="Retourner à la liste"'); ?>
    </form>
</section>
