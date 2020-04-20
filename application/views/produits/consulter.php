<section>
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('produits/lister', 'Liste des produits', 'title="Liste des produits"'); ?></div>
	<dl>
        <dt>Nom du produit</dt><dd><?php echo $produit['produit_nom']; ?></dd>
        <dt>Rayon du produit</dt><dd><?php echo $produit['rayon_nom']; ?></dd>
    </dl>
</section>
