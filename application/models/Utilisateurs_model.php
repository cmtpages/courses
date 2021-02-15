<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utilisateurs_model extends CI_Model
{
	protected $table = 'utilisateurs_utilisateur';
	
	public function __construct() {
        parent::__construct();
    }
    
    public function consulter_utilisateur($id_utilisateur) {
		$query = $this->db->get_where($this->table, array('utilisateur_date_suppression' => NULL, 'utilisateur_id' => $id_utilisateur))->result_array();
		
		return $query;
    }
    
    public function conecter_utilisateur($utilisateur_login, $utilisateur_password) {
		$query = $this->db->get_where($this->table, array('utilisateur_date_suppression' => NULL, 'utilisateur_password' => $utilisateur_password, 'utilisateur_login' => $utilisateur_login))->result_array();
		
		return $query;
    }
	
	public function lister_utilisateurs(){
		$query = $this->db->order_by('utilisateur_id')->get_where($this->table, array('utilisateur_date_suppression' => NULL))->result_array();
		
		return $query;
	}
	
	public function save_utilisateur($utilisateur) {
		$this->db->insert($this->table, $utilisateur);
	}
	
	public function update_utilisateur($id_utilisateur, $data) {
		$this->db->where('utilisateur_id', $id_utilisateur);
		$this->db->update($this->table, $data);
	}
}
