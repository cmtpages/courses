<section>
	<?php if($this->session->flashdata('error_message')) { ?>
	<ul><li class="error_message"><?php echo $this->session->flashdata('error_message'); ?></li></ul>
	<?php }
	if($this->session->flashdata('confirm_message')) { ?>
		<ul><li class="confirm_message"><?php echo $this->session->flashdata('confirm_message'); ?></li></ul>
	<?php } ?>
	
	<?php echo heading($section_title, 2); ?>
	<div class="filtres_haut_page">
		<input type="text" id="search" onkeyup="search_bar()" placeholder="Rechercher un produit ou un rayon" size=35>
	</div>
	<div class="liens_haut_page">
		<?php echo anchor('produits/creer', 'Nouveau produit', 'title="Nouveau produit"'); ?>
	</div>
	
	<table id="table_search">
	<tr>
		<th>Rayon</th>
		<th>Produit</th>
		<th>Actions</th>
	</tr>
	<?php if(!empty($produits)) $rayon_courant = ''; ?>
	<?php foreach($produits as $produit) { ?>
        <?php if($rayon_courant!=$produit['rayon_nom']) { ?>
            <tr>
                <?php $rayon_courant = $produit['rayon_nom']; ?>
                <td colspan="3" class="colonnefusion">
                    <?php echo $rayon_courant; ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td>
                <?php echo $produit['rayon_nom']; ?>
            </td>
            <td>
                <?php echo $produit['produit_nom']; ?>
            </td>
            <td>
                <a href="<?php echo site_url("produits/consulter/".$produit['produit_id']); ?>" title="Consulter">
                    <img src="<?php echo base_url("asset/img/consulter.png"); ?>" alt="Consulter">
                </a>
                <a href="<?php echo site_url("produits/lister_recettes/".$produit['produit_id']); ?>" title="Voir les recettes associées">
                    <img src="<?php echo base_url("asset/img/consulter_recette.png"); ?>" alt="Consulter les recettes">
                </a>
                <a href="<?php echo site_url("produits/modifier/".$produit['produit_id']); ?>
                " title="Modifier">
                    <img src="<?php echo base_url("asset/img/modifier.png"); ?>" alt="Modifier">
                </a>
                <a href="<?php echo site_url("produits/supprimer/".$produit['produit_id']); ?>" title="Supprimer">
                    <img src="<?php echo base_url("asset/img/supprimer.png"); ?>" alt="Supprimer">
                </a>
            </td>
		</tr>
	<?php } ?>
</table>
</section>
