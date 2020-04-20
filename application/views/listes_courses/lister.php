<section>
	<?php if($this->session->flashdata('error_message')) { ?>
	<ul><li class="error_message"><?php echo $this->session->flashdata('error_message'); ?></li></ul>
	<?php }
	if($this->session->flashdata('confirm_message')) { ?>
		<ul><li class="confirm_message"><?php echo $this->session->flashdata('confirm_message'); ?></li></ul>
	<?php } ?>
	
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('listes_courses/creer', 'Nouvelle liste de courses', 'title="Nouvelle liste de courses"'); ?></div>
	<table>
	<tr>
		<th>Liste de courses</th>
		<th>Actions</th>
	</tr>
	<?php foreach($listes as $liste) { ?>
		<tr>
			<td>
				<?php echo $liste['liste_nom']; ?>
			</td>
			<td>
				<a href="<?php echo site_url("listes_courses/consulter/".$liste['liste_id']); ?>" title="Consulter">
					<img src="<?php echo base_url("asset/img/consulter.png"); ?>" alt="Consulter">
				</a>
				<a href="<?php echo site_url("listes_courses/modifier/".$liste['liste_id']); ?>" title="Modifier">
					<img src="<?php echo base_url("asset/img/modifier.png"); ?>" alt="Modifier">
				</a>
				<a href="<?php echo site_url("listes_courses/generer/".$liste['liste_id']); ?>" title="Générer en PDF">
					<img src="<?php echo base_url("asset/img/pdf.png"); ?>" alt="Générer">
				</a>
				<a href="<?php echo site_url("listes_courses/supprimer/".$liste['liste_id']); ?>" title="Supprimer">
					<img src="<?php echo base_url("asset/img/supprimer.png"); ?>" alt="Supprimer">
				</a>
			</td>
		</tr>
	<?php } ?>
</table>
</section>
