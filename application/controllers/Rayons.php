<?php
/* **
 * \file Rayons.php
 * \author Clement PAGÈS
 * \brief Contrôleur pour les rayons.
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Rayons extends CI_Controller {
	function __construct(){
        parent::__construct();
        $this->data = array(
            'header_title' => 'Gestion des rayons',
        );
        $this->load->library('session');
        
        $this->load->model('rayons_model');
        
        $this->load->view('common/header', $this->data);
        $this->load->view('common/menu', $this->data);
    }

    
	// PUBLIC FUNCTIONS
	
	/** 
	 * \brief Charge les données relatives à un rayon puis charge la vue associée.
	 * \param $id_rayon Identifiant du rayon — Type int.
	*/
	public function consulter($id_rayon) {
		$data['rayon'] = $this->rayons_model->consulter_rayon($id_rayon)[0];
		
		if(empty($data['rayon'])) {
			$this->session->set_flashdata('error_message', 'Le rayon demandé n\'existe pas.');
			redirect('rayons/lister');
		}
		
		$data['section_title'] = 'Détails du rayon « '.$data['rayon']['rayon_nom'].' »';
		
		$this->load->view('rayons/consulter', $data);
        $this->load->view('common/footer');
	}
	
	/** 
	 * \brief Charge le formulaire pour créer un nouveau rayon, ou gère la création d'un rayon. Redirige vers la liste des rayons.
	*/
    public function creer() {
		$this->load->helper('form');
		
		$data['section_title'] = 'Nouveau rayon';
		
		if($this->input->post()) { // Si c'est une validation
			$this->ajouter_rayon();
			$this->session->set_flashdata('confirm_message', 'Le rayon a été créé.');
			redirect('rayons/lister');
		}
		else // Sinon, affichage du formulaire
			$this->load->view('rayons/creer', $data);
		
        $this->load->view('common/footer');
    }
    
    /** 
	 * \brief Charge les données pour afficher la liste des rayons et charge la vue associée.
	*/
    public function lister() {
		$data['section_title'] = 'Liste des rayons';
		
		$data['rayons'] = $this->rayons_model->lister_rayons();
        $this->load->view('rayons/lister', $data);
        $this->load->view('common/footer');
    }
    
    /**
	 * \brief Modifie un rayon existant et redirige vers la liste des rayons.
	 * \param $id_rayon : Identifiant du rayon. — Type int.
	*/
    public function modifier($id_rayon) {
		$this->load->helper('form');
		
		$data['section_title'] = 'Modification d\'un rayon';
		
		if($this->input->post()) {
			$data['rayon'] = array(
				'rayon_nom' => $this->input->post('rayon_nom'),
			);
			$this->rayons_model->update_rayon($id_rayon, $data['rayon']);
			$this->session->set_flashdata('confirm_message', 'Le rayon a été modifié.');
			redirect('rayons/lister');
		}
		else {
			$rayon = $this->rayons_model->consulter_rayon($id_rayon)[0];
			if(empty($rayon)) {
				$this->session->set_flashdata('error_message', 'Le rayon demandé n\'existe pas.');
				redirect('rayons/lister');
			}
			$data['post'] = $rayon;
			$data['section_title'] = 'Modification du rayon « '.$rayon['rayon_nom'].' »';
			
			$this->load->view('rayons/modifier', $data);
			$this->load->view('common/footer');
		}
	}
	
	/** 
	 * \brief Supprime un rayon existant et redirige vers la liste des rayons.
	 * \param $id_rayon — Type int.
	*/
	public function supprimer($id_rayon) {		
		if($this->input->post()) { // Si c'est un post, on met la base à jour.
			$data['rayon'] = array(
				'rayon_date_suppression' => date('Y-m-d H:i:s'),
			);
			$this->rayons_model->update_rayon($id_rayon, $data['rayon']);
			$this->session->set_flashdata('confirm_message', 'Le rayon a été supprimé.');
			redirect('rayons/lister');
		}
		else { // Sinon, on affiche la page de confirmation.
			$rayon = $this->rayons_model->consulter_rayon($id_rayon)[0];
			if(empty($rayon)) {
				$this->session->set_flashdata('error_message', 'Le rayon demandé n\'existe pas.');
				redirect('rayons/lister');
			}
			$data['rayon'] = $rayon;
			$data['section_title'] = 'Suppression du rayon « '.$rayon['rayon_nom'].' »';
			
			$this->load->view('rayons/supprimer', $data);
			$this->load->view('common/footer');
		}
    }
    
    // PROTECTED FUNCTIONS
    /** 
	 * \brief Prépare les données pour la création d'un rayon, et appelle la requête.
	 * 
	*/
    protected function ajouter_rayon() {
		$data['rayon'] = array(
			'rayon_nom' => $this->input->post('rayon_nom'),
			'rayon_date_creation' => date('Y-m-d H:i:s'),
		);
		$this->rayons_model->save_rayon($data['rayon']);
    }
}
