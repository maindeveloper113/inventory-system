<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 function __construct() {
        parent::__construct();
        $this->load->helper('url');
		$this->load->model('User_model');
		$this->load->library('session');
		
		
    }
	
	public function index()
	{
		$this->load->view('login');
	}
	public function check()
	{
		$user = $this->User_model->get_account();
		$count = count($user);


		if ($count == 1)
		{
			$newdata = array(
				'logged_in' => TRUE,
				'user_level' => $user[0]->user_level,
				'user_id' => $user[0]->user_id
			);
	
			$this->session->set_userdata($newdata);
			
			if ($this->session->user_level == 1) 
				redirect(base_url('index.php/admin'));
			else
				redirect(base_url('index.php/user'));
			
		}
		else
			$this->index();

	}
	
	public function logout()
	{
		$newdata = array(
			'logged_in' => FALSE
		);

		$this->session->set_userdata($newdata);
		$this->index();
		
	}
}
