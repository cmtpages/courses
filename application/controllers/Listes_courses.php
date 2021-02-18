<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listes_courses extends MY_Controller {
	function __construct(){
        parent::__construct();
        $this->data = array(
            'header_title' => 'Gestion des listes de courses',
        );
        $this->load->library('session');
        
        $this->load->model('listescourses_model');
        
        $this->load->view('common/header', $this->data);
        $this->load->view('common/menu', $this->data);
    }

    
	// PUBLIC FUNCTIONS
	public function consulter($id_liste = NULL) {
		$data = $this->listescourses_model->consulter_liste_de_courses($id_liste);
		$data['liste'] = $data['liste'][0];
		
		if(empty($data['liste'])) {
			$this->session->set_flashdata('error_message', 'La liste de courses demandée n\'existe pas.');
			redirect('listes_courses/lister');
		}
		
		$data['section_title'] = 'Détails de la liste de courses « '.$data['liste']['liste_nom'].' »';
		
		$this->load->view('listes_courses/consulter', $data);
        $this->load->view('common/footer');
	}
	
	public function creer() {
		$this->load->helper('form');
		
		$data['section_title'] = 'Nouvelle liste de courses';
		
		if($this->input->post()) { // Si c'est une validation
			$id_liste = $this->ajouter_listecourses();
			$this->session->set_flashdata('confirm_message', 'La liste de courses a été créée.');
			redirect('listes_courses/creer_liste_recettes/'.$id_liste);
		}
		else // Sinon, affichage du formulaire
			$this->load->view('listes_courses/creer', $data);
		
        $this->load->view('common/footer');
    }
    
	public function creer_liste_achats($id_liste_courses) {
		$this->load->helper('unites');
		$this->load->helper('form');
		
		$this->load->model('recettes_model');
		$this->load->model('produits_model');
		$this->load->model('rayons_model');
		
		$liste_courses = $this->listescourses_model->consulter_liste_de_courses($id_liste_courses)['liste'][0];
		
		$data['id_liste'] = $id_liste_courses;
		$data['unites'] = $this->recettes_model->lister_unites();
		$data['section_title'] = 'Ajout d\'achats dans la liste de courses « '.$liste_courses['liste_nom'].' »';
		
		if($this->input->post()) {
			$achats = $this->input->post()['achats'];
			
			foreach($achats as $i=>$achat) {
				if(empty($achat['achat_quantite'])) $achat['unite_id'] = NULL;
				
				if(!empty($achat['unite_id'])) {
					$nom_unite = $this->listescourses_model->get_unite_nom($achat['unite_id']);
					$nom_unite_reference = unite_reference($nom_unite);
				}
				else {
					$nom_unite=NULL;
					$nom_unite_reference=NULL;
				}
				$data['achats'][$i] = array(
					'liste_id' => $id_liste_courses,
					'produit_id' => $achat['produit_id'],
					'achat_quantite' => convertir($nom_unite, $nom_unite_reference, $achat['achat_quantite']),
					'unite_id' => $this->listescourses_model->get_unite_id($nom_unite_reference),
					'achat_date_creation' =>  date('Y-m-d H:i:s'),
				);
			}
			$this->listescourses_model->creer_achats($data['achats']);
			$this->session->set_flashdata('confirm_message', 'La liste d\'achats a été créée.');
			redirect('listes_courses/lister');
		}
		else {
			$data['produits'] = $this->produits_model->lister_produits();
			
			$liste_achats_recettes = $this->listescourses_model->lister_ingredients_recette_liste_de_courses($id_liste_courses);
			
			foreach($liste_achats_recettes as $i=>$achat) {
				$nom_unite_reference = unite_reference($achat['unite_nom']);
				
				$id_unite_reference = $this->listescourses_model->get_unite_id($nom_unite_reference);
				
				$data['achats'][$i] = array(
					'liste_id' => $id_liste_courses,
					'produit_id' => $achat['produit_id'],
					'produit_nom' => $achat['produit_nom'],
					'unite_id' => $id_unite_reference,
					'unite_nom' => $nom_unite_reference,
					'achat_quantite' => round(convertir($achat['unite_nom'], $nom_unite_reference, $achat['ingredient_quantite_totale']), 2),
				);
			}
			$this->load->view('listes_courses/creer_liste_achats', $data);
			$this->load->view('common/footer');
		}
    }
	
	public function creer_liste_recettes($id_liste_courses) {
		$this->load->helper('form');
		
		$this->load->model('recettes_model');
		
		$liste_courses = $this->listescourses_model->consulter_liste_de_courses($id_liste_courses)['liste'][0];
		
		$data['section_title'] = 'Ajout de recettes dans la liste de courses « '.$liste_courses['liste_nom'].' »';
		
		if($this->input->post()) { // Si c'est une validation
			$this->inserer_liste_recettes($id_liste_courses);
			$this->session->set_flashdata('confirm_message', 'Les recettes ont été ajoutées à la liste de courses.');
			redirect('listes_courses/creer_liste_achats/'.$id_liste_courses);
		}
		else { // Sinon, affichage du formulaire
			$data['id_liste'] = $id_liste_courses;
			$data['recettes'] = $this->recettes_model->lister_recettes();
			
			$this->load->view('listes_courses/creer_liste_recettes', $data);
		}
        $this->load->view('common/footer');
    }
	
	public function generer($id_liste) {
		$this->load->model('rayons_model');
		$this->load->model('produits_model');
		
		$liste_courses = $this->listescourses_model->details_liste($id_liste)[0];
		$liste_achats = $this->listescourses_model->get_achats_liste_courses($id_liste);
		$rayons = $this->listescourses_model->get_rayons_liste_courses($id_liste);
		
		require('application/libraries/fpdf/pdf.php');
		$pdf = new PDF('L', 'mm', 'A4');
		$pdf->title = $liste_courses['liste_nom'];
		$pdf->AddPage();
		
		foreach($rayons as $rayon) {
			$pdf->Rayon($rayon['rayon_nom']);
			$pdf->ListeAchats($liste_achats, $rayon['rayon_id']);
		}
		$pdf->Output('I', $liste_courses['liste_nom']);
    }
    
     public function lister() {
		$data['section_title'] = 'Listes de courses';
		
		$data['listes'] = $this->listescourses_model->lister_listes_de_courses();
        $this->load->view('listes_courses/lister', $data);
        $this->load->view('common/footer');
    }
    
    public function modifier($id_liste) {
		$this->load->helper('form');
		
		$data['section_title'] = 'Modification d\'une liste de courses';
		
		if($this->input->post()) {
			$data['liste'] = array(
				'liste_nom' => $this->input->post('liste_nom'),
			);
			$this->listescourses_model->update_liste_de_courses($id_liste, $data['liste']);
			$this->session->set_flashdata('confirm_message', 'La liste de courses a été modifiée.');
			redirect('listes_courses/lister');
		}
		else {
			$liste = $this->listescourses_model->consulter_liste_de_courses($id_liste)['liste'][0];
			if(empty($liste)) {
				$this->session->set_flashdata('error_message', 'La liste demandée n\'existe pas.');
				redirect('listes_courses/lister');
			}
			$data['post'] = $liste;
			$data['section_title'] = 'Modification de la liste de courses « '.$liste['liste_nom'].' »';
			
			$this->load->view('listes_courses/modifier', $data);
			$this->load->view('common/footer');
		}
	}
	
	public function modifier_liste_recettes($id_liste) {
		$this->load->helper('form');
		$data['section_title'] = 'Modification des recettes dans une liste de courses';
		
		$this->load->model('recettes_model');
		
		if($this->input->post()) {
			$this->supprimer_recettes_liste($id_liste);
			$this->inserer_liste_recettes($id_liste);
			$this->session->set_flashdata('confirm_message', 'Les recettes dans la liste de courses ont été modifiées.');
			redirect('listes_courses/creer_liste_achats/'.$id_liste);
		}
		else {
			$liste = $this->listescourses_model->consulter_liste_de_courses($id_liste);
			$liste['liste'] = $liste['liste'][0];
			
			if(empty($liste)) {
				$this->session->set_flashdata('error_message', 'La liste de courses demandée n\'existe pas.');
				redirect('listes_courses/lister');
			}
			$data['post'] = $liste;
			
			$data['recettes'] = $this->recettes_model->lister_recettes();
			
			$data['section_title'] = 'Modification de la liste de courses « '.$liste['liste']['liste_nom'].' »';
			$this->load->view('listes_courses/modifier_liste_recettes', $data);
			$this->load->view('common/footer');
		}
	}
    
   public function supprimer($id_liste) {		
		if($this->input->post()) {
			$data['liste'] = array(
				'liste_date_suppression' => date('Y-m-d H:i:s'),
			);
			$this->listescourses_model->update_liste_de_courses($id_liste, $data['liste']);
			$this->session->set_flashdata('confirm_message', 'La liste de courses a été supprimé.');
			redirect('listes_courses/lister');
		}
		else {
			$data = $this->listescourses_model->consulter_liste_de_courses($id_liste);
			$data['liste'] = $data['liste'][0];
			
			if(empty($data['liste'])) {
				$this->session->set_flashdata('error_message', 'La liste de courses demandée n\'existe pas.');
				redirect('listes_courses/lister');
			}
			
			$data['section_title'] = 'Suppression de la liste de course « '.$data['liste']['liste_nom'].' »';
			
			$this->load->view('listes_courses/supprimer', $data);
			$this->load->view('common/footer');
		}
    }
    
    // PROTECTED FUNCTIONS
    protected function ajouter_listecourses() {
		$data['liste'] = array(
			'liste_nom' => $this->input->post('liste_nom'),
			'utilisateur_id' => $this->session->userdata['utilisateur_id'],
			'liste_date_creation' => date('Y-m-d H:i:s'),
		);
		return $this->listescourses_model->save_listecourses($data['liste']);
    }
    
	protected function inserer_liste_recettes($id_liste) {
		$post = $this->input->post();
		foreach($post['recettes'] as $i => $recette) {
			$recette['recette_date_creation'] = date('Y-m-d H:i:s');
			$recette['liste_id'] = $id_liste;
			$data['recettes'][$i] = $recette;
		}
		$this->listescourses_model->save_listecourses_recettes($data['recettes']);
	}
	
	protected function supprimer_recettes_liste($id_liste) {
		$recette_date_suppression = array(
			'recette_date_suppression' => date('Y-m-d H:i:s')
		);
		$this->listescourses_model->supprimer_recettes_liste($id_liste, $recette_date_suppression);
    }
    
}
