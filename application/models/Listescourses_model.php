<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listescourses_model extends CI_Model
{
	protected $table = 'courses_listes';
	
	public function __construct() {
        parent::__construct();
    }
	
	// PUBLIC FUNCTION
	// *** Fonctions unités
	public function get_unite_id($unite_nom) {
		$query = $this->db->select('unite_id')
				 ->from('referentiel_unites')
				 ->where('unite_date_suppression IS NULL', NULL, False)		         ->where("unite_nom ='".$unite_nom."'")
				 ->get()->result_array();
		
		if (!empty($query)) return $query[0]['unite_id'];
		else return NULL;
	}
	
	public function get_unite_nom($id_unite) {
		$query = $this->db->select('unite_nom')
				 ->from('referentiel_unites')
				 ->where('unite_date_suppression IS NULL', NULL, False)		         ->where('unite_id ='.$id_unite)
				 ->get()->result_array();
		
		return $query[0]['unite_nom'];
	}
	
	//*** Fonctions sur les listes de courses
	public function consulter_liste_de_courses($id_liste) {
		$query['liste'] = $this->details_liste($id_liste);
		$query['recettes_liste'] = $this->recettes_liste($id_liste);
		
		return $query;
    }
    
    public function creer_achats($achats) {
		$this->db->insert_batch('courses_achats', $achats);
    }
    
	public function details_liste($id_liste) {
		$query = $this->db->select('liste_nom, liste_id')
				 ->from($this->table)
				 ->where('liste_date_suppression IS NULL', NULL, False)		         ->where('liste_id ='.$id_liste)
				 ->get()->result_array();
		return $query;
	}
    
    public function get_achats_liste_courses($id_liste) {
		$query = $this->db->select('SUM(a.achat_quantite) AS achat_quantite_totale, p.produit_nom, r.rayon_id, r.rayon_nom, u.unite_nom')
		         ->from('courses_achats AS a')
		         ->join('produits_produit AS p', 'p.produit_id=a.produit_id')
		         ->join('referentiel_unites AS u', 'u.unite_id=a.unite_id', 'left')
		         ->join('rayons_rayon AS r', 'r.rayon_id=p.rayon_id')
		         ->where('a.liste_id='.$id_liste)
		         ->group_by('a.produit_id, a.unite_id')
		         ->order_by('r.rayon_nom, p.produit_nom')
		         ->get()->result_array();
		return $query;
	}
	
	public function get_rayons_liste_courses($id_liste) {
		$query = $this->db->distinct()
		       ->select('r.rayon_id, r.rayon_nom')
		       ->from('rayons_rayon AS r')
		       ->join('produits_produit AS p', 'p.rayon_id=r.rayon_id')
		       ->join('courses_achats AS a', 'a.produit_id=p.produit_id')
		       ->where('a.liste_id='.$id_liste)
		       ->order_by('r.rayon_nom')
		       ->get()->result_array();
		return $query;
	}
	
	public function lister_ingredients_recette_liste_de_courses($id_liste) {
		$query = $this->db->select('SUM(i.ingredient_quantite*cr.courses_recette_nombre_personnes) AS ingredient_quantite_totale, p.produit_id, p.produit_nom, r.rayon_nom, u.unite_id, u.unite_nom')
		         ->from('recettes_ingredients AS i')
		         ->join('recettes_recette AS r', 'r.recette_id=i.recette_id')
		         ->join('courses_recettes AS cr', 'cr.recette_id=r.recette_id')
		         ->join('courses_listes AS l', 'cr.liste_id=l.liste_id')
		         ->join('produits_produit AS p', 'i.produit_id=p.produit_id')
		         ->join('rayons_rayon AS r', 'p.rayon_id=r.rayon_id')
		         ->join('referentiel_unites AS u', 'u.unite_id=i.unite_id', 'left')
		         ->where('l.liste_id='.$id_liste)
		         ->where('i.ingredient_date_suppression IS NULL', NULL, False)
		         ->where('cr.recette_date_suppression IS NULL', NULL, False)
		         ->group_by('p.produit_id, u.unite_id')
		         ->order_by('p.produit_nom')
		         ->get()->result_array();
		return $query;
	}
	
	public function lister_listes_de_courses() {
		$query = $this->db->order_by('liste_date_creation DESC, liste_nom')->get_where($this->table, array('liste_date_suppression' => NULL))->result_array();
		
		return $query;
	}
	
	public function update_liste_de_courses($id_liste, $data) {
		$this->db->where('liste_id', $id_liste);
		$this->db->update($this->table, $data);
	}
	
	public function save_listecourses($liste) {
		$this->db->insert($this->table, $liste);
		
		return $this->db->insert_id();
	}
	
	public function save_listecourses_recettes($recettes) {
		$this->db->insert_batch('courses_recettes', $recettes);
    }
    
    public function supprimer_recettes_liste($id_liste, $date_suppression) {
		$this->db->where('liste_id', $id_liste);
		$this->db->update('courses_recettes', $date_suppression);
	}
	
	// PROTECTED FUNCTION
	protected function recettes_liste($id_liste) {
		$query = $this->db->select('r.recette_nom, r.recette_id, r.recette_nombre_personnes')
                 ->from('recettes_recette AS r')
                 ->join('courses_recettes AS cr', 'cr.recette_id=r.recette_id')
                 ->join($this->table.' AS l', 'l.liste_id=cr.liste_id')
                 ->where('l.liste_id='.$id_liste)
                 ->where('r.recette_date_suppression IS NULL', NULL, False)
                 ->where('cr.recette_date_suppression IS NULL', NULL, False)
                 ->get()->result_array();
		return $query;
	}
}
