<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Produits_model extends CI_Model
{
	protected $table = 'produits_produit';
	
	
	public function __construct() {
        parent::__construct();
    }
    
    public function consulter_produit($id_produit) {
		$query = $this->db->select('r.rayon_nom, r.rayon_id, p.produit_nom, p.produit_id, r.rayon_date_suppression')
				 ->from('rayons_rayon AS r, '.$this->table.' AS p')
				 ->where('p.produit_date_suppression IS NULL', NULL, False)
		         ->where('r.rayon_date_suppression IS NULL', NULL, False)
		         ->where('p.produit_id ='.$id_produit)
		         ->where('p.utilisateur_id = '.$this->session->userdata['utilisateur_id'])
		         ->where('p.rayon_id=r.rayon_id')
				 ->get()->result_array();
		return $query;
    }
	
	public function lister_produits($order=NULL){
		if($order==NULL)
			$order = 'r.rayon_nom, p.produit_nom';
		$query = $this->db->select('r.rayon_nom, p.produit_nom, p.produit_id')
		         ->from('rayons_rayon AS r, produits_produit AS p')
		         ->where('p.produit_date_suppression IS NULL', NULL, False)
		         ->where('r.rayon_date_suppression IS NULL', NULL, False)
		         ->where('r.rayon_id = p.rayon_id')
		         ->where('p.utilisateur_id = '.$this->session->userdata['utilisateur_id'])
		         ->where('r.utilisateur_id = '.$this->session->userdata['utilisateur_id'])
				 ->order_by($order)
				 ->get()->result_array();
		return $query;
	}
	
	
	public function lister_produits_rayon($id_rayon) {
		$query = $this->db->select('r.rayon_nom, p.produit_nom, p.produit_id')
			->from('rayons_rayon AS r, produits_produit AS p')
			->where('p.produit_date_suppression IS NULL', NULL, False)
			->where('r.rayon_date_suppression IS NULL', NULL, False)
			->where('r.rayon_id = p.rayon_id')
			->where('p.rayon_id ='.$id_rayon)
			->where('p.utilisateur_id = '.$this->session->userdata['utilisateur_id'])
			->where('r.utilisateur_id = '.$this->session->userdata['utilisateur_id'])
			->order_by('p.produit_nom')
			->get()->result_array();
		return $query;
	}
	
	public function lister_recettes_produit($id_produit) {
		$query = $this->db->select('r.recette_nom, r.recette_id')
			  ->from($this->table.' AS p')
			  ->join('recettes_ingredients AS i', 'p.produit_id=i.produit_id')
			  ->join('recettes_recette AS r', 'r.recette_id=i.recette_id')
			  ->where('p.produit_id='.$id_produit)
			  ->where('p.produit_date_suppression IS NULL', NULL, False)
			  ->where('i.ingredient_date_suppression IS NULL', NULL, False)
			  ->where('p.utilisateur_id = '.$this->session->userdata['utilisateur_id'])
			  ->where('r.utilisateur_id = '.$this->session->userdata['utilisateur_id'])
			  ->get()->result_array();
			  
		return $query;
	}
	
	public function save_produit($produit) {
        $produit['utilisateur_id'] = $this->session->userdata['utilisateur_id'];
		$this->db->insert($this->table, $produit);
	}
	
	public function update_produit($id_produit, $data) {
		$this->db->where('produit_id', $id_produit);
		$this->db->update($this->table, $data);
	}
}
