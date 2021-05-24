<?php
	class Properties extends Controller {
		private $propertyModel;
		
		public function __construct() {
			$this->propertyModel = $this->model("Property");
		}
		
		private function makePropertyDirectories($id) {
			$target_dir   = dirname( __FILE__, 3) . "\\uploads\\";
			$property_dir = $target_dir . "property_" . $id;
			$exterior_dir = $property_dir . "\\exterior\\";
			$interior_dir = $property_dir . "\\interior\\";

			$err = mkdir($property_dir, 0777, true);
			$err = $err == false ? "error making property directory" : "";
					
			if (empty($err)) {
				$err = mkdir($exterior_dir, 0777, true);
				$err = $err == false ? "error making exterior directory" : "";

				if (empty($err)) {
					$err = mkdir($interior_dir, 0777, true);
					$err = $err == false ? "error making interior directory" : "";
				}
			}
			
			return $err;
		}
		
		private function moveExteriorFile($files, $id, $msg) {
			$target_dir   = dirname( __FILE__, 3) . "\\uploads\\property_{$id}\\exterior\\";
			$target_file  = $target_dir . basename($files["name"]);
			$extension    = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
			$filename     = "property_{$id}_exterior.$extension";
					
			$err = move_uploaded_file($files["tmp_name"], $target_dir.basename($filename));
			$err = $err == false ? $msg : $filename;
			
			return $err;
		}
		
		private function moveInteriorFile($name, $tmpname, $imgnum, $id, $msg) {
			$target_dir   = dirname( __FILE__, 3) . "\\uploads\\property_{$id}\\interior\\";
			$target_file  = $target_dir . basename($name);
			$extension    = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
			$imgnum       = intval($imgnum) < 10 ? "0" . strval($imgnum) : strval($imgnum);
			$filename    = "property_{$id}_interior_{$imgnum}.$extension";
			
			$err = move_uploaded_file($tmpname, $target_dir.basename($filename));
			$err = $err == false ? $msg : $filename;
			
			return $err;
		}
		
		private function renameInteriorFile($name, $imgnum, $id, $msg) {
			$target_dir   = dirname( __FILE__, 3) . "\\uploads\\property_{$id}\\interior\\";
			$target_file  = $target_dir . basename($name);
			$extension    = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
			$imgnum       = intval($imgnum) < 10 ? "0" . strval($imgnum) : strval($imgnum);
			$filename     = "property_{$id}_interior_{$imgnum}.$extension";

			$err = rename($target_dir.basename($name), $target_dir.basename($filename));
			$err = $err == false ? "error renaming interior file" : $filename;

			return $err;
		}
		
		private function deleteInteriorFile($id, $file) {
			$target_dir = dirname( __FILE__, 3) . "\\uploads\\property_{$id}\\interior\\";
			
			$err = unlink($target_dir.basename($file));
			$err = $err == false ? "error deleting interior file" : "";
			
			return $err;
		}
		
		private function checkDirectoryForImages($id) {
			$target_dir = dirname( __FILE__, 3) . "\\uploads\\property_{$id}\\interior\\";
			return preg_grep('~\.(jpeg|jpg)$~', scandir($target_dir));
		}
		
		private function sendLandlordEmail($name, $email, $phone, $date, $time, $property) {
			# email message
			$msg  = "<html><head><title>Schedule Showing</title></head><body>";
			$msg  = "<p>Hello, Property Manager.</p>";
			$msg .= "<p>$name has scheduled a showing of property $property for $date at $time. Contact information for this individual is as follows:</p>";
			$msg .= "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\"><tr><td>Email Address:&nbsp;</td><td>$email</td></tr><tr><td>Phone:&nbsp;</td><td>$phone</td></tr></table>";
			$msg .= "</body>";
			$msg .= "</html>";
			
			// return Utility::sendEmail("info@handhrentalproperties.com", "Schedule Showing", $msg);
			return Utility::sendEmail("wolfcrkfarm@hotmail.com", "Schedule Showing", $msg);
		}
		
		private function sendSchedulerEmail($name, $email, $date, $time, $property) {
			# email message
			$msg  = "<html><head><title>Schedule Showing</title></head><body>";
			$msg  = "<p>Hello, $name.</p>";
			$msg .= "<p>You have scheduled a showing of property $property for $date at $time.</p>";
			$msg .= "<p>Sincerely,</p>";
			$msg .= "<p>H&amp;H Rental Properties</p>";
			$msg .= "</body>";
			$msg .= "</html>";
			
			// return Utility::sendEmail($email, "Schedule Showing", $msg);
			return Utility::sendEmail("wolfcrkfarm@hotmail.com", "Schedule Showing", $msg);
		}
		
		public function index() {
			$properties = $this->propertyModel->getProperties();
			$pages      = Utility::getPages($properties, 6);
			$data       = ["properties" => $pages];
			$this->view("properties/index", $data);
		}
		
		public function dashboard() {
			if (!Utility::isAdmin()) {
				Utility::redirect("");
			}
			
			$properties = $this->propertyModel->getProperties();
			$pages      = Utility::getPages($properties, 10);			
			$data       = ["properties" => $pages];			
			$this->view("properties/dashboard", $data);
		}
		
		public function create() {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$post  = json_decode($_POST["data"], true);
				$post  = filter_var_array($post, FILTER_SANITIZE_STRING);
				$exterior = isset($_FILES["exteriorimage"]) ? $_FILES["exteriorimage"] : null;
				$interior = isset($_FILES["interiorimage"]) ? $_FILES["interiorimage"] : null;
				$post["property"]["exteriorimage"] = "";
				$post["property"]["interiorimage"] = "";
				$data = Validate::setProperties(array_keys($post["property"]), $post["property"]);
				$err  = "";
				$firstError = "";

				Validate::isNotEmpty($data->address, "Please enter address.");
				Validate::isNotEmpty($data->city, "Please enter city.");
				Validate::isNotEmpty($data->state, "Please select state.");
				Validate::isZip($data->zip, "Please enter valid zip.");
				Validate::isNotEmpty($data->rent, "Please enter monthly rent.");
				Validate::isNotEmpty($data->deposit, "Please enter deposit.");			
				Validate::isNotEmpty($data->status, "Please select status.");			
				Validate::isUrl($data->map, "Please enter valid URL.");
				Validate::isNotEmpty($data->description, "Please enter description.");
				Validate::isNotEmpty($data->sqft, "Please enter square feet.");
				Validate::isNotEmpty($data->garage, "Please select garage.");
				Validate::isNotEmpty($data->bedrooms, "Please select bedrooms.");
				Validate::isNotEmpty($data->bathrooms, "Please select bathrooms.");			
				Validate::isNotEmpty($data->lease, "Please select lease.");			
				Validate::isNotEmpty($data->elementaryschool, "Please enter elementary school.");			
				Validate::isNotEmpty($data->middleschool, "Please enter middle school.");			
				Validate::isNotEmpty($data->highschool, "Please enter high school.");

				if (empty($exterior)) {
					$data->exteriorimage->error = "Please select exterior image";
				}
				else {
					Validate::checkImageFile($data->exteriorimage, $exterior["name"], $exterior["tmp_name"], $exterior["size"]);
				}

				if (!empty($interior)) {
					for ($i=0; $i<count($interior["name"]); $i++) {
						Validate::checkImageFile($data->interiorimage, $interior["name"][$i], $interior["tmp_name"][$i], $interior["size"][$i]);
						$err = $data->interiorimage->error;

						if (!empty($err)) {
							break;
						}					
					}
				}

				$err = Validate::getErrors($data);
				$firstError = Validate::getFirstError($data);

				if (Validate::isValid($data)) {
					$firstError = "";
					$propertyId = $this->propertyModel->addProperty($data)->newRecordId;				
					$err = empty($propertyId) ? "error adding property" : "";

					if (empty($err)) {
						$err = $this->makePropertyDirectories($propertyId);
					}

					if (empty($err)) {
						$err = $this->moveExteriorFile($exterior, $propertyId, "error adding exterior file");
					}

					if (strpos($err, "error") === false) {
						$err = $this->propertyModel->updatePropertyExterior($propertyId, $err);
						$err = $err == false ? "error updating property" : "";
					}

					if (empty($err) && !empty($interior)) {
						for ($i=0; $i<count($interior["name"]); $i++) {
							$imgnum = $i+1;
							$err = $this->moveInteriorFile($interior["name"][$i], $interior["tmp_name"][$i], $imgnum, $propertyId, "error adding interior file");

							if (strpos($err, "error") === false) {
								$err = $this->propertyModel->addPropertyInterior($propertyId, $err, $imgnum);
								$err = $err == false ? "error adding property interior" : "";

								if (!empty($err)) {
									break;
								}
							}
							else {
								break;
							}
						}	
					}
				}

				if (empty($err)) {
					echo json_encode(["succeeded" => true, "redirect" => "/properties/dashboard"]);
				}
				else {
					echo json_encode(["succeeded" => false, "errors" => $err, "firstError" => $firstError]);
				}
			}
			else {
				if (!Utility::isAdmin()) {
					Utility::redirect("");
				}
			}
		}		
		
		public function new() {			
			if (!Utility::isAdmin()) {
				Utility::redirect("");
			}
			
			$states = Utility::getStates();
			
			$data = new stdClass();
			$data->id = "";
			$data->address = "";
			$data->city = "";
			$data->state = "";
			$data->zip = "";
			$data->formattedRent = "";
			$data->formattedDeposit = "";
			$data->status = "";
			$data->map = "";
			$data->description = "";
			$data->sqft = "";
			$data->garage = "";
			$data->bedrooms = "";
			$data->formattedBathrooms = "";
			$data->lease = "";
			$data->elementaryschool = "";
			$data->middleschool = "";
			$data->highschool = "";
			$data->exteriorimage = "";
			$data->interiorimages = [];
			$data->states = $states;
			
			$this->view("properties/new", $data);
		}
		
		public function show($id) {
			$data = $this->propertyModel->getPropertyById($id);
			$data->interiorimages = empty($data->interiorimages) ? [] : explode(",", $data->interiorimages);
			
			$this->view("properties/show", $data);
		}
		
		public function edit($id) {			
			if (!Utility::isAdmin()) {
				Utility::redirect("");
			}
			
			$states = Utility::getStates();
			$data = $this->propertyModel->getPropertyById($id);
			$data->interiorimages = empty($data->interiorimages) ? [] : explode(",", $data->interiorimages);
			$data->states = $states;

			$this->view("properties/edit", $data);
		}
		
		public function schedule($id) {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$post = json_decode($_POST["data"], true);
				$post = filter_var_array($post, FILTER_SANITIZE_STRING);
				$data = Validate::setProperties(array_keys($post["schedule"]), $post["schedule"]);
				$err  = "";
				$firstError = "";

				Validate::isNotEmpty($data->name, "Please enter name.");
				Validate::isPhone($data->phone, "Please enter valid phone.");
				Validate::isEmail($data->email, "Please enter valid email address.");			
				Validate::isFutureDate($data->{"date"}, "Please enter future date.");
				Validate::isNotEmpty($data->{"time"}, "Please select time.");			

				if (Validate::isValid($data)) {
					$err = $this->sendLandlordEmail(
						$data->name->value, 
						$data->email->value, 
						$data->phone->value, 
						$data->{"date"}->value, 
						$data->{"time"}->value, 
						$data->hdnProperty->value
					);

					$err = $err != true ? "error sending landlord email" : "";

					if (empty($err)) {
						$err = $this->sendSchedulerEmail(
							$data->name->value, 
							$data->email->value, 
							$data->{"date"}->value, 
							$data->{"time"}->value, 
							$data->hdnProperty->value						
						);

						$err = $err != true ? "error sending scheduler email" : "";
					}
				}
				else {
					$err = Validate::getErrors($data);
					$firstError = Validate::getFirstError($data);
				}

				if (empty($err)) {
					echo json_encode(["succeeded" => true, "redirect" => ""]);
				}
				else {
					echo json_encode(["succeeded" => false, "errors" => $err, "firstError" => $firstError]);
				}
			}
			else {
				if (!Utility::isAdmin()) {
					Utility::redirect("");
				}
			}
		}
		
		public function complete($id) {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$post       = json_decode($_POST["data"], true);
				$post       = filter_var_array($post, FILTER_SANITIZE_STRING);
				$imgcount   = intval($post["property"]["hdnimagecount"]);
				$delete     = isset($post["property"]["interiordelete"]) ? explode(",", $post["property"]["interiordelete"]) : null;
				$exterior   = isset($_FILES["exteriorimage"]) ? $_FILES["exteriorimage"] : null;
				$additional = isset($_FILES["additionalimage"]) ? $_FILES["additionalimage"] : null;
				$interior   = [];
				$err = "";

				$post["property"]["exteriorimage"] = "";
				$post["property"]["additionalimage"] = "";
				$post["property"]["propertyId"] = $id;

				for ($i=1; $i<=$imgcount; $i++) {				
					if (isset($_FILES["interiorimage$i"])) {					
						$post["property"]["interiorimage$i"] = "";
						$interior[] = [
							"file"   => $_FILES["interiorimage$i"],
							"number" => $i
						];
					}
				}			

				$data = Validate::setProperties(array_keys($post["property"]), $post["property"]);

				Validate::isNotEmpty($data->address, "Please enter address.");
				Validate::isNotEmpty($data->city, "Please enter city.");
				Validate::isNotEmpty($data->state, "Please select state.");
				Validate::isZip($data->zip, "Please enter valid zip.");
				Validate::isNotEmpty($data->rent, "Please enter monthly rent.");
				Validate::isNotEmpty($data->deposit, "Please enter deposit.");			
				Validate::isNotEmpty($data->status, "Please select status.");			
				Validate::isUrl($data->map, "Please enter valid URL.");
				Validate::isNotEmpty($data->description, "Please enter description.");
				Validate::isNotEmpty($data->sqft, "Please enter square feet.");
				Validate::isNotEmpty($data->garage, "Please select garage.");
				Validate::isNotEmpty($data->bedrooms, "Please select bedrooms.");
				Validate::isNotEmpty($data->bathrooms, "Please select bathrooms.");			
				Validate::isNotEmpty($data->lease, "Please select lease.");			
				Validate::isNotEmpty($data->elementaryschool, "Please enter elementary school.");			
				Validate::isNotEmpty($data->middleschool, "Please enter middle school.");			
				Validate::isNotEmpty($data->highschool, "Please enter high school.");

				if (!empty($exterior)) {
					Validate::checkImageFile($data->exteriorimage, $exterior["name"], $exterior["tmp_name"], $exterior["size"]);
				}

				foreach($interior as $arr) {
					Validate::checkImageFile($data->{"interiorimage{$arr['number']}"}, $arr["file"]["name"], $arr["file"]["tmp_name"], $arr["file"]["size"]);
				}

				if (!empty($additional)) {
					for ($i=0; $i<count($additional["name"]); $i++) {
						Validate::checkImageFile($data->additionalimage, $additional["name"][$i], $additional["tmp_name"][$i], $additional["size"][$i]);
						$err = $data->additionalimage->error;

						if (!empty($err)) {
							break;
						}					
					}
				}

				$err = Validate::getErrors($data);
				$firstError = Validate::getFirstError($data);

				if (Validate::isValid($data)) {
					$err = "";
					$firstError = "";
					
					$err = $this->propertyModel->updateProperty($data);
					$err = $err == false ? "error updating property" : "";

					if (empty($err) && !empty($exterior)) {
						$err = $this->moveExteriorFile($exterior, $id, "error replacing exterior file");
					}

					if (strpos($err, "error") === false) {
						foreach($interior as $arr) {		
							$err = $this->moveInteriorFile($arr["file"]["name"], $arr["file"]["tmp_name"], $arr["number"], $id, "error replacing interior file");

							if (strpos($err, "error") !== false) {
								break;
							}
						}
					}

					if (strpos($err, "error") === false) {
						if (!empty($delete)) {
							foreach($delete as $item) {
								$err = $this->deleteInteriorFile($id, $item);

								if (!empty($err)) {
									break;
								}
							}
						}
					}

					if (empty($err) && !empty($additional)) {
						for ($i=0; $i<count($additional["name"]); $i++) {
							$imgcount = $imgcount + 1 + $i;
							$err = $this->moveInteriorFile($additional["name"][$i], $additional["tmp_name"][$i], $imgcount, $id, "error adding additional file");

							if (strpos($err, "error") !== false) {
								break;
							}
						}
					}

					if (strpos($err, "error") === false) {
						$images = $this->checkDirectoryForImages($id);
						
						if (count($images) == 0) {
							$this->propertyModel->deletePropertyInterior($id);
						}

						$count = 1;
						foreach($images as $image) {
							$err = $this->renameInteriorFile($image, $count, $id, "error renaming interior file");

							if (strpos($err, "error") === false) {
								$err = $this->propertyModel->addPropertyInterior($id, $err, $count);
								$err = $err == false ? "error adding property interior" : "";

								if (!empty($err)) {
									break;
								}
							}
							else {
								break;
							}

							$count++;						
						}					
					}
				}

				if (empty($err)) {
					echo json_encode(["succeeded" => true, "redirect" => "/properties/dashboard"]);
				}
				else {
					echo json_encode(["succeeded" => false, "errors" => $err, "firstError" => $firstError]);
				}
			}
			else {
				if (!Utility::isAdmin()) {
					Utility::redirect("");
				}
			}
		}
		
		public function sort($id) {			
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$post       = json_decode($_POST["data"], true);
				$post       = filter_var_array($post, FILTER_SANITIZE_STRING);
				$imagecount = intval($post["property"]["hdnimagecount"]);
				$err        = "";
				$firstError = "";		
				$data       = [];
				$sorts      = [];
				$duplicates = [];
				
				for ($i=1; $i<=$imagecount; $i++) {
					$arr  = explode(";;;", $post["property"]["sortOrder$i"]);
					
					$data[] = [
						"imageId"   => $arr[0],
						"sortOrder" => $arr[1],
						"element"   => "sortOrder$i"
					];
					
					if (in_array($arr[1], $sorts)) {
						$duplicates[] = $data[count($data)-1];
					}
					else {
						$sorts[] = $arr[1];
					}
				}
				
				if (count($duplicates) > 0) {
					$data = Validate::setProperties(array_keys($post["property"]), $post["property"]);
					
					foreach($duplicates as $dup) {
						Validate::toggleError($data->{$dup["element"]}, true, "Please select unique order.");
					}
					
					$err = Validate::getErrors($data);
					$firstError = Validate::getFirstError($data);
				}

				if (empty($err)) {
					foreach($data as $item) {
						$err = $this->propertyModel->updateInteriorImagesSort($item["imageId"], $item["sortOrder"]);
						$err = $err == false ? "error updating interior image sort" : "";
						
						if (!empty($err)) {
							break;
						}
					}
				}
				
				if (empty($err)) {
					echo json_encode(["succeeded" => true, "redirect" => "/properties/dashboard"]);
				}
				else {
					echo json_encode(["succeeded" => false, "errors" => $err, "firstError" => $firstError]);
				}
			}
			else {
				if (!Utility::isAdmin()) {
					Utility::redirect("");
				}
				
				$images = $this->propertyModel->getInteriorImagesByPropertyId($id);				
			
				$data = [
					"propertyId" => $id,
					"images"     => $images
				];
			
				$this->view("properties/sort", $data);
			}
		}
		
		public function delete($id) {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$err = $this->propertyModel->deleteProperty($id);
				$err = $err == false ? "error deleting property" : "";
				$firstError = "";

				if (empty($err)) {
					Utility::redirect("properties/dashboard");
				}
				else {
					echo json_encode(["succeeded" => false, "errors" => $err, "firstError" => $firstError]);
				}
			}
			else {
				if (!Utility::isAdmin()) {
					Utility::redirect("");
				}
				
				Utility::redirect("properties/dashboard");
			}
		}
	}
?>