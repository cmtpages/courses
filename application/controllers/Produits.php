<?php
/* **
 * \file Produits.php
 * \author Clement PAGÈS
 * \brief Contrôleur pour les produits.
 * 
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Produits extends CI_Controller {
	function __construct(){
        parent::__construct();
        $this->data = array(
            'header_title' => 'Gestion des produits',
        );
        $this->load->library('session');
        
        $this->load->model('produits_model');
        
        $this->load->view('common/header', $this->data);
        $this->load->view('common/menu', $this->data);
    }


	// PUBLIC FUNCTIONS
	/** 
	 * \brief Charge les données relatives à un produit puis charge la vue associée.
	 * \param $id_produit Identifiant du produit — Type int.
	*/
	public function consulter($id_produit = NULL) {
		$data['produit'] = $this->produits_model->consulter_produit($id_produit)[0];
		
		if(empty($data['produit'])) {
			$this->session->set_flashdata('error_message', 'Le produit demandé n\'existe pas.');
			redirect('produits/lister');
		}
		
		$data['section_title'] = 'Détails du produit « '.$data['produit']['produit_nom'].' »';
		
		$this->load->view('produits/consulter', $data);
        $this->load->view('common/footer');
	}
	
	/** 
	 * \brief Charge le formulaire pour créer un nouveau produit, ou gère la création d'un produit. Redirige vers la liste des produits.
	*/
	public function creer() {
		$this->load->helper('form');
		
		$this->load->model('rayons_model');
		
		$data['section_title'] = 'Nouveau produit';
		
		if($this->input->post()) { // Si c'est une validation, on enregistre le produit.
			$this->ajouter_produit();
			$this->session->set_flashdata('confirm_message', 'Le produit a été créé.');
			redirect('produits/lister/'.$this->input->post()['rayon_id']);
		}
		else { // Sinon, on affiche le formulaire
		$data['rayons'] = $this->rayons_model->lister_rayons();
			$this->load->view('produits/creer', $data);
		}
        $this->load->view('common/footer');
    }
	
	/** 
	 * \brief Charge les données pour afficher la liste des produits et charge la vue associée.
	*/
	public function lister() {
		$data['section_title'] = 'Liste des produits';
		
		$this->load->model('rayons_model');
		
		$data['produits'] = $this->produits_model->lister_produits();
		
		$this->load->view('produits/lister', $data);
        $this->load->view('common/footer');
    }
    
    /**
     * \param $id_produit : identifiant d'un produit. — Type int.
     * \brief Régupère la liste des recettes qui contiennent le produit dont l'identifiant est $id_produit.
	*/
    public function lister_recettes($id_produit) {
		$data['produit'] = $this->produits_model->consulter_produit($id_produit)[0];
		if(empty($data['produit'])) {
			$this->session->set_flashdata('error_message', 'Le produit demandé n\'existe pas.');
			redirect('produits/lister');
		}
		
		$data['recettes'] = $this->produits_model->lister_recettes_produit($id_produit);
		
		$data['section_title'] = 'Recettes contenant le produit « '.$data['produit']['produit_nom'].' »';
		
		$this->load->view('produits/lister_recettes', $data);
        $this->load->view('common/footer');
    }
    
    /**
	 * \brief Modifie un produit existant et redirige vers la liste des produits.
	 * \param $id_rayon : Identifiant du rayon. — Type int.
	*/
    public function modifier($id_produit) {
		$this->load->helper('form');
		$data['section_title'] = 'Modification d\'un produit';
		
		$this->load->model('rayons_model');
		
		if($this->input->post()) { // Si c'est une validation, on enregistre les données.
			$data['produit'] = array(
				'produit_nom' => $this->input->post('produit_nom'),
				'rayon_id'    => $this->input->post('rayon_id'),
			);
			$this->produits_model->update_produit($id_produit, $data['produit']);
			$this->session->set_flashdata('confirm_message', 'Le produit a été modifié.');
			redirect('produits/lister/'.$this->input->post()['rayon_id']);
		}
		else { // Sinon, on prépare l'affichage du formulaire.
			$produit = $this->produits_model->consulter_produit($id_produit)[0];
			if(empty($produit)) {
				$this->session->set_flashdata('error_message', 'Le produit demandé n\'existe pas.');
				redirect('produits/lister');
			}
			$data['post'] = $produit;
			$data['rayons'] = $this->rayons_model->lister_rayons();
			$data['section_title'] = 'Modification du produit « '.$produit['produit_nom'].' »';
			
			$this->load->view('produits/modifier', $data);
			$this->load->view('common/footer');
		}
	}
    
    /** 
	 * \brief Supprime un produit existant et redirige vers la liste des produits.
	 * \param $id_produit — Type int.
	*/
    public function supprimer($id_produit) {		
		if($this->input->post()) {
			$data['produit'] = array(
				'produit_date_suppression' => date('Y-m-d H:i:s'),
			);
			$this->produits_model->update_produit($id_produit, $data['produit']);
			$this->session->set_flashdata('confirm_message', 'Le produit a été supprimé.');
			redirect('produits/lister');
		}
		else {
			$data['produit'] = $this->produits_model->consulter_produit($id_produit)[0];
			if(empty($data['produit'])) {
				$this->session->set_flashdata('error_message', 'Le produit demandé n\'existe pas.');
				redirect('produits/lister');
		}
			$data['section_title'] = 'Suppression du produit « '.$data['produit']['produit_nom'].' »';
			$this->load->view('produits/supprimer', $data);
			$this->load->view('common/footer');
		}
    }
    
    // PROTECTED FUNCTIONS
    /** 
	 * \brief Prépare les données pour la création d'un produit, et appelle la requête.
	 * 
	*/
    protected function ajouter_produit() {
		$data['produit'] = array(
			'produit_nom' => $this->input->post('produit_nom'),
			'rayon_id'    => $this->input->post('rayon_id'),
			'produit_date_creation' => date('Y-m-d H:i:s'),
		);
		$this->produits_model->save_produit($data['produit']);
    }
}
