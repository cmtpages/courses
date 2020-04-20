<section>
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('listes_courses/lister', 'Listes de courses', 'title="Listes de courses"'); ?></div>
	<dl>
        <dt>Nom de la liste</dt><dd><?php echo $liste['liste_nom']; ?></dd>
    </dl>
    <h3>Recettes dans la liste de courses</h3>
    <?php if(empty($recettes_liste)) { ?>
		<p>Aucune recette à afficher.</p>
    <?php }
    else { ?>
		<ul>
			<?php foreach($recettes_liste as $recette)
				echo '<li>'.$recette['recette_nom'].'</li>';
			?>
		</ul>
    <?php } ?>
</section>
