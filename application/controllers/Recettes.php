<?php
/* **
 * \file Produits.php
 * \author Clement PAGÈS
 * \brief Contrôleur pour les produits.
 * 
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Recettes extends CI_Controller {
	function __construct(){
        parent::__construct();
        $this->data = array(
            'header_title' => 'Gestion des recettes',
        );
        $this->load->library('session');
        
        $this->load->model('recettes_model');
        
        $this->load->view('common/header', $this->data);
        $this->load->view('common/menu', $this->data);
    }


	// PUBLIC FUNCTIONS
	/** 
	 * \brief Charge les données relatives à une recette puis charge la vue associée.
	 * \param $id_recette Identifiant de la recette
	*/
	public function consulter($id_recette = NULL) {
		$data['recette'] = $this->recettes_model->consulter_recette($id_recette);
		
		if(empty($data['recette'])) {
			$this->session->set_flashdata('error_message', 'La recette demandée n\'existe pas.');
			redirect('recettes/lister');
		}
		$data['section_title'] = 'Détails de la recette « '.$data['recette']['details'][0]['recette_nom'].' »';
		
		$data['recette']['details'] = $data['recette']['details'][0];
		
		// Calcul de la quantite d'ingredients à afficher en multipliant par le nb de personnes dans la recette.
		$nb_pers = $data['recette']['details']['recette_nombre_personnes'];
		if(!empty($nb_pers)) {
            foreach($data['recette']['ingredients'] as $i=>$ingredient) {
                $ingredient['ingredient_quantite'] = $ingredient['ingredient_quantite']*$nb_pers;
                $data['recette']['ingredients'][$i] = $ingredient;
            }
		}		
		$this->load->view('recettes/consulter', $data);
        $this->load->view('common/footer');
	}
	
	/** 
	 * \brief Charge le formulaire pour créer une nouvelle recette, ou gère la création d'une recette. Redirige vers la liste des recettes.
	*/
	public function creer() {
		$this->load->helper('form');
		
		$this->load->model('produits_model');
		
		$data['section_title'] = 'Nouvelle recette';
		
		if($this->input->post()) { // Si c'est une validation, on enregistre la recette.
			$this->inserer_recette();
			$this->session->set_flashdata('confirm_message', 'La recette a été créée.');
			redirect('recettes/lister');
		}
		else { // Sinon, affichage du formulaire
			$data['produits'] = $this->produits_model->lister_produits('p.produit_nom');
			$data['unites'] = $this->recettes_model->lister_unites();
			
			$this->load->view('recettes/creer', $data);
		}
        $this->load->view('common/footer');
    }
	
	/** 
	 * \brief Charge les données pour afficher la liste des recettes et charge la vue associée.
	*/
	public function lister() {
		$data['section_title'] = 'Liste des recettes';
		
		$data['recettes'] = $this->recettes_model->lister_recettes();
		
        $this->load->view('recettes/lister', $data);
        $this->load->view('common/footer');
    }
    
    /**
	 * \brief Modifie une recette existante et redirige vers la liste des recettes.
	 * \param $id_recette : Identifiant de la recette. — Type int.
	*/
    public function modifier($id_recette) {
		$this->load->helper('form');
		$data['section_title'] = 'Modification d\'une recette';
		
		$this->load->model('produits_model');
		
		if($this->input->post()) { // Si c'est une validation, on enregistre les données.
			$this->supprimer_ingredients($id_recette);
			$this->inserer_recette($id_recette);
			$this->session->set_flashdata('confirm_message', 'La recette a été modifiée.');
			redirect('recettes/lister');
		}
		else {  // Sinon, on prépare l'affichage du formulaire.
			$recette = $this->recettes_model->consulter_recette($id_recette);
			
			if(empty($recette)) { 
				$this->session->set_flashdata('error_message', 'La recette demandée n\'existe pas.');
				redirect('recettes/lister');
			}
			$recette['details'] = $recette['details'][0];
			foreach($recette['ingredients'] as $i=>$ingredient) {
                if(!empty($ingredient['ingredient_quantite']) and !empty($recette['details']['recette_nombre_personnes'])) {
                    $recette['ingredients'][$i]['ingredient_quantite'] = round($ingredient['ingredient_quantite']*$recette['details']['recette_nombre_personnes'], 2);
                }
			}
			
			$data['post'] = $recette;
			
			$data['produits'] = $this->produits_model->lister_produits('p.produit_nom');
			$data['unites'] = $this->recettes_model->lister_unites();
			
			$data['section_title'] = 'Modification de la recette « '.$recette['details']['recette_nom'].' »';
			$this->load->view('recettes/modifier', $data);
			$this->load->view('common/footer');
		}
	}
	
	/** 
	 * \brief Supprime une recette existante et redirige vers la liste des recettes.
	 * \param $id_recette — Type int.
	*/
	public function supprimer($id_recette) {
		if($this->input->post()) {
			$data['recette'] = array(
				'recette_date_suppression' => date('Y-m-d H:i:s'),
			);
			$this->recettes_model->update_recette($id_recette, $data['recette']);
			$this->session->set_flashdata('confirm_message', 'La recette a été supprimée.');
			redirect('recettes/lister');
		}
		else {
			$data['recette'] = $this->recettes_model->consulter_recette($id_recette)['details'][0];
			if(empty($data['recette'])) {
				$this->session->set_flashdata('error_message', 'La recette demandée n\'existe pas.');
				redirect('recettes/lister');
		}
			$data['section_title'] = 'Suppression de la recette « '.$data['recette']['recette_nom'].' »';
			$this->load->view('recettes/supprimer', $data);
			$this->load->view('common/footer');
		}
    }
    
    // PROTECTED FUNCTIONS
    /** 
	 * \brief Prépare les données pour la création d'une, et appelle les requêtes pour créer la recette et ajouter les ingrédients.
	 \param $id_recette Indentifiant de la recette — Type int.
	 * 
	*/
    protected function inserer_recette($id_recette=NULL) {
		$post = $this->input->post();
		// Préparation des données pour la création ou la modification d'une recette.
		$data['recette'] = array(
			'recette_nom' => $post['recette_nom'],
			'recette_nombre_personnes' => $post['recette_nombre_personnes'],
			'recette_instructions' => $post['recette_instructions'],
			'recette_date_creation' => date('Y-m-d H:i:s'),
		);
		if($id_recette==NULL) // Si c'est une création
			$recette_id = $this->recettes_model->save_recette($data['recette']);
		else{ // Sinon, c'est une modification
			$recette_id = $id_recette;
			$this->recettes_model->update_recette($id_recette, $data['recette']);
		}
		// Préparation des données pour l'insertion des ingrédients.
		foreach($post['ingredients'] as $i => $ingredient) {
			$ingredient['ingredient_date_creation'] = date('Y-m-d H:i:s');
			$ingredient['recette_id'] = $recette_id;
			if(!isset($ingredient['produit_id'])) { // On ignore les champs non renseignés.
				unset($ingredient[$i]);
			}
			if(!isset($ingredient['unite_id'])) { // Ingrédients sans unités.
				$ingredient['unite_id'] = NULL;
			}
			if(empty($ingredient['ingredient_quantite'])) { // Quantité non précisée
				$ingredient['ingredient_quantite'] = NULL;
				$ingredient['unite_id'] = NULL;
			}
			// Calcul de la quantité équivalente pour 1 personne.
			if(!empty($data['recette']['recette_nombre_personnes']) and !empty($ingredient['ingredient_quantite'])) {
                $ingredient['ingredient_quantite'] = $ingredient['ingredient_quantite']/$data['recette']['recette_nombre_personnes'];
			}
			$data['ingredients'][$i] = $ingredient;
		}
		
		$this->recettes_model->save_recette_ingredients($data['ingredients']);
    }
    
    /** 
	 * \brief Prépare les données pour supprimer les ingrédients d'une recette.
	 * \param $id_recette Indentifiant de la recette — Type int.
	 * 
	*/
    protected function supprimer_ingredients($id_recette) {
		$ingredient_date_suppression = array(
			'ingredient_date_suppression' => date('Y-m-d H:i:s')
		);
		$this->recettes_model->supprimer_ingredients_recette($id_recette, $ingredient_date_suppression);
    }
}
