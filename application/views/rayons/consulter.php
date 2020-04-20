<section>
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('rayons/lister', 'Liste des rayons', 'title="Liste des rayons"'); ?></div>
	<dl>
        <dt>Nom du rayon</dt><dd><?php echo $rayon['rayon_nom']; ?></dd>
    </dl>
</section>
