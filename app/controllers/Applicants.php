<?php
	class Applicants extends Controller {
		private $applicantModel;
		
		public function __construct() {
			$this->applicantModel = $this->model("Applicant");
		}
		
		private function splitDelimitedFields($obj, $str, $prefix, $suffix, $numAtEnd=false) {
			$arr = explode(";;;", $obj->{$str});
				
			for ($i=0; $i<count($arr); $i++) {
				$num  = $i+1;
				$prop = $numAtEnd ? "{$prefix}_{$suffix}_{$num}" : "{$prefix}_{$num}_{$suffix}";
				$obj->{"$prop"} = $arr[$i];
			}
			
			unset($obj->{$str});
		}
		
		private function getPdf($applicant) {
			$this->splitDelimitedFields($applicant, "dependent_names", "dependent", "name", true);
			$this->splitDelimitedFields($applicant, "dependent_dobs", "dependent", "dob", true);
			$this->splitDelimitedFields($applicant, "reference_names", "references", "name", true);
			$this->splitDelimitedFields($applicant, "reference_phones", "references", "phone", true);
			$this->splitDelimitedFields($applicant, "reference_relationships", "references", "relationship", true
			);
			$this->splitDelimitedFields($applicant, "reference_years", "references", "years_known", true);
			$this->splitDelimitedFields($applicant, "reference_addresses", "references", "address", true);
			$this->splitDelimitedFields($applicant, "vehicle_makes", "vehicle", "make", true);
			$this->splitDelimitedFields($applicant, "vehicle_models", "vehicle", "model", true);
			$this->splitDelimitedFields($applicant, "vehicle_colors", "vehicle", "color", true);
			$this->splitDelimitedFields($applicant, "vehicle_years", "vehicle", "year", true);
			$this->splitDelimitedFields($applicant, "vehicle_lpNumbers", "vehicle", "license_plate_number", true);
			$this->splitDelimitedFields($applicant, "vehicle_lpStates", "vehicle", "license_plate_state", true);
			
			$path = realpath(".")."\\pdf";
			$file = $path."\\application.pdf";
			
			$pdf = new FPDM($file);
			$pdf->Load(get_object_vars($applicant), true);
			$pdf->Merge();
			
			return $pdf;
		}
		
		private function sendLandlordEmail($app) {			
			# email message
			$msg  = "<html><head><title>Rental Application</title></head><body>";
			$msg  = "<p>Hello, Property Manager.</p>";
			$msg .= "<p>$app->applicant_first_name $app->applicant_last_name submitted a rental application for property $app->property_location. To view the details of the application, login to the <a href=\"http://www.local-hh-rental-properties.com/login\">H&amp;H Rental Properties</a> website and then select 'Applicants' from the 'ADMIN' menu. From the list of applicants, click on the 'View Application' icon (eye) in the 'Action' column for $app->applicant_first_name $app->applicant_last_name.</p>";
			$msg .= "</body>";
			$msg .= "</html>";
			
			// return Utility::sendEmail("info@handhrentalproperties.com", "Rental Application", $msg);
			return Utility::sendEmail("wolfcrkfarm@hotmail.com", "Rental Application", $msg);
		}
		
		private function sendApplicantEmail($app, $doc) {			
			# email message
			$msg  = "<html><head><title>Rental Application</title></head><body>";
			$msg  = "<p>Hello, $app->applicant_first_name.</p>";
			$msg .= "<p>Thank you for submitting your rental application for property $app->property_location. Please allow 24&#8209;72 business hours for review of your application and reference checks. It would be helpful to advise your references that they will be receiving a phone call. Also, expect an email from Rent Prep within 24&#8209;72 hours</p>";
			$msg .= "<p>Sincerely,</p>";
			$msg .= "<p>H&amp;H Rental Properties</p>";
			$msg .= "</body>";
			$msg .= "</html>";
			
			// return Utility::sendEmail($app->applicant_email, "Rental Application", $msg, $doc);
			return Utility::sendEmail("wolfcrkfarm@hotmail.com", "Rental Application", $msg, $doc);
		}
		
		public function index() {
			if (!Utility::isAdmin()) {
				Utility::redirect("");
			}
			
			$applicants = $this->applicantModel->getApplicants();
			$pages      = Utility::getPages($applicants, 10);

			$data = [
				"applicants" => $pages
			];
			
			$this->view("applicants/index", $data);
		}
		
		public function print($params) {
			if (!Utility::isAdmin()) {
				Utility::redirect("");
			}
			
			$arr = explode(",", $params);
			$applicant = $this->applicantModel->getPrint($arr);
			$data = $this->getPdf($applicant)->Output("D", "application.pdf");
			
			$this->view("applicants/print", $data);
		}
		
		public function email($params) {
			if (!Utility::isAdmin()) {
				Utility::redirect("");
			}
			
			$arr = explode(",", $params);
			$app = $this->applicantModel->getPrint($arr);
			$doc = $this->getPdf($app)->Output("S");
			$err = $this->sendApplicantEmail($app, $doc);
			
			$err = $err != true ? "error sending applicant email" : "";
			
			if (empty($err)) {
				date_default_timezone_set("America/Chicago");
				$timestamp = date('Y-m-d H:i:s');

				$err = $this->applicantModel->updateDateEmailed([$arr[1], $arr[2], $timestamp]);
				$err = $err == false ? "error updating applicant date emailed" : "";
			}
			
			if (empty($err)) {
				echo json_encode(["succeeded" => true, "redirect" => "applicants"]);
			}
			else {
				echo json_encode(["succeeded" => false, "errors" => $err]);
			}				
		}
		
		public function export() {
			if (!Utility::isAdmin()) {
				Utility::redirect("");
			}
			
			$applicants = $this->applicantModel->getExport();
			
			foreach($applicants as $applicant) {
				$this->splitDelimitedFields($applicant, "Dependent_Names", "Dependent", "Name");
				$this->splitDelimitedFields($applicant, "Dependent_DOBs", "Dependent", "Date_of_Birth");
				$this->splitDelimitedFields($applicant, "Reference_Names", "Reference", "Name");
				$this->splitDelimitedFields($applicant, "Reference_Phones", "Reference", "Phone");
				$this->splitDelimitedFields($applicant, "Reference_Relationships", "Reference", "Relationship");
				$this->splitDelimitedFields($applicant, "Reference_Years", "Reference", "Years_Known");
				$this->splitDelimitedFields($applicant, "Reference_Addresses", "Reference", "Address");
				$this->splitDelimitedFields($applicant, "Vehicle_Makes", "Vehicle", "Make");
				$this->splitDelimitedFields($applicant, "Vehicle_Models", "Vehicle", "Model");
				$this->splitDelimitedFields($applicant, "Vehicle_Colors", "Vehicle", "Color");
				$this->splitDelimitedFields($applicant, "Vehicle_Years", "Vehicle", "Year");
				$this->splitDelimitedFields($applicant, "Vehicle_LPNumbers", "Vehicle", "License_Plate_Number");
				$this->splitDelimitedFields($applicant, "Vehicle_LPStates", "Vehicle", "License_Plate_State");			
			}			
			
			$data = [
				"applicants" => $applicants
			];
			
			$this->view("applicants/export", $data);
		}
		
		public function create() {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				# process form
				$post       = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				$formId     = $post["hdnFormId"];
				$coapp      = $post["hdnCoapp"];
				$data       = Validate::setProperties(array_keys($post), $post);
				$firstError = "";

				if ($formId == "infoApp") {
					Validate::isNotEmpty($data->propertyId, "Please select property.");
					Validate::isNotEmpty($data->firstName, "Please enter first name.");
					Validate::isNotEmpty($data->lastName, "Please enter last name.");
					Validate::isEmail($data->email, "Please enter valid email address.");
					Validate::isPastDate($data->dob, "Please enter past date.");
					Validate::isSsn($data->ssn, "Please enter valid social security number.");
					Validate::isNotEmpty($data->dln, "Please enter driver's license number.");
					Validate::isNotEmpty($data->dlnState, "please select state of issue.");

					if (empty($data->homePhone->value) && 
							empty($data->cellPhone->value) && 
							empty($data->workPhone->value)) {
						Validate::toggleError($data->phones, true, "Please enter home, cell, or work phone.");
					} 

					if (!empty($data->homePhone->value)) {
						Validate::isPhone($data->homePhone, "Please enter valid home phone.");
					}

					if (!empty($data->cellPhone->value)) {
						Validate::isPhone($data->cellPhone, "Please enter valid cell phone.");
					}

					if (!empty($data->workPhone->value)) {
						Validate::isPhone($data->workPhone, "Please enter valid work phone.");
					}

					$firstError = Validate::getFirstError($data);
					$firstError = $firstError == "phones" ? "homePhone" : $firstError;
				}

				if ($formId == "empCurrApp") {
					Validate::isNotEmpty($data->status, "Please select a status.");
					
					if (strpos($data->status->value, "full time") !== false || 
							strpos($data->status->value, "part time") !== false) {
								Validate::isNotEmpty($data->employer, "Please enter employer.");
								Validate::isNotEmpty($data->occupation, "Please enter occupation.");
								Validate::isNotEmpty($data->address, "Please enter address.");
								Validate::isNotEmpty($data->city, "Please enter city.");
								Validate::isNotEmpty($data->state, "Please select state.");
								Validate::isZip($data->zip, "Please enter valid zip.");
								Validate::isNotEmpty($data->supervisorName, "Please enter supervisor name.");
								Validate::isPhone($data->supervisorPhone, "Please enter valid supervisor phone.");
								Validate::isNotEmpty($data->yearsEmployed, "Please enter years employed.");
								Validate::isNotEmpty($data->monthlyIncome, "Please enter monthly income.");
					}
					
					$firstError = Validate::getFirstError($data);
					$firstError = $firstError == "status" ? "empCurrApp-fullTime" : $firstError;
				}

				if ($formId == "empPrevApp") {
					Validate::isNotEmpty($data->employment, "Please select a response.");
					
					if ($data->employment->value == "yes") {
						Validate::isNotEmpty($data->status, "Please select a status.");
						Validate::isNotEmpty($data->employer, "Please enter employer.");
						Validate::isNotEmpty($data->occupation, "Please enter occupation.");
						Validate::isNotEmpty($data->address, "Please enter address.");
						Validate::isNotEmpty($data->city, "Please enter city.");
						Validate::isNotEmpty($data->state, "Please select state.");
						Validate::isZip($data->zip, "Please enter valid zip.");
						Validate::isNotEmpty($data->supervisorName, "Please enter supervisor name.");
						Validate::isPhone($data->supervisorPhone, "Please enter valid supervisor phone.");
						Validate::isNotEmpty($data->yearsEmployed, "Please enter years employed.");
						Validate::isNotEmpty($data->monthlyIncome, "Please enter monthly income.");
					}

					$firstError = Validate::getFirstError($data);
					$firstError = $firstError == "employment" ? "empPrevApp-employment-yes" : $firstError;
					$firstError = $firstError == "status" ? "empPrevApp-fullTime" : $firstError;
				}

				if ($formId == "creditApp") {
					Validate::isNotEmpty($data->bankrupt, "Please select a response.");
					Validate::isNotEmpty($data->evicted, "Please select a response.");
					Validate::isNotEmpty($data->latePayments, "Please select a response.");
					Validate::isNotEmpty($data->convicted, "Please select a response.");
					
					if ($data->bankrupt->value == "yes" || 
							$data->evicted->value == "yes" || 
							$data->latePayments->value == "yes" || 
							$data->convicted->value == "yes") {
								Validate::isNotEmpty($data->explanation, "Please enter explanation.");
					}

					$firstError = Validate::getFirstError($data);
					$firstError = $firstError == "bankrupt" ? "creditApp-bankrupt-yes" : $firstError;
					$firstError = $firstError == "evicted" ? "creditApp-evicted-yes" : $firstError;
					$firstError = $firstError == "latePayments" ? "creditApp-latePayments-yes" : $firstError;
					$firstError = $firstError == "convicted" ? "creditApp-convicted-yes" : $firstError;
				}

				if ($formId == "infoCoapp") {
					Validate::isNotEmpty($data->coapp, "Please select a response.");
					
					if ($data->coapp->value == "yes") {
						$coapp = "yes";					
						Validate::isNotEmpty($data->firstName, "Please enter first name.");
						Validate::isNotEmpty($data->lastName, "Please enter last name.");
						Validate::isEmail($data->email, "Please enter valid email address.");
						Validate::isPastDate($data->dob, "Please enter past date.");
						Validate::isSsn($data->ssn, "Please enter valid social security number.");
						Validate::isNotEmpty($data->dln, "Please enter driver's license number.");
						Validate::isNotEmpty($data->dlnState, "please select state of issue.");

						if (empty($data->homePhone->value) && 
								empty($data->cellPhone->value) && 
								empty($data->workPhone->value)) {
							Validate::toggleError($data->phones, true, "Please enter home, cell, or work phone.");
						} 

						if (!empty($data->homePhone->value)) {
							Validate::isPhone($data->homePhone, "Please enter valid home phone.");
						}

						if (!empty($data->cellPhone->value)) {
							Validate::isPhone($data->cellPhone, "Please enter valid cell phone.");
						}

						if (!empty($data->workPhone->value)) {
							Validate::isPhone($data->workPhone, "Please enter valid work phone.");
						}					
					}

					$firstError = Validate::getFirstError($data);
					$firstError = $firstError == "coapp" ? "infoCoapp-coapp-yes" : $firstError;
					$firstError = $firstError == "phones" ? "homePhone" : $firstError;
				}

				if ($formId == "empCurrCoapp") {
					Validate::isNotEmpty($data->status, "Please select a status.");
					
					if (strpos($data->status->value, "full time") !== false || 
							strpos($data->status->value, "part time") !== false) {
								Validate::isNotEmpty($data->employer, "Please enter employer.");
								Validate::isNotEmpty($data->occupation, "Please enter occupation.");
								Validate::isNotEmpty($data->address, "Please enter address.");
								Validate::isNotEmpty($data->city, "Please enter city.");
								Validate::isNotEmpty($data->state, "Please select state.");
								Validate::isZip($data->zip, "Please enter valid zip.");
								Validate::isNotEmpty($data->supervisorName, "Please enter supervisor name.");
								Validate::isPhone($data->supervisorPhone, "Please enter valid supervisor phone.");
								Validate::isNotEmpty($data->yearsEmployed, "Please enter years employed.");
								Validate::isNotEmpty($data->monthlyIncome, "Please enter monthly income.");
					}
					
					$firstError = Validate::getFirstError($data);
					$firstError = $firstError == "status" ? "empCurrCoapp-fullTime" : $firstError;
				}

				if ($formId == "empPrevCoapp") {
					Validate::isNotEmpty($data->employment, "Please select a response.");
					
					if ($data->employment->value == "yes") {
						Validate::isNotEmpty($data->status, "Please select a status.");
						Validate::isNotEmpty($data->employer, "Please enter employer.");
						Validate::isNotEmpty($data->occupation, "Please enter occupation.");
						Validate::isNotEmpty($data->address, "Please enter address.");
						Validate::isNotEmpty($data->city, "Please enter city.");
						Validate::isNotEmpty($data->state, "Please select state.");
						Validate::isZip($data->zip, "Please enter valid zip.");
						Validate::isNotEmpty($data->supervisorName, "Please enter supervisor name.");
						Validate::isPhone($data->supervisorPhone, "Please enter valid supervisor phone.");
						Validate::isNotEmpty($data->yearsEmployed, "Please enter years employed.");
						Validate::isNotEmpty($data->monthlyIncome, "Please enter monthly income.");
					}

					$firstError = Validate::getFirstError($data);
					$firstError = $firstError == "employment" ? "empPrevCoapp-employment-yes" : $firstError;
					$firstError = $firstError == "status" ? "empPrevCoapp-fullTime" : $firstError;
				}

				if ($formId == "creditCoapp") {
					Validate::isNotEmpty($data->bankrupt, "Please select a response.");
					Validate::isNotEmpty($data->evicted, "Please select a response.");
					Validate::isNotEmpty($data->latePayments, "Please select a response.");
					Validate::isNotEmpty($data->convicted, "Please select a response.");

					if ($data->bankrupt->value == "yes" || 
							$data->evicted->value == "yes" || 
							$data->latePayments->value == "yes" || 
							$data->convicted->value == "yes") {
								Validate::isNotEmpty($data->explanation, "Please enter explanation.");
					}

					$firstError = Validate::getFirstError($data);
					$firstError = $firstError == "bankrupt" ? "creditCoapp-bankrupt-yes" : $firstError;
					$firstError = $firstError == "evicted" ? "creditCoapp-evicted-yes" : $firstError;
					$firstError = $firstError == "latePayments" ? "creditCoapp-latePayments-yes" : $firstError;
					$firstError = $firstError == "convicted" ? "creditCoapp-convicted-yes" : $firstError;
				}

				if ($formId == "dependents") {
					Validate::isNotEmpty($data->numDependents, "Please select number of dependents.");
					
					if (intval($data->numDependents->value) > 0) {
						for($num = 1; $num <= intval($data->numDependents->value); $num++) {
							Validate::isNotEmpty($data->{"name$num"}, "Please enter name.");
							Validate::isPastDate($data->{"dob$num"}, "Please enter past date.");
						}
					}
				}

				if ($formId == "currRes") {
					Validate::isNotEmpty($data->address, "Please enter address.");
					Validate::isNotEmpty($data->city, "Please enter city.");
					Validate::isNotEmpty($data->state, "Please select state.");
					Validate::isZip($data->zip, "Please enter valid zip.");
					Validate::isNotEmpty($data->payment, "Please enter monthly payment.");
					Validate::isNotEmpty($data->rentOwn, "Please select a response.");
					Validate::isNotEmpty($data->landlordName, "Please enter landlord/mortgagee name.");
					Validate::isPhone($data->landlordPhone, "Please enter valid landlord/mortgagee phone.");
					Validate::isNotEmpty($data->leavingReason, "Please enter reason for leaving.");
					
					$firstError = Validate::getFirstError($data);
					$firstError = $firstError == "rentOwn" ? "currRes-rentOwn-rent" : $firstError;
				}

				if ($formId == "prevRes") {
					Validate::isNotEmpty($data->residence, "Please select a response.");
					
					if ($data->residence->value == "yes") {
						Validate::isNotEmpty($data->address, "Please enter address.");
						Validate::isNotEmpty($data->city, "Please enter city.");
						Validate::isNotEmpty($data->state, "Please select state.");
						Validate::isZip($data->zip, "Please enter valid zip.");
						Validate::isNotEmpty($data->payment, "Please enter monthly payment.");
						Validate::isNotEmpty($data->rentOwn, "Please select a response.");
						Validate::isNotEmpty($data->landlordName, "Please enter landlord/mortgagee name.");
						Validate::isPhone($data->landlordPhone, "Please enter valid landlord/mortgagee phone.");
						Validate::isNotEmpty($data->leavingReason, "Please enter reason for leaving.");					
					}
					
					$firstError = Validate::getFirstError($data);
					$firstError = $firstError == "residence" ? "prevRes-residence-yes" : $firstError;
					$firstError = $firstError == "rentOwn" ? "prevRes-rentOwn-rent" : $firstError;
				}

				if ($formId == "references") {
					foreach([1, 2, 3] as $num) {
						Validate::isNotEmpty($data->{"name$num"}, "Please enter name.");
						Validate::isPhone($data->{"phone$num"}, "Please enter valid phone.");
						Validate::isNotEmpty($data->{"relationship$num"}, "Please enter relationship.");
						Validate::isNotEmpty($data->{"yearsKnown$num"}, "Please enter years known.");
						Validate::isNotEmpty($data->{"address$num"}, "Please enter address.");
					}
				}				

				if ($formId == "emergency") {
					Validate::isNotEmpty($data->name, "Please enter name.");
					Validate::isPhone($data->phone, "Please enter valid phone.");
					Validate::isNotEmpty($data->relationship, "Please enter relationship.");
					Validate::isNotEmpty($data->address, "Please enter address.");
				}

				if ($formId == "vehicles") {
					Validate::isNotEmpty($data->numVehicles, "Please select number of vehicles.");
					
					if (is_numeric($data->numVehicles->value)) {
						for($num = 1; $num <= intval($data->numVehicles->value); $num++) {
							Validate::isNotEmpty($data->{"make$num"}, "Please enter make.");
							Validate::isNotEmpty($data->{"model$num"}, "Please enter model.");
							Validate::isNotEmpty($data->{"color$num"}, "Please enter color.");
							Validate::isYear($data->{"year$num"}, "Please enter valid year.");
							Validate::isNotEmpty($data->{"licensePlateNumber$num"}, "Please enter license plate number.");
							Validate::isNotEmpty($data->{"licensePlateState$num"}, "Please select state.");
						}
					}
				}

				if ($formId == "additional") {
					Validate::isNotEmpty($data->terms, "Please certify understanding of terms.");
					Validate::isNotEmpty($data->signatureApp, "Please enter applicant signature.");

					if ($coapp == "yes") {
						Validate::isNotEmpty($data->signatureCoapp, "Please enter co-applicant signature.");
					}

					$firstError = Validate::getFirstError($data);
					$firstError = $firstError == "terms" ? "additional-terms" : $firstError;
				}

				if (Validate::isValid($data)) {
					echo json_encode(["succeeded" => true, "coapp" => $coapp]);
				}
				else {
					$firstError = empty($firstError) ? Validate::getFirstError($data) : $firstError;
					echo json_encode(["succeeded" => false, "errors" => Validate::getErrors($data), "firstError" => $firstError, "coapp" => $coapp]);
				}
			}
		}	

		public function complete() {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				# process form
				$post = json_decode($_POST["data"], true);
				$post = filter_var_array($post, FILTER_SANITIZE_STRING);
				$data = [];
				$applicantId = null;
				$coapplicantId = null;
				$propertyId = null;
				$form = null;
				$err  = "";
				$firstError = "";
				date_default_timezone_set("America/Chicago");
				$timestamp = date('Y-m-d H:i:s');

				if (array_key_exists("infoApp", $post)) {
					$form = $post["infoApp"];	
					$propertyId = $form["propertyId"];						
					$data = [
						"propertyId"    => $propertyId,
						"type"          => "applicant",
						"firstName"     => $form["firstName"],
						"middleName"    => array_key_exists("middleName", $form) ? $form["middleName"] : null,
						"lastName"      => $form["lastName"],
						"homePhone"     => array_key_exists("homePhone", $form) ? $form["homePhone"] : null,
						"cellPhone"     => array_key_exists("cellPhone", $form) ? $form["cellPhone"] : null,
						"workPhone"     => array_key_exists("workPhone", $form) ? $form["workPhone"] : null,
						"dob"           => $form["dob"],
						"ssn"           => $form["ssn"],
						"email"         => $form["email"],
						"dln"           => $form["dln"],
						"dlnState"      => $form["dlnState"]			
					];

					$applicantId = $this->applicantModel->addApplicant($data)->newRecordId;				
					$err = empty($applicantId) ? "error adding applicant" : "";
				}

				if (empty($err) && !empty($applicantId) && array_key_exists("empCurrApp", $post)) {
					$form = $post["empCurrApp"];
					$data = [
							"applicantId"     => $applicantId,
							"type"            => "current",
							"status"          => $form["status"],
							"employer"        => null,
							"occupation"      => null,
							"address"         => null,
							"city"            => null,
							"state"           => null,
							"zip"             => null,
							"supervisorName"  => null,
							"supervisorPhone" => null,
							"yearsEmployed"   => null,
							"monthlyIncome"   => null					
						];
					
					if (strpos($form["status"], "full time") !== false || 
							strpos($form["status"], "part time") !== false) {
							$data["employer"]        = $form["employer"];
							$data["occupation"]      = $form["occupation"];
							$data["address"]         = $form["address"];
							$data["city"]            = $form["city"];
							$data["state"]           = $form["state"];
							$data["zip"]             = $form["zip"];
							$data["supervisorName"]  = $form["supervisorName"];
							$data["supervisorPhone"] = $form["supervisorPhone"];
							$data["yearsEmployed"]   = $form["yearsEmployed"];
							$data["monthlyIncome"]   = str_replace(",", "", $form["monthlyIncome"]);
					}				

					$err = $this->applicantModel->addEmployment($data);
					$err = $err == false ? "error adding applicant current employment" : "";
				}

				if (empty($err) && !empty($applicantId) && array_key_exists("empPrevApp", $post)) {
					$form = $post["empPrevApp"];
					
					if ($form["employment"] == "yes") {
						$data = [
							"applicantId"     => $applicantId,
							"type"            => "previous",
							"status"          => $form["status"],
							"employer"        => $form["employer"],
							"occupation"      => $form["occupation"],
							"address"         => $form["address"],
							"city"            => $form["city"],
							"state"           => $form["state"],
							"zip"             => $form["zip"],
							"supervisorName"  => $form["supervisorName"],
							"supervisorPhone" => $form["supervisorPhone"],
							"yearsEmployed"   => $form["yearsEmployed"],
							"monthlyIncome"   => str_replace(",", "", $form["monthlyIncome"])					
						];

						$err = $this->applicantModel->addEmployment($data);
						$err = $err == false ? "error adding applicant previous employment" : "";
					}
				}

				if (empty($err) && !empty($applicantId) && array_key_exists("creditApp", $post)) {
					$form = $post["creditApp"];
					$data = [
						"applicantId"  => $applicantId,
						"bankrupt"     => $form["bankrupt"] == "yes" ? "1" : "0",
						"evicted"      => $form["evicted"] == "yes" ? "1" : "0",
						"latePayments" => $form["latePayments"] == "yes" ? "1" : "0",
						"convicted"    => $form["convicted"] == "yes" ? "1" : "0",
						"explanation"  => array_key_exists("explanation", $form) ? $form["explanation"] : null
					];

					$err = $this->applicantModel->addCredit($data);
					$err = $err == false ? "error adding applicant credit history" : "";
				}

				if (empty($err) && !empty($applicantId) && array_key_exists("infoCoapp", $post)) {
					$form = $post["infoCoapp"];
					
					if ($form["coapp"] == "yes") {
						$data = [
							"propertyId"    => $propertyId,
							"type"          => "co-applicant",
							"firstName"     => $form["firstName"],
							"middleName"    => array_key_exists("middleName", $form) ? $form["middleName"] : null,
							"lastName"      => $form["lastName"],
							"homePhone"     => array_key_exists("homePhone", $form) ? $form["homePhone"] : null,
							"cellPhone"     => array_key_exists("cellPhone", $form) ? $form["cellPhone"] : null,
							"workPhone"     => array_key_exists("workPhone", $form) ? $form["workPhone"] : null,
							"dob"           => $form["dob"],
							"ssn"           => $form["ssn"],
							"email"         => $form["email"],
							"dln"           => $form["dln"],
							"dlnState"      => $form["dlnState"]			
						];

						$coapplicantId = $this->applicantModel->addApplicant($data)->newRecordId;
						$err = empty($coapplicantId) ? "error adding co-applicant" : "";
					}
				}

				if (empty($err) && !empty($coapplicantId) && array_key_exists("empCurrCoapp", $post)) {
					$form = $post["empCurrCoapp"];
					$data = [
							"applicantId"     => $coapplicantId,
							"type"            => "current",
							"status"          => $form["status"],
							"employer"        => null,
							"occupation"      => null,
							"address"         => null,
							"city"            => null,
							"state"           => null,
							"zip"             => null,
							"supervisorName"  => null,
							"supervisorPhone" => null,
							"yearsEmployed"   => null,
							"monthlyIncome"   => null					
						];

					if (strpos($form["status"], "full time") !== false || 
							strpos($form["status"], "part time") !== false) {
						$data["employer"]        = $form["employer"];
						$data["occupation"]      = $form["occupation"];
						$data["address"]         = $form["address"];
						$data["city"]            = $form["city"];
						$data["state"]           = $form["state"];
						$data["zip"]             = $form["zip"];
						$data["supervisorName"]  = $form["supervisorName"];
						$data["supervisorPhone"] = $form["supervisorPhone"];
						$data["yearsEmployed"]   = $form["yearsEmployed"];
						$data["monthlyIncome"]   = str_replace(",", "", $form["monthlyIncome"]);
					}				

					$err = $this->applicantModel->addEmployment($data);
					$err = $err == false ? "error adding co-applicant current employment" : "";
				}			

				if (empty($err) && !empty($coapplicantId) && array_key_exists("empPrevCoapp", $post)) {
					$form = $post["empPrevCoapp"];
					if ($form["employment"] == "yes") {
						$data = [
							"applicantId"     => $coapplicantId,
							"type"            => "previous",
							"status"          => $form["status"],
							"employer"        => $form["employer"],
							"occupation"      => $form["occupation"],
							"address"         => $form["address"],
							"city"            => $form["city"],
							"state"           => $form["state"],
							"zip"             => $form["zip"],
							"supervisorName"  => $form["supervisorName"],
							"supervisorPhone" => $form["supervisorPhone"],
							"yearsEmployed"   => $form["yearsEmployed"],
							"monthlyIncome"   => str_replace(",", "", $form["monthlyIncome"])					
						];

						$err = $this->applicantModel->addEmployment($data);
						$err = $err == false ? "error adding co-applicant previous employment" : "";
					}
				}

				if (empty($err) && !empty($coapplicantId) && array_key_exists("creditCoapp", $post)) {
					$form = $post["creditCoapp"];
					$data = [
						"applicantId"  => $coapplicantId,
						"bankrupt"     => $form["bankrupt"] == "yes" ? "1" : "0",
						"evicted"      => $form["evicted"] == "yes" ? "1" : "0",
						"latePayments" => $form["latePayments"] == "yes" ? "1" : "0",
						"convicted"    => $form["convicted"] == "yes" ? "1" : "0",
						"explanation"  => array_key_exists("explanation", $form) ? $form["explanation"] : null
					];

					$err = $this->applicantModel->addCredit($data);
					$err = $err == false ? "error adding co-applicant credit history" : "";
				}

				if (empty($err) && !empty($applicantId) && array_key_exists("dependents", $post)) {
					$form = $post["dependents"];
					$num  = $form["numDependents"];

					for ($i=1; $i<=intval($num); $i++) {					
						$data = [
							"applicantId" => $applicantId,
							"name"        => $form["name$i"],
							"dob"         => $form["dob$i"]
						];

						$err = $this->applicantModel->addDependent($data);
						$err = $err == false ? "error adding dependents" : "";

						if (!empty($err)) {
							break;
						}
					}
				}

				if (empty($err) && !empty($applicantId) && array_key_exists("currRes", $post)) {
					$form = $post["currRes"];
					$data = [
						"applicantId"   => $applicantId,
						"type"          => "current",
						"address"       => $form["address"],
						"city"          => $form["city"],
						"state"         => $form["state"],
						"zip"           => $form["zip"],
						"payment"       => str_replace(",", "", $form["payment"]),
						"rentOwn"       => $form["rentOwn"],
						"landlordName"  => $form["landlordName"],
						"landlordPhone" => $form["landlordPhone"],
						"leavingReason" => $form["leavingReason"]
					];

					$err = $this->applicantModel->addResidence($data);
					$err = $err == false ? "error adding current residential history" : "";
				}

				if (empty($err) && !empty($applicantId) && array_key_exists("prevRes", $post)) {
					$form = $post["prevRes"];
					
					if ($form["residence"] == "yes") {
						$data = [
							"applicantId"   => $applicantId,
							"type"          => "previous",
							"address"       => $form["address"],
							"city"          => $form["city"],
							"state"         => $form["state"],
							"zip"           => $form["zip"],
							"payment"       => str_replace(",", "", $form["payment"]),
							"rentOwn"       => $form["rentOwn"],
							"landlordName"  => $form["landlordName"],
							"landlordPhone" => $form["landlordPhone"],
							"leavingReason" => $form["leavingReason"]
						];

						$err = $this->applicantModel->addResidence($data);
						$err = $err == false ? "error adding previous residential history" : "";
					}
				}

				if (empty($err) && !empty($applicantId) && array_key_exists("references", $post)) {
					$form = $post["references"];
					
					for ($i=1; $i<=3; $i++) {					
						$data = [
							"applicantId"  => $applicantId,
							"name"         => $form["name$i"],
							"phone"        => $form["phone$i"],
							"relationship" => $form["relationship$i"],
							"yearsKnown"   => $form["yearsKnown$i"],
							"address"      => $form["address$i"]
						];

						$err = $this->applicantModel->addReference($data);
						$err = $err == false ? "error adding references" : "";

						if (!empty($err)) {
							break;
						}
					}
				}

				if (empty($err) && !empty($applicantId) && array_key_exists("emergency", $post)) {
					$form = $post["emergency"];
					$data = [
							"applicantId"  => $applicantId,
							"name"         => $form["name"],
							"phone"        => $form["phone"],
							"relationship" => $form["relationship"],
							"address"      => $form["address"]
						];

					$err = $this->applicantModel->addEmergency($data);
					$err = $err == false ? "error adding emergency contact" : "";
				}

				if (empty($err) && !empty($applicantId) && array_key_exists("vehicles", $post)) {
					$form = $post["vehicles"];
					$num  = $form["numVehicles"];

					for ($i=1; $i<=intval($num); $i++) {					
						$data = [
							"applicantId"        => $applicantId,
							"make"               => $form["make$i"],
							"model"              => $form["model$i"],
							"color"              => $form["color$i"],
							"year"               => $form["year$i"],
							"licensePlateNumber" => $form["licensePlateNumber$i"],
							"licensePlateState"  => $form["licensePlateState$i"]
						];

						$err = $this->applicantModel->addVehicle($data);
						$err = $err == false ? "error adding vehicles" : "";

						if (!empty($err)) {
							break;
						}
					}
				}

				if (empty($err) && !empty($applicantId) && array_key_exists("additional", $post)) {
					$form = $post["additional"];
					$data = [
						"applicantId"    => $applicantId,
						"additionalInfo" => array_key_exists("additionalInfo", $form) ? $form["additionalInfo"] : null,
						"signature"      => $form["signatureApp"],
						"dateSubmitted"  => $timestamp
					];

					$err = $this->applicantModel->addAdditional($data);
					$err = $err == false ? "error adding applicant additional information" : "";
				}

				if (empty($err) && !empty($coapplicantId) && array_key_exists("additional", $post)) {
					$form = $post["additional"];
					$data = [
						"applicantId"    => $coapplicantId,
						"additionalInfo" => null,
						"signature"      => $form["signatureCoapp"],
						"dateSubmitted"  => $timestamp
					];

					$err = $this->applicantModel->addAdditional($data);
					$err = $err == false ? "error adding co-applicant additional information" : "";
				}

				if (empty($err) && !empty($propertyId) && !empty($applicantId)) {
					$app = $this->applicantModel->getPrint([$propertyId, $applicantId, $coapplicantId]);
					$doc = $this->getPdf($app)->Output("S");			
					$err = $this->sendApplicantEmail($app, $doc);
					$err = $err != true ? "error sending applicant email" : "";

					if (empty($err)) {
						$err = $this->sendLandlordEmail($app);
						$err = $err != true ? "error sending landlord email" : "";
					}
				}		

				if (empty($err)) {
					echo json_encode(["succeeded" => true, "redirect" => "/confirm"]);
				}
				else {
					echo json_encode(["succeeded" => false, "errors" => $err, "firstError" => $firstError]);
				}
			}
		}
	}
?>