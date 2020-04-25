<?php $current_section = $this->uri->segment(1);
$current_action = $this->uri->segment(2); ?>

<nav>
	<h2 <?php if($current_section=='rayons') echo 'class="selected"' ?>>
        <?php echo anchor('rayons/lister', 'Rayons', 'title="Voir les rayons"'); ?>
    </h2>
	<h2 <?php if($current_section=='produits') echo 'class="selected"' ?>>
        <?php echo anchor('produits/lister', 'Produits', 'title="Voir les produits"'); ?>
    </h2>
    <h2 <?php if($current_section=='recettes') echo 'class="selected"' ?>>
        <?php echo anchor('recettes/lister', 'Recettes', 'title="Voir les recettes"'); ?>
    </h2>
    <h2 <?php if($current_section=='listes_courses') echo 'class="selected"' ?>>
        <?php echo anchor('listes_courses/lister', 'Courses', 'title="Voir les listes de courses"'); ?>
    </h2>
</nav>
