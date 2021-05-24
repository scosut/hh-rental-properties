<?php
	class Admin {
		private $db;
		
		public function __construct() {
			$this->db = new Database();
		}
		
		# verify username exists
		public function checkUsername($data) {
			$this->db->query("CALL spCheckUsername(:_username)");
			$this->db->bind(":_username", $data->username->value);
			$row = $this->db->single();

			return $row->usercount > 0;
		}
		
		# verify password match for specific user
		public function checkPassword($data) {
			$this->db->query("CALL spGetPassword(:_username)");			
			$this->db->bind(":_username", $data->username->value);
			$row = $this->db->single();
			
			return password_verify($data->password->value, $row->password);
		}		
		
		# verify password match for specific user
		public function updatePassword($username, $password) {
			$this->db->query("CALL spUpdatePassword(:_username, :_password)");
			
			$params = [
				":_username" => $username,
				":_password" => password_hash($password, PASSWORD_DEFAULT)
			];
			
			$this->db->bindArray($params);
			
			# execute
			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}		
	}
?>