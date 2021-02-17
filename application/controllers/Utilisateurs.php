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
            $data['utilisateur'] = $this->utilisateurs_model->conecter_utilisateur($post['utilisateur_login'], $post['utilisateur_password']);
            if(empty($data['utilisateur'])) {
                $this->session->set_flashdata('error_message', 'L\'utilisateur demandé n\'existe pas (mauvais nom d\'utilisateur ou mauvais mot de passe).');
               $this->load->view('utilisateurs/connecter', $data);
            }
            else {
                $data['utilisateur'] =$data['utilisateur'][0];
                $this->session->set_userdata('utilisateur_id', $data['utilisateur']['utilisateur_id']);
                $this->session->set_userdata('utilisateur_login', $data['utilisateur']['utilisateur_login']);
                $this->session->set_flashdata('confirm_message', 'Vous êtes maintenant connecté en tant que '.$this->session->userdata['utilisateur_login'].'.');
                redirect('rayons/lister');
            }
		}
		else { // Sinon, affichage du formulaire
            if(isset($this->session->userdata['utilisateur_login'])) {
                 $this->session->set_flashdata('error_message', 'Vous êtes déjà connecté.');
                 redirect('rayons/lister');
            }
            else
                $this->load->view('utilisateurs/connecter', $data);
		}
        $this->load->view('common/footer');
    }
    
    public function creer() {
		$this->load->helper('form');
		
		$data['section_title'] = 'Nouvel utilisateur';
		
		if($this->input->post()) { // Si c'est une validation
            $this->form_validation->set_rules('utilisateur_login', 'Nom d\'utilisateur', 'is_unique[utilisateurs_utilisateur.utilisateur_login]',
                array('is_unique' => 'Ce nom d\'utilisateur est déjà utilisé.') 
            );
            $this->form_validation->set_rules('utilisateur_mail', 'Adresse mail', 'is_unique[utilisateurs_utilisateur.utilisateur_mail]',
                array('is_unique' => 'Cette adresse mail est déjà utilisée.') 
            );
             if (!$this->form_validation->run()) { // Si formulaire incorrect
                $this->load->view('utilisateurs/creer', $data);
            }
            else { // Si formulaire correct
                $this->ajouter_utilisateur();
                $this->session->set_flashdata('confirm_message', 'L\'utilisateur a été créé.');
                redirect('utilisateurs/connecter');
            }
		}
		else // Sinon, affichage du formulaire
			$this->load->view('utilisateurs/creer', $data);
		
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
    
    // PROTECTED FUNCTIONS
    /** 
	 * \brief Prépare les données pour la création d'un rayon, et appelle la requête.
	 * 
	*/
    protected function ajouter_utilisateur() {
		$data['utilisateur'] = array(
			'utilisateur_mail' => $this->input->post('utilisateur_mail'),
			'utilisateur_login' => $this->input->post('utilisateur_login'),
			'utilisateur_password' => $this->input->post('utilisateur_password'),
			'utilisateur_date_creation' => date('Y-m-d H:i:s'),
		);
		$this->utilisateurs_model->save_utilisateur($data['utilisateur']);
    }
}
