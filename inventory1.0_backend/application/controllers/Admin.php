<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
        //$this->load->helper('url');
		$this->load->model('User_model');
		$this->load->model('Inventory_model');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		
		if ($this->session->logged_in == FALSE)
			redirect(base_url('index.php/login'));
		
    }

	public function register_pass($user_id) {
		
		$this->User_model->change_pass($user_id);
		$this->users();
		
		
	}

	public function change_password($user_id) {
		$data['user_id'] = $user_id;
		$this->load->view('change_password', $data);
	}
	public function index()
	{
		$this->invantories();
	}
	public function users()
	{
		$searchkey = $this->input->get('searchkey');
		$data['users'] = $this->User_model->get_users($searchkey);
		$this->load->view('manager_users', $data);
	}
	
	public function delete_user($user_id)
	{
		
		$this->User_model->delete_user($user_id);
		$this->users();
	}
	public function insert_user()
	{
		$this->load->view('insert_user');
	}
	public function add_new_user() {
		$this->User_model->insert_user();
		$this->users();
		
	}
	
	
	public function invantories()
	{
		$searchkey = $this->input->get('searchkey');
		$data['inventories'] = $this->Inventory_model->get_inventories($searchkey);
	
		$this->load->view('manager_inventory', $data);
	}
	public function delete_inventory($inventory_id)
	{
		
		$this->Inventory_model->delete_inventory($inventory_id);
		$this->invantories();
	}

	public function edit_inventory($inventory_id)
	{
		$result = $this->Inventory_model->get_inventory($inventory_id);
		$data['inventory'] = $result[0];

		$locations = $this->Inventory_model->get_duplicatedlocation();
		$data['locations'] = $locations;

		$descriptions = $this->Inventory_model->get_duplicateddescription();
		$data['descriptions'] = $descriptions; 

		$data['users'] = $this->User_model->get_users("");


		$this->load->view('edit_inventory', $data);
	}

	public function update_inventory($inventory_id) {
		$this->Inventory_model->admin_update_inventory($inventory_id);
		$this->invantories();

		 
	}
}
