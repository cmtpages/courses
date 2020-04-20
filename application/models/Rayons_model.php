<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rayons_model extends CI_Model
{
	protected $table = 'rayons_rayon';
	
	public function __construct() {
        parent::__construct();
    }
    
    public function consulter_rayon($id_rayon) {
		$query = $this->db->get_where($this->table, array('rayon_date_suppression' => NULL, 'rayon_id' => $id_rayon))->result_array();
		
		return $query;
    }
	
	public function lister_rayons(){
		$query = $this->db->order_by('rayon_nom')->get_where($this->table, array('rayon_date_suppression' => NULL))->result_array();
		
		return $query;
	}
	
	public function save_rayon($rayon) {
		$this->db->insert($this->table, $rayon);
	}
	
	public function update_rayon($id_rayon, $data) {
		$this->db->where('rayon_id', $id_rayon);
		$this->db->update($this->table, $data);
	}
}
