<?php
 
/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */
 
class DB_Functions {
 
    private $conn;
 
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
 
   	
    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {

		$str = "SELECT * FROM users WHERE email='".$email."';";
		$result = $this->conn->query($str);
		$user = $result->fetch_assoc();

		if (md5($password) == $user['pass']) 
                // user authentication details are correct
                return $user;
		
		else
			return null;
		
    }
 
    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
       $stmt = $this->conn->prepare("SELECT email from users WHERE email = ?");
 
        $stmt->bind_param("s", $email);
 
        $stmt->execute();
 
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }

    }
	
	public function get_inventories($searchkey="")
	{
		
				$str = "SELECT MIN(t3.inventory_id) AS id, COUNT(t3.part_number) AS quantity, t3.remark, t3.part_number, t3.serial_number, t3.description, t3.location, t3.register_time, t3.register_username ";
						
				$str .= " FROM( SELECT * FROM (SELECT t1.*, users.user_name AS remove_username FROM (SELECT i.*, u.user_name AS register_username FROM inventory AS i";
				$str .= " LEFT JOIN users AS u ON i.register_userid=u.user_id) AS t1 LEFT JOIN users ON t1.remove_userid=users.user_id) AS t2";
				
			
				if ($searchkey != "") {
					//$str .= " WHERE t2.inventory_name LIKE '%".$searchkey."%'";
					$str .= " WHERE t2.part_number LIKE '%".$searchkey."%'";
					$str .= " OR t2.serial_number LIKE '%".$searchkey."%'";
					$str .= " OR t2.remark LIKE '%".$searchkey."%'";
					$str .= " OR t2.description LIKE '%".$searchkey."%'";
					$str .= " OR t2.location LIKE '%".$searchkey."%'";
					$str .= " OR t2.register_time LIKE '%".$searchkey."%'";
					$str .= " OR t2.register_username LIKE '%".$searchkey."%'";
			}

			$str .= ")  AS t3 WHERE t3.remove_userid = 0  GROUP BY t3.part_number, t3.serial_number, t3.remark, t3.description, t3.location, t3.register_time, t3.register_userid"; 
			
			$result = $this->conn->query($str);
			
			
			while($row = $result->fetch_assoc())
			{				
				$post[] = $row;
			
			}
			return $post;
			
	}

	public function remove_inventory($inventory_id, $user_id, $quantity) {
			
			date_default_timezone_set("UTC");
			$date = date("Y-m-d H:i:s");

			$str = "SELECT * FROM inventory WHERE inventory_id=".$inventory_id;
			$result = $this->conn->query($str)->fetch_assoc();
		
			$part_number = $result['part_number'];
			$serial_number = $result['serial_number'];
			$remark = $result['remark'];	
			$description = $result['description'];
			$location = $result['location'];
			$register_time = $result['register_time'];
			$register_userid = $result['register_userid'];

			$str0 = "SELECT inventory_id FROM inventory";
			$str0 .= " WHERE location='".$location."' AND ";
			$str0 .= "part_number='".$part_number."' AND ";
			$str0 .= "serial_number='".$serial_number."' AND ";
			$str0 .= "remark='".$remark."' AND ";		
			$str0 .= "description='".$description."' AND ";		
			$str0 .= "location='".$location."' AND ";		
			$str0 .= "register_time='".$register_time."' AND ";		
			$str0 .= "register_userid=".$register_userid. " AND ";
			$str0 .= "remove_userid=0";
			$result = $this->conn->query($str0);
		
			for ($i = 0; $i < $quantity; $i++)
			{	
				$row = $result->fetch_assoc();	
				
				$str = "UPDATE inventory SET remove_userid=";
				$str .= $user_id. ", remove_time='";
				$str .= $date;
				$str .= "' WHERE inventory_id=".$row['inventory_id'];
						
				$this->conn->query($str);
				
			}
	}
	
	public function add_inventory($part_number, $serial_number, $remark, $description, $location, $register_userid, $register_time) {
			

			$str = "INSERT INTO inventory (part_number, serial_number, remark, description, location, register_time, register_userid)  VALUES ('";
			
			$str .= $part_number."', '";
			$str .= $serial_number."','";
			$str .= $remark."','";
			$str .= $description."', '";
			$str .= $location."', '";
			$str .= $register_time."',";
			$str .= $register_userid.")";

			$result = $this->conn->query($str);
			if ($result == 1)
			{
				$str = "SELECT MAX(inventory_id)AS inserted_id FROM inventory;";
				$result = $this->conn->query($str)->fetch_assoc();
				return $result;
			}
			else
				return false;

	}

	public function get_duplicatedlocation() {
			$str = "SELECT location FROM inventory  GROUP BY location;";
			$result = $this->conn->query($str);

			$i = 0;
			$post = "";
			while($row = $result->fetch_assoc())
			{				
				$post["a".$i] = $row['location'];
				$i++;
			}
			return $post;
			
		}

		public function get_duplicateddescription() {
			$str = "SELECT description FROM inventory  GROUP BY description;";
			$result = $this->conn->query($str);

			$i = 0;
			$post = "";
			while($row = $result->fetch_assoc())
			{				
				$post["a".$i] = $row['description'];
				$i++;
			}
			return $post;
		}
	
}
?>