<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
				$this->load->database();
        }

        public function get_account()
        {
			    $email = $this->input->post('email');
			    $pass = $this->input->post('password');
				$str = "SELECT * FROM users WHERE email='".$email. "'  AND pass=MD5('".$pass."')";
				
				//$this->db->query('YOUR QUERY HERE');
                $query = $this->db->query($str);
				$result = $query->result();
				return $result;
				
        }
		
		public function get_users($searchkey="")
		{
				$str = "SELECT * FROM users";
				if ($searchkey != "")
					$str .= " WHERE email LIKE '%".$searchkey."%' OR user_name LIKE '%".$searchkey."%' OR user_level LIKE '%".$searchkey."%'";
                $query = $this->db->query($str);
				$result = $query->result();
		
				return $result;
		}

        public function delete_user($user_id)
		{
			if ($user_id > 0)
			{
				$str = "DELETE FROM users WHERE user_id=".$user_id;
				$query = $this->db->query($str);
				return true;
			}
			else
				return false;
		}
		
		public function insert_user() {
				$email = $this->input->post('email');
				$password =md5($this->input->post('password'));
				$full_name = $this->input->post('full_name');
				$user_level = $this->input->post('user_level');
		
				$str = "INSERT INTO users(email, pass, user_name, user_level) VALUES(";
				$str .= "'".$email."','".$password."','".$full_name."',".$user_level.")";
				$query = $this->db->query($str);
		}

		public function change_pass($user_id) {
			$password =md5($this->input->post('password'));
			$str = "UPDATE users SET pass='".$password."' WHERE user_id=".$user_id;
			$query = $this->db->query($str);
		}
		
		

}