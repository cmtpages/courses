<section>
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('recettes/lister', 'Liste des recettes', 'title="Liste des recettes"'); ?></div>
	<h3>Ingrédients</h3>
	<dl>
        <dt>Nom de la recette</dt><dd><?php echo $recette['details']['recette_nom']; ?></dd>
        <dt>Ingrédients</dt>
		<dd><ul>
			<?php foreach($recette['ingredients'] as $ingredient) {
				echo '<li>'.$ingredient['produit_nom'];
				if(!empty($ingredient['ingredient_quantite']))
					echo ' ('.$ingredient['ingredient_quantite'];
				if(!empty($ingredient['unite_nom']))
					echo ' '.$ingredient['unite_nom'];
				if(!empty($ingredient['ingredient_quantite']))
					echo ')';
				echo '</li>';
			} ?>
		</ul></dd>
    </dl>
    
    <h3>Préparation</h3>
    <?php echo $recette['details']['recette_instructions']; ?>
</section>
