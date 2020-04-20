<section>
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('rayons/lister', 'Liste des rayons', 'title="Liste des rayons"'); ?></div>
	Confirmer la suppression du rayon « <?php echo $rayon['rayon_nom']; ?> » et de tous les produits associés ?
    <form action="<?php echo $rayon['rayon_id']; ?>" method="post" enctype="multipart/form-data">
		<input type="submit" name="confirm_delete" value="Confimer" ><?php echo anchor('rayons/lister', 'Annuler', 'title="Retourner à la liste"'); ?>
    </form>
</section>
