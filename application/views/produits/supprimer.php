<section>
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('produits/lister', 'Liste des produits', 'title="Liste des produits"'); ?></div>
	Confirmer la suppression du produit « <?php echo $produit['produit_nom']; ?> » ?
    <form action="<?php echo $produit['produit_id']; ?>" method="post" enctype="multipart/form-data">
		<input type="submit" name="confirm_delete" value="Confimer" ><?php echo anchor('produits/lister', 'Annuler', 'title="Retourner à la liste"'); ?>
    </form>
</section>
