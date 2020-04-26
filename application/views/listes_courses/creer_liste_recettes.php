<!-- Remplissage automatique des nombres de personnes -->
<script>
function fillInput(e) {
    var values = <?php echo json_encode($recettes); ?>;
    var elements =  document.getElementsByClassName("courses_recette_nombre_personnes");
    for(i=0 ; i<values.length ; i++) {
        if(e.target.value == values[i].recette_id) {
            elements[elements.length-1].value = values[i].recette_nombre_personnes;
        }
    }
}
</script>
<section>
	<?php if($this->session->flashdata('error_message')) { ?>
	<ul><li class="error_message"><?php echo $this->session->flashdata('error_message'); ?></li></ul>
	<?php }
	if($this->session->flashdata('confirm_message')) { ?>
		<ul><li class="confirm_message"><?php echo $this->session->flashdata('confirm_message'); ?></li></ul>
	<?php } ?>
	<?php echo heading($section_title, 2); ?>
	<div class="liens_haut_page"><?php echo anchor('listes_courses/lister', 'Listes de courses', 'title="Liste des recettes"'); ?></div>
    <form class="repeater" method="post" enctype="multipart/form-data">
		<ul class="repeater" data-repeater-list="recettes">
            <li data-repeater-item>
                <select class="select2" name="recette_id" onchange="fillInput(event)" required>
                <option value="">----------</option>
                <?php foreach($recettes as $recette) {
                    echo "<option value=".$recette['recette_id'].">";
                    echo $recette['recette_nom'];
                    echo "</option>";
                } ?>
                </select>
                <input type="number" class="courses_recette_nombre_personnes" name="courses_recette_nombre_personnes" placeholder="Nombre de personnes" min="1" step="1" required/>
                <input data-repeater-delete type="button" value="Supprimer" size="2"/>
            </li>
		</ul><input data-repeater-create id="repeater-button" type="button" value="Recette supplémentaire"/>
		<input type="submit" value="Valider" > <?php echo anchor('listes_courses/creer_liste_achats/'.$id_liste, 'Ignorer cette étape', 'title="Ignorer cette étape"'); ?>
    </form>
</section>
