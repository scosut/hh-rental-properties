<?php
	class Pages extends Controller {
		private $propertyModel;
		private $adminModel;
		
		public function __construct() {
			$this->propertyModel = $this->model("Property");
			$this->adminModel    = $this->model("Admin");
		}
		
		public function index() {
			$this->view("pages/index");
		}
		
		public function apply() {
			$properties = $this->propertyModel->getAvailableProperties();
			
			$data = [
				"count" => count($properties)
			];
			
			$this->view("pages/apply", $data);
		}
		
		public function confirm() {
			$this->view("pages/confirm");
		}
		
		public function download() {
			$this->view("pages/download");
		}
		
		public function logout() {
			Utility::logout();
		}
		
		/*public function password() {
			$this->adminModel->updatePassword("username", "password");
			Utility::redirect("apply");
		}*/
		
		public function login() {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$post = json_decode($_POST["data"], true);
				$post = filter_var_array($post, FILTER_SANITIZE_STRING);
				$data = Validate::setProperties(array_keys($post["login"]), $post["login"]);
				$row = "";
				
				Validate::isNotEmpty($data->username, "Please enter username.");
				Validate::isNotEmpty($data->password, "Please enter password.");
				
				if (Validate::isValid($data)) {					
					if (!$this->adminModel->checkUsername($data)) {
						Validate::toggleError($data->username, true, "Username not found.");
					}
					else {
						if (!$this->adminModel->checkPassword($data)) {
							Validate::toggleError($data->password, true, "Invalid password.");
						}
					}
				}
					
				if (Validate::isValid($data)) {
					Utility::login();
					echo json_encode(["succeeded" => true, "redirect" => "/properties/dashboard"]);
				}
				else {
					echo json_encode(["succeeded" => false, "errors" => Validate::getErrors($data), "firstError" => Validate::getFirstError($data)]);
				}
			}
			else {
				$this->view("pages/login");	
			}			
		}
		
		public function application() {
			$properties = $this->propertyModel->getAvailableProperties();
			
			if (count($properties) > 0) {
				$states = Utility::getStates();

				$data = [
					"properties" => $properties,
					"states"     => $states
				];

				$this->view("pages/application", $data);
			}
			else {
				Utility::redirect("apply");
			}
		}
	}
?>