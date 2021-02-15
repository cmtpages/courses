<?php
/* **
 * \file Utilisateurs.php
 * \author Clement PAGÈS
 * \brief Contrôleur pour les rayons.
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Utilisateurs extends CI_Controller {
	function __construct(){
        parent::__construct();
        $this->data = array(
            'header_title' => 'Gestion des utilisateurs',
        );
        
        $this->load->model('utilisateurs_model');
        
        $this->load->view('common/header', $this->data);
        $this->load->view('common/menu', $this->data);
    }

    
	// PUBLIC FUNCTIONS
	
	public function consulter($id_utilisateur) {        
		$data['utilisateur'] = $this->utilisateurs_model->consulter_utilisateur($id_utilisateur)[0];
		
		if(empty($data['utilisateur'])) {
			$this->session->set_flashdata('error_message', 'L\'utilisateur demandé n\'existe pas.');
			redirect('utilisateurs/lister');
		}
		
        $data['section_title'] = 'Détails de l\'utilisateur « '.$data['utilisateur']['utilisateur_login'].' »';

		
		$this->load->view('utilisateurs/consulter', $data);
        $this->load->view('common/footer');
	}
	
    public function connecter() {
		$this->load->helper('form');
		
		$data['section_title'] = 'Connexion';
		
		if($this->input->post()) { // Si c'est une validation
            $post = $this->input->post();
            $data['utilisateur'] = $this->utilisateurs_model->conecter_utilisateur($post['utilisateur_login'], $post['utilisateur_password'])[0];
            if(empty($data['utilisateur'])) {
                $this->session->set_flashdata('error_message', 'L\'utilisateur demandé n\'existe pas (mauvais nom d\'utilisateur ou mauvais mot de passe).');
               $this->load->view('utilisateurs/connecter', $data);
            }
            else {
                $this->session->set_userdata('utilisateur_id', $data['utilisateur']['utilisateur_id']);
                $this->session->set_flashdata('confirm_message', 'Vous êtes maintenant connecté.');
                redirect('rayons/lister');
            }
		}
		else // Sinon, affichage du formulaire
			$this->load->view('utilisateurs/connecter', $data);
		
        $this->load->view('common/footer');
    }
    
    public function deconnecter() {
		$this->load->helper('form');
		
		if(!isset($this->session->userdata['utilisateur_id'])) {
            $this->session->set_flashdata('error_message', 'Vous n\'êtes pas connecté.');
		}
		else {
            session_destroy();
            $this->session->set_flashdata('confirm_message', 'Vous êtes déconnecté.');
            redirect('utilisateurs/connecter');
            
		}
		
        $this->load->view('common/footer');
    }
    
    public function lister() {
		$data['section_title'] = 'Liste des utilisateurs';
		
		$data['utilisateurs'] = $this->utilisateurs_model->lister_utilisateurs();
        $this->load->view('utilisateurs/lister', $data);
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
