<section>
	<?php if($this->session->flashdata('error_message')) { ?>
	<ul><li class="error_message"><?php echo $this->session->flashdata('error_message'); ?></li></ul>
	<?php }
	if($this->session->flashdata('confirm_message')) { ?>
		<ul><li class="confirm_message"><?php echo $this->session->flashdata('confirm_message'); ?></li></ul>
	<?php } ?>
	
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('utilisateurs/creer', 'Nouvel utilisateur', 'title="Nouveau rayon"'); ?></div>
	<table><tr>
		<th>Utilisateurs</th>
		<th>Actions</th>
	</tr>
		<?php foreach($utilisateurs as $utilisateur) { ?>
			<tr><td>
				<?php echo $utilisateur['utilisateur_login']; ?>
			</td>
			<td>
				<a href="<?php echo site_url("utilisateurs/consulter/".$utilisateur['utilisateur_id']); ?>
				" title="Consulter">
					<img src="<?php echo base_url("asset/img/consulter.png"); ?>" alt="Consulter">
				</a>
				
			</td>
		</tr>
	<?php } ?>
</table>
</section>
