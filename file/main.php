<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_gestion_utilisateurs extends CI_Controller {
 
	public function index(){
		$this->pageConnexion();
	}
	
	public function pageConnexion(){
		if(!is_null($this->session->matricule)){
			$this->session->unset_userdata('matricule');
			$this->session->set_tempdata( array( 'etat'=>'succes', 'message'=>'Déconnexion réussie !') );
			redirect('./');
		} else {
			$this->load->view("v_connexion");
			$this->load->view("v_footer");
		}
	}
 

	public function connexion(){
		$this->load->model('M_gestion_utilisateurs');
		$infosUser = $this->M_gestion_utilisateurs->getInfosCollaborateur($this->input->post('matricule'));

		if($infosUser){
			$infosUser = $infosUser[0];
			if($infosUser['MDP']==$this->input->post('mdp')){
				$this->session->set_userdata( array(
					'matricule' => $this->input->post('matricule'),
					'libTypCol' => $infosUser['LIB_TYPE'],
					'nom'		=> $infosUser['COL_NOM'],
					'prenom'	=> $infosUser['COL_PRENOM']
				));
				$this->session->set_tempdata(array('etat'=>'succes','message'=>'Connexion réussie. Bienvenue, '.strtoupper($infosUser['COL_NOM']).' '.$infosUser['COL_PRENOM'].' !'));
				redirect('./');
			} else {
				$this->session->set_tempdata(array('etat'=>'erreur','message'=>'Erreur de mot de passe !'));
				redirect('./c_gestion_utilisateurs/pageConnexion');
			}
		} else {
			$this->session->set_tempdata(array('etat'=>'erreur','message'=>'Erreur d\'identifiant !'));
			redirect('./c_gestion_utilisateurs/pageConnexion');
		}
	}

}
/* End of file c_gestion_utilisateurs.php */
/* Location: ./application/controllers/c_gestion_utilisateurs.php */
?>
