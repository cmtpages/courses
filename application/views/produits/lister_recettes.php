<section>
	<?php echo heading($section_title, 2); ?>
	<div class="filtres_haut_page">
	</div>
	<div class="liens_haut_page">
		<?php echo anchor('produits/creer', 'Nouveau produit', 'title="Nouveau produit"'); ?>
	</div>
	
	<table>
	<tr>
		<th>Produit</th>
		<th>Recette</th>
		<th>Actions</th>
	</tr>
	<?php foreach($recettes as $recette) { ?>
		<tr>
			<td>
				<?php echo $produit['produit_nom']; ?>
			</td>
			<td>
				<?php echo $recette['recette_nom']; ?>
			</td>
			<td>
				<a href="<?php echo site_url("recettes/consulter/".$recette['recette_id']); ?>" title="Consulter">
					<img src="<?php echo base_url("asset/img/consulter.png"); ?>" alt="Consulter">
				</a>
			</td>
		</tr>
	<?php } ?>
</table>
</section>
