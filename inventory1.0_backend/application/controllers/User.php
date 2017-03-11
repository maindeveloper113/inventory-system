<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
	
	public function index()
	{
		$this->invantories();
	}
	
	public function invantories()
	{
		$searchkey = $this->input->get('searchkey');
		$data['inventories'] = $this->Inventory_model->get_nonremove_inventories($searchkey);
	
		$this->load->view('user/manager_inventory', $data);
	}

	public function confirm_remove_inventory($inventory_id)
	{
		$result = $this->Inventory_model->get_nonremove_inventory($inventory_id);
		$data['inventory'] = $result[0];

		$this->load->view('user/remove_inventory', $data);
		
	}

	public function remove_inventory($inventory_id)
	{
		$remove_quantity = $this->input->post('remove_quantity');
		$remove_userid = $this->session->user_id;
		$this->Inventory_model->remove_inventory($inventory_id, $remove_userid, $remove_quantity);
		$this->invantories();
		
	}

	public function edit_inventory($inventory_id)
	{
		$result = $this->Inventory_model->get_nonremove_inventory($inventory_id);
		$data['inventory'] = $result[0];

		$locations = $this->Inventory_model->get_duplicatedlocation();
		$data['locations'] = $locations;

		$descriptions = $this->Inventory_model->get_duplicateddescription();
		$data['descriptions'] = $descriptions; 

		$data['users'] = $this->User_model->get_users("");


		$this->load->view('user/edit_inventory', $data);
	}


	public function update_inventory($inventory_id) {
		$this->Inventory_model->user_update_inventory($inventory_id);
		$this->invantories();

		 
	}
}
