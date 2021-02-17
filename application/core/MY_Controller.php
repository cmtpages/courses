<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    function __construct(){
        parent::__construct();
        
        if(!isset($this->session->userdata['utilisateur_id'])) {
            $this->session->set_flashdata('error_message', 'Il faut se connecter pour accéder aux fonctionnalités.');
            redirect('utilisateurs/connecter');
        }
    }
}
