<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_model extends CI_Model {

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
				$this->load->database();
        }

       public function get_nonremove_inventories($searchkey="") 
		{
			
			$str = "SELECT MIN(t3.inventory_id) AS inventory_id, COUNT(t3.part_number) AS inventory_count, t3.remark, t3.part_number, t3.serial_number, t3.description, t3.location, t3.register_time, t3.register_username ";
			$str .= " FROM( SELECT * FROM (SELECT t1.*, users.user_name AS remove_username FROM (SELECT i.*, u.user_name AS register_username FROM inventory AS i";
			$str .= " LEFT JOIN users AS u ON i.register_userid=u.user_id) AS t1 LEFT JOIN users ON t1.remove_userid=users.user_id) AS t2";
				
			
			if ($searchkey != "") {
					$str .= " WHERE t2.part_number LIKE '%".$searchkey."%'";
					$str .= " OR t2.serial_number LIKE '%".$searchkey."%'";
					$str .= " OR t2.description LIKE '%".$searchkey."%'";
					$str .= " OR t2.remark LIKE '%".$searchkey."%'";
					$str .= " OR t2.location LIKE '%".$searchkey."%'";
					$str .= " OR t2.register_time LIKE '%".$searchkey."%'";
					$str .= " OR t2.register_username LIKE '%".$searchkey."%'";
			}

			$str .= ")  AS t3 WHERE t3.remove_userid = 0  GROUP BY t3.part_number, t3.remark, t3.serial_number, t3.description, t3.location, t3.register_time, t3.register_userid"; 
			
			$query = $this->db->query($str);
			$result = $query->result();
		
			return $result;


		}

		public function get_inventories($searchkey="")
		{
			
			$str = "SELECT MIN(t2.inventory_id) AS inventory_id, COUNT(part_number) AS inventory_count, t2.remark, t2.part_number, t2.serial_number, t2.location, t2.description, t2.remove_userid, t2.remove_username,		t2.remove_time, t2.register_userid, t2.register_username, t2.register_time FROM(";
			
			$str .= "SELECT * FROM (SELECT t1.*, users.user_name AS remove_username FROM (SELECT i.*, u.user_name AS register_username FROM inventory AS i LEFT JOIN users AS u ON i.register_userid=u.user_id)		AS t1 LEFT JOIN users ON t1.remove_userid=users.user_id) AS t2";
				
			
			if ($searchkey != "") {
				$str .= "  WHERE  t2.part_number LIKE '%".$searchkey."%'";
				$str .= " OR t2.serial_number LIKE '%".$searchkey."%'";
				$str .= " OR t2.description LIKE '%".$searchkey."%'";
				$str .= " OR t2.remark LIKE '%".$searchkey."%'";
				$str .= " OR t2.location LIKE '%".$searchkey."%'";
				$str .= " OR t2.register_time LIKE '%".$searchkey."%'";
				$str .= " OR t2.remove_time LIKE '%".$searchkey."%'";
				$str .= " OR t2.register_username LIKE '%".$searchkey."%'";
				$str .= " OR t2.remove_username LIKE '%".$searchkey."%'";
					
			}
			
			$str .= " ) AS t2";
			$str .= " GROUP BY t2.part_number, t2.serial_number, t2.description, t2.remark, t2.location, t2.register_time, t2.register_userid, t2.remove_userid, t2.remove_time ORDER BY remove_userid DESC ";
	
			$query = $this->db->query($str);
			$result = $query->result();
		
			return $result;
		}

        public function delete_inventory($inventory_id)
		{
			
			
			if ($inventory_id > 0) {
				
				$str = "SELECT * FROM (SELECT t1.*, users.user_name AS remove_username FROM (SELECT i.*, u.user_name AS register_username FROM			inventory		AS i LEFT JOIN users AS u ON i.register_userid=u.user_id) AS t1 LEFT JOIN users ON t1.remove_userid=users.user_id)		AS t2";
				$str .= " WHERE t2.inventory_id=".$inventory_id;
				$query = $this->db->query($str);
				$result = $query->result();
		
				$serial_number = $result[0]->serial_number;
				$description = $result[0]->description;
				$location = $result[0]->location;
				$remark = $result[0]->remark;
				$part_number = $result[0]->part_number;
				$register_userid = $result[0]->register_userid;
				$register_time = $result[0]->register_time;
				$remove_userid = $result[0]->remove_userid;
				$remove_time = $result[0]->remove_time;

				$str ="SELECT inventory_id FROM inventory WHERE";
				$str .= " serial_number='".$serial_number."' AND ";
				$str .= " description='".$description."' AND ";
				$str .= " location='".$location."' AND ";
				$str .= " remark='".$remark."' AND ";
				$str .= " part_number='".$part_number."' AND ";
				$str .= " register_userid='".$register_userid."' AND ";
				$str .= " register_time='".$register_time."' AND ";
				$str .= " remove_userid='".$remove_userid."' AND ";
				$str .= " remove_time='".$remove_time."'";
				$query = $this->db->query($str);
				$result = $query->result();

				foreach($result as $item)
				{
					
					$str = "INSERT INTO deleted_inventory (part_number, serial_number, description, remark, location, register_time, register_userid,						remove_userid, remove_time) ";
					$str .= "VALUES ('".$part_number."',";
					$str .= "'".$serial_number."',";
					$str .= "'".$description."',";
					$str .= "'".$remark."',";
					$str .= "'".$location."',";
					$str .= "'".$register_time."',";
					$str .=  $register_userid.",";
					$str .=  $remove_userid.",";
					$str .= "'".$remove_time."')";
					$query = $this->db->query($str);
					
					$str = "DELETE FROM inventory WHERE inventory_id=".$item->inventory_id;
					$query = $this->db->query($str);

					$imgUrl = "img/inventory/".$item->inventory_id.".jpg";
					if (file_exists($imgUrl))
						unlink($imgUrl);

				}

			}
			


		}

	
		public function get_nonremove_inventory($inventory_id)
		{
			
			$str = "SELECT * FROM (SELECT t1.*, users.user_name AS remove_username FROM (SELECT i.*, u.user_name AS register_username FROM inventory		AS i LEFT JOIN users AS u ON i.register_userid=u.user_id) AS t1 LEFT JOIN users ON t1.remove_userid=users.user_id) AS t2";
			$str .= " WHERE t2.inventory_id=".$inventory_id;
			$query = $this->db->query($str);
			$result = $query->result();
			
			$serial_number = $result[0]->serial_number;
			$description = $result[0]->description;
			$location = $result[0]->location;
			$remark = $result[0]->remark;
			$part_number = $result[0]->part_number;
			$register_userid = $result[0]->register_userid;
			$register_time = $result[0]->register_time;
			
			$str = "SELECT inventory.*, u.user_name AS register_username, COUNT(inventory_id) as quantity FROM inventory  LEFT JOIN users AS u ON u.user_id=register_userid WHERE remove_userid =0 AND";
			$str .= " serial_number='".$serial_number."' AND";
			$str .= " description='".$description."' AND";
			$str .= " location='".$location."' AND";
			$str .= " remark='".$remark."' AND";
			$str .= " part_number='".$part_number."' AND";
			$str .= " register_userid='".$register_userid."' AND";
			$str .= " register_time='".$register_time."'";
			
			$query = $this->db->query($str);
			$result = $query->result();
				
			return $result;
			

		}

		public function get_inventory($inventory_id)
		{
			
			$str = "SELECT * FROM (SELECT t1.*, users.user_name AS remove_username FROM (SELECT i.*, u.user_name AS register_username FROM inventory		AS i LEFT JOIN users AS u ON i.register_userid=u.user_id) AS t1 LEFT JOIN users ON t1.remove_userid=users.user_id) AS t2";
			$str .= " WHERE t2.inventory_id=".$inventory_id;
			$query = $this->db->query($str);
			$result = $query->result();
			
			$serial_number = $result[0]->serial_number;
			$description = $result[0]->description;
			$location = $result[0]->location;
			$remark = $result[0]->remark;
			$part_number = $result[0]->part_number;
			$register_userid = $result[0]->register_userid;
			$register_time = $result[0]->register_time;
			$remove_userid = $result[0]->remove_userid;
			$remove_time = $result[0]->remove_time;
		
			$str = "SELECT inventory.*, u.user_name AS register_username, COUNT(inventory_id) as quantity FROM inventory  LEFT JOIN users AS u ON u.user_id=register_userid WHERE ";
			$str .= " serial_number='".$serial_number."' AND";
			$str .= " description='".$description."' AND";
			$str .= " location='".$location."' AND";
			$str .= " remark='".$remark."' AND";
			$str .= " part_number='".$part_number."' AND";
			$str .= " register_userid='".$register_userid."' AND";
			$str .= " register_time='".$register_time."' AND ";
			$str .= " remove_userid='".$remove_userid."'";
			if ($remove_userid != 0) 
			{
				
				$str .= " AND remove_time='".$remove_time."'";
			}


					
			$query = $this->db->query($str);
			$result = $query->result();
				
			return $result;
			

		}

		public function get_duplicatedlocation() {
			$str = "SELECT location FROM inventory  GROUP BY location;";
			$query = $this->db->query($str);
			$result = $query->result();
		
			return $result;
		}

		public function get_duplicateddescription() {
			$str = "SELECT description FROM inventory  GROUP BY description;";
			$query = $this->db->query($str);
			$result = $query->result();
		
			return $result;
		}

		public function user_update_inventory($inventory_id) {
			if ($inventory_id > 0) {
				
				$str = "SELECT * FROM (SELECT t1.*, users.user_name AS remove_username FROM (SELECT i.*, u.user_name AS register_username FROM			inventory		AS i LEFT JOIN users AS u ON i.register_userid=u.user_id) AS t1 LEFT JOIN users ON t1.remove_userid=users.user_id)		AS t2";
				$str .= " WHERE t2.inventory_id=".$inventory_id;
				$query = $this->db->query($str);
				$result = $query->result();
			
				$serial_number = $result[0]->serial_number;
				$description = $result[0]->description;
				$location = $result[0]->location;
				$remark = $result[0]->remark;
				$part_number = $result[0]->part_number;
				$register_userid = $result[0]->register_userid;
				$register_time = $result[0]->register_time;
				


				$str = "UPDATE inventory SET ";
				$str .= " serial_number ='".$this->input->post('serial_number')."', ";
				$str .= " part_number ='".$this->input->post('part_number')."', ";
				$str .= " description ='".$this->input->post('description')."', ";
				$str .= " remark ='".$this->input->post('remark')."', ";
				$str .= " location ='".$this->input->post('location')."', ";
				$str .= " remove_time ='".$this->input->post('remove_time')."', ";
				$str .= " remove_userid =".$this->input->post('remove_userid').",";
				
				$str .= " register_time ='".$this->input->post('register_time')."', ";
				$str .= " register_userid =".$this->input->post('register_userid');
				
				$str .= " WHERE serial_number='".$serial_number."' AND ";
				$str .= " description='".$description."' AND ";
				$str .= " location='".$location."' AND ";
				$str .= " remark='".$remark."' AND ";
				$str .= " part_number='".$part_number."' AND ";
				$str .= " register_userid='".$register_userid."' AND ";
				$str .= " remove_userid=0";



				$query = $this->db->query($str);
				return true;
			}
			else {
				return false;
			}
		}
		

	public function	remove_inventory($inventory_id, $remove_userid, $remove_quantity)
	{
		if ($inventory_id > 0 && $remove_userid > 0 ) 
		{
			date_default_timezone_set("UTC");
			$remove_time = date("Y-m-d H:i:s");

			$str = "SELECT * FROM (SELECT t1.*, users.user_name AS remove_username FROM (SELECT i.*, u.user_name AS register_username FROM			inventory		AS i LEFT JOIN users AS u ON i.register_userid=u.user_id) AS t1 LEFT JOIN users ON t1.remove_userid=users.user_id)		AS t2";
			$str .= " WHERE t2.inventory_id=".$inventory_id;
			$query = $this->db->query($str);
			$result = $query->result();
			
			$serial_number = $result[0]->serial_number;
			$description = $result[0]->description;
			$location = $result[0]->location;
			$remark = $result[0]->remark;
			$part_number = $result[0]->part_number;
			$register_userid = $result[0]->register_userid;
			$register_time = $result[0]->register_time;

			//UPDATE inventory SET remove_userid=16 WHERE inventory_id IN (SELECT inventory_id FROM (SELECT * FROM inventory LIMIT 0,5) tmp )
			$str = "UPDATE inventory SET ";
			$str .= " remove_userid=".$remove_userid.",";
			$str .= " remove_time='".$remove_time."'";
			
			$str .= " WHERE inventory_id IN (SELECT inventory_id FROM (SELECT * FROM inventory";

			$str .= " WHERE serial_number='".$serial_number."' AND ";
			$str .= " description='".$description."' AND ";
			$str .= " location='".$location."' AND ";
			$str .= " remark='".$remark."' AND ";
			$str .= " part_number='".$part_number."' AND ";
			$str .= " register_userid='".$register_userid."' AND ";
			$str .= " remove_userid=0";
			$str .= " LIMIT 0,".$remove_quantity;
			$str .= ") tmp )";

			$query = $this->db->query($str);
			return true;
		}
			return false;
	}

	public function admin_update_inventory($inventory_id)
	{
		if ($inventory_id > 0) {
				
				$str = "SELECT * FROM (SELECT t1.*, users.user_name AS remove_username FROM (SELECT i.*, u.user_name AS register_username FROM			inventory		AS i LEFT JOIN users AS u ON i.register_userid=u.user_id) AS t1 LEFT JOIN users ON t1.remove_userid=users.user_id)		AS t2";
				$str .= " WHERE t2.inventory_id=".$inventory_id;
				$query = $this->db->query($str);
				$result = $query->result();
			
				$serial_number = $result[0]->serial_number;
				$description = $result[0]->description;
				$location = $result[0]->location;
				$remark = $result[0]->remark;
				$part_number = $result[0]->part_number;
				$register_userid = $result[0]->register_userid;
				$register_time = $result[0]->register_time;
				$remove_userid = $result[0]->remove_userid;
				$remove_time = $result[0]->remove_time;

				$edit_quantity = $this->input->post('edit_quantity');
				
				$update_serial_number = $this->input->post('serial_number');
				$update_description = $this->input->post('description');
				$update_location = $this->input->post('location');
				$update_remark = $this->input->post('remark');
				$update_part_number = $this->input->post('part_number');
				$update_register_time = $this->input->post('register_time');
				$update_register_userid = $this->input->post('register_userid');
				$update_remove_time = $this->input->post('remove_time');
				$update_remove_userid = $this->input->post('remove_userid');

				$str = "UPDATE inventory SET ";
				$str .= " serial_number='".$update_serial_number."',";
				$str .= " description='".$update_description."',";
				$str .= " location='".$update_location."',";
				$str .= " remark='".$update_remark."',";
				$str .= " part_number='".$update_part_number."',";
				$str .= " register_time='".$update_register_time."',";
				$str .= " register_userid='".$update_register_userid."',";
				$str .= " remove_time='".$update_remove_time."',";
				$str .= " remove_userid='".$update_remove_userid."'";

				$str .= " WHERE inventory_id IN (SELECT inventory_id FROM (SELECT * FROM inventory";

				$str .= " WHERE serial_number='".$serial_number."' AND ";
				$str .= " description='".$description."' AND ";
				$str .= " location='".$location."' AND ";
				$str .= " remark='".$remark."' AND ";
				$str .= " part_number='".$part_number."' AND ";
				$str .= " register_userid='".$register_userid."' AND ";
				$str .= " register_time='".$register_time."' AND ";
				$str .= " remove_userid='".$remove_userid."'";
				if ($remove_userid != 0)
					$str .= " AND remove_time='".$remove_time."'";
				$str .= " LIMIT 0,".$edit_quantity;
				$str .= ") tmp )";

				
				$query = $this->db->query($str);
				return true;
			}
			else {
				return false;
			}

	}
}