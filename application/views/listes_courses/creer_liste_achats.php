<section>
	<?php if($this->session->flashdata('error_message')) { ?>
	<ul><li class="error_message"><?php echo $this->session->flashdata('error_message'); ?></li></ul>
	<?php }
	if($this->session->flashdata('confirm_message')) { ?>
		<ul><li class="confirm_message"><?php echo $this->session->flashdata('confirm_message'); ?></li></ul>
	<?php } ?>
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('listes_courses/lister', 'Listes de courses', 'title="Liste des recettes"'); ?></div>
    <form class="repeater" action="<?php $id_liste; ?>" method="post" enctype="multipart/form-data">
		<ul class="repeater" data-repeater-list="achats">
			<?php if(isset($achats)) {
				foreach($achats as $achat) { ?>
					<li data-repeater-item>
							<select class="select2" name="produit_id" required>
							<option value="">----------</option>
							<?php foreach($produits as $produit) {
								echo "<option value=".$produit['produit_id']." ";
								if($produit['produit_id'] == $achat['produit_id']) echo 'selected';
								echo ">".$produit['produit_nom']."</option>";
							}; ?>
							</select>
							<input type="number" value="<?php echo $achat['achat_quantite']?>" step="any" id="achat_quantite" name="achat_quantite">
							<select name="unite_id">
							<?php foreach($unites as $unite) {
								echo "<option value=".$unite['unite_id']." ";
								if($achat['unite_id'] == $unite['unite_id']) echo 'selected';
								echo ">".$unite['unite_nom']."</option>";
							} ?>
							</select>
						<input data-repeater-delete type="button" value="Supprimer"/>
					</li>
				<?php }
			}
			else { ?>
					<li data-repeater-item>
						<select class="select2" name="produit_id" required>
						<option value="">----------</option>
						<?php foreach($produits as $produit) {
							echo "<option value=".$produit['produit_id']." ";
							echo ">".$produit['produit_nom']."</option>";
						}; ?>
						</select>
						<input type="number" step="any" id="achat_quantite" name="achat_quantite">
							<select name="unite_id">
							<?php foreach($unites as $unite) {
								echo "<option value=".$unite['unite_id'].">".$unite['unite_nom']."</option>";
							} ?>
							</select>
						<input data-repeater-delete type="button" value="Supprimer"/>
					</li>
			<?php } ?>
		</ul>
		<input data-repeater-create id="repeater-button" type="button" value="Achat supplémentaire"/>
		<input type="submit" value="Valider" >
<!-- 		<?php echo anchor('listes_courses/modifier_liste_recettes/'.$id_liste, 'Étape précédente', 'title="Étape précédente"'); ?> -->
    </form>
</section>
