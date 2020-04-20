<section>
	<?php if($this->session->flashdata('error_message')) { ?>
	<ul><li class="error_message"><?php echo $this->session->flashdata('error_message'); ?></li></ul>
	<?php }
	if($this->session->flashdata('confirm_message')) { ?>
		<ul><li class="confirm_message"><?php echo $this->session->flashdata('confirm_message'); ?></li></ul>
	<?php } ?>
	
	<?php echo heading($section_title, 2); ?>
	<div class="filtres_haut_page">
		<input type="text" id="search" onkeyup="search_bar()" placeholder="Rechercher une recette" size=35>
	</div>
	
	<div class="liens_haut_page"><?php echo anchor('recettes/creer', 'Nouvelle recette', 'title="Nouvelle recette"'); ?></div>
	
	<table id="table_search">
	<tr>
		<th>Recette</th>
		<th>Actions</th>
	</tr>
	<?php foreach($recettes as $recette) { ?>
		<tr>
			<td>
				<?php echo $recette['recette_nom']; ?>
			</td>
			<td>
				<a href="<?php echo site_url("recettes/consulter/".$recette['recette_id']); ?>" title="Consulter">
					<img src="<?php echo base_url("asset/img/consulter.png"); ?>" alt="Consulter">
				</a>
				<a href="<?php echo site_url("recettes/modifier/".$recette['recette_id']); ?>" title="Modifier">
					<img src="<?php echo base_url("asset/img/modifier.png"); ?>" alt="Modifier">
				</a>
				<a href="<?php echo site_url("recettes/supprimer/".$recette['recette_id']); ?>" title="Supprimer">
					<img src="<?php echo base_url("asset/img/supprimer.png"); ?>" alt="Supprimer">
				</a>
			</td>
		</tr>
	<?php } ?>
</table>
</section>
