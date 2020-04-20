<?php $current_section = $this->uri->segment(1);
$current_action = $this->uri->segment(2); ?>

<nav>
	<h2>Rayons</h2>
	<ul>
		<li <?php if($current_section=='rayons' and $current_action=='creer') echo 'class="selected"'?>>
			<?php echo anchor('rayons/creer', 'Créer', 'title="Créer un rayon"'); ?>
		</li>
		<li <?php if($current_section=='rayons' and $current_action=='lister') echo 'class="selected"'?>>
			<?php echo anchor('rayons/lister', 'Lister', 'title="Lister les rayons"'); ?>
		</li>
	</ul>
	<h2>Produits</h2>
	<ul>
		<li <?php if($current_section=='produits' and $current_action=='creer') echo 'class="selected"'?>>
			<?php echo anchor('produits/creer', 'Créer', 'title="Créer un produit"'); ?>
		</li>
		<li <?php if($current_section=='produits' and $current_action=='lister') echo 'class="selected"'?>>
			<?php echo anchor('produits/lister', 'Lister', 'title="Lister les produits"'); ?>
		</li>
	</ul>
	<h2>Recettes</h2>
	<ul>
		<li <?php if($current_section=='recettes' and $current_action=='creer') echo 'class="selected"'?>>
			<?php echo anchor('recettes/creer', 'Créer', 'title="Créer une recette"'); ?>
		</li>
		<li <?php if($current_section=='recettes' and $current_action=='lister') echo 'class="selected"'?>>
			<?php echo anchor('recettes/lister', 'Lister', 'title="Lister les recettes"'); ?>
		</li>
	</ul>
	<h2>Courses</h2>
	<ul>
		<li <?php if($current_section=='listes_courses' and $current_action=='creer') echo 'class="selected"'?>>
			<?php echo anchor('listes_courses/creer', 'Créer', 'title="Créer une recette"'); ?>
		</li>
		<li <?php if($current_section=='listes_courses' and $current_action=='lister') echo 'class="selected"'?>>
			<?php echo anchor('listes_courses/lister', 'Lister', 'title="Listes de courses"'); ?>
		</li>
	</ul>
</nav>
