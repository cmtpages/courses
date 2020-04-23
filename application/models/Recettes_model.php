<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recettes_model extends CI_Model
{
	protected $table = 'recettes_recette';
	
	public function __construct() {
        parent::__construct();
    }
    
    public function consulter_recette($id_recette) {
		$query['details'] = $this->details_recette($id_recette);
		$query['ingredients'] = $this->ingredients_recette($id_recette);
		return $query;
    }
	
	public function lister_recettes(){
		$query = $this->db->order_by('recette_nom')->get_where($this->table, array('recette_date_suppression' => NULL))->result_array();
		
		return $query;
	}
	
	public function lister_unites() {
		$query = $this->db->get_where('referentiel_unites', array('unite_date_suppression' => NULL))->result_array();
		
		return $query;
	}
	
	public function save_recette($recette) {
		$this->db->insert($this->table, $recette);
		return $this->db->insert_id();
	}
	
	public function save_recette_ingredients($ingredients) {
		$this->db->insert_batch('recettes_ingredients', $ingredients);
    }
	
	public function supprimer_ingredients_recette($id_recette, $date_suppression) {
		$this->db->where('recette_id', $id_recette);
		$this->db->update('recettes_ingredients', $date_suppression);
	}
	
	public function update_recette($id_recette, $data) {
		$this->db->where('recette_id', $id_recette);
		$this->db->update($this->table, $data);
	}
	
	// PROTECTED FUNCTION
	protected function details_recette($id_recette) {
		$query = $this->db->select('recette_nom, recette_instructions, recette_nombre_personnes, recette_id')
				 ->from($this->table)
				 ->where('recette_date_suppression IS NULL', NULL, False)		         ->where('recette_id ='.$id_recette)
				 ->get()->result_array();
		return $query;
	}

	protected function ingredients_recette($id_recette) {
		$query = $this->db->select('i.ingredient_quantite, p.produit_nom, u.unite_nom, i.recette_id, p.produit_id, u.unite_id')
			  ->from($this->table.' AS r')
			  ->join('recettes_ingredients AS i', 'r.recette_id=i.recette_id')
			  ->join('produits_produit AS p', 'p.produit_id=i.produit_id')
			  ->join('referentiel_unites AS u', 'i.unite_id=u.unite_id', 'left')
			  ->where('r.recette_id='.$id_recette)
			  ->where('i.ingredient_date_suppression IS NULL', NULL, False)
			  ->get()->result_array();
			  
		return $query;
	}
}
