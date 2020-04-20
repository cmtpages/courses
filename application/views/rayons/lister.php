<section>
	<?php if($this->session->flashdata('error_message')) { ?>
	<ul><li class="error_message"><?php echo $this->session->flashdata('error_message'); ?></li></ul>
	<?php }
	if($this->session->flashdata('confirm_message')) { ?>
		<ul><li class="confirm_message"><?php echo $this->session->flashdata('confirm_message'); ?></li></ul>
	<?php } ?>
	
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('rayons/creer', 'Nouveau rayon', 'title="Nouveau rayon"'); ?></div>
	<table><tr>
		<th>Rayon</th>
		<th>Actions</th>
	</tr>
		<?php foreach($rayons as $rayon) { ?>
			<tr><td>
				<?php echo $rayon['rayon_nom']; ?>
			</td>
			<td>
				<a href="<?php echo site_url("rayons/consulter/".$rayon['rayon_id']); ?>
				" title="Consulter">
					<img src="<?php echo base_url("asset/img/consulter.png"); ?>" alt="Consulter">
				</a>
				<a href="<?php echo site_url("rayons/modifier/".$rayon['rayon_id']); ?>" title="Modifier">
					<img src="<?php echo base_url("asset/img/modifier.png"); ?>" alt="Modifier">
				</a>
				<a href="<?php echo site_url("rayons/supprimer/".$rayon['rayon_id']); ?>" title="Supprimer">
					<img src="<?php echo base_url("asset/img/supprimer.png"); ?>" alt="Supprimer">
				</a>
			</td>
		</tr>
	<?php } ?>
</table>
</section>
