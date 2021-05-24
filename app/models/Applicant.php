<?php
	class Applicant {
		private $db;
		
		public function __construct() {
			$this->db = new Database();
		}
		
		# find all application data for Print version
		public function getPrint($arr) {
			$this->db->query("CALL spGetPrint(:_propertyId, :_applicantId, :_coapplicantId, :_aesKey)");
			
			$params = [
				":_propertyId"    => $arr[0],
				":_applicantId"   => $arr[1],
				":_coapplicantId" => empty($arr[2]) ? null : $arr[2],
				":_aesKey"        => DB_SALT
			];
			
			$this->db->bindArray($params);
			$row = $this->db->single();

			return $row;
		}
		
		# find all applicants for Excel export
		public function getExport() {
			$this->db->query("CALL spGetExport(:_aesKey)");			
			$this->db->bind(":_aesKey", DB_SALT);
			$results = $this->db->resultSet();

			return $results;
		}
		
		# find all applicants
		public function getApplicants() {
			$this->db->query("CALL spGetApplicants()");
			$results = $this->db->resultSet();

			return $results;
		}
		
		# find applicant by id
		public function getApplicantById($id) {
			$this->db->query("CALL spGetApplicantById(:_applicantId)");
			$this->db->bind(":_applicantId", $id);
			$row = $this->db->single();

			return $row;
		}
		
		# add new applicant		
		public function addApplicant($data) {
			$this->db->query("CALL spAddApplicant(:_propertyId, :_type, :_firstName, :_middleName, :_lastName, :_homePhone, :_cellPhone, :_workPhone, :_dob, :_ssn, :_email, :_dln, :_dlnState, :_aesKey)");
			
			$params = [
				":_propertyId" => $data["propertyId"], 
				":_type"       => $data["type"], 
				":_firstName"  => $data["firstName"], 
				":_middleName" => $data["middleName"], 
				":_lastName"   => $data["lastName"], 
				":_homePhone"  => $data["homePhone"], 
				":_cellPhone"  => $data["cellPhone"], 
				":_workPhone"  => $data["workPhone"], 
				":_dob"        => $data["dob"], 
				":_ssn"        => $data["ssn"], 
				":_email"      => $data["email"], 
				":_dln"        => $data["dln"], 
				":_dlnState"   => $data["dlnState"],
				":_aesKey"     => DB_SALT				
			];
			
			$this->db->bindArray($params);
			
			# execute
			return $this->db->executeAndGetId();
		}
		
		# add new employment
		public function addEmployment($data) {
			$this->db->query("CALL spAddEmployment(:_applicantId, :_type, :_status, :_employer, :_occupation, :_address, :_city, :_state, :_zip, :_supervisorName, :_supervisorPhone, :_yearsEmployed, :_monthlyIncome)");
			
			$params = [
				":_applicantId"     => $data["applicantId"], 
				":_type"            => $data["type"],
				":_status"          => $data["status"],
				":_employer"        => $data["employer"],
				":_occupation"      => $data["occupation"],
				":_address"         => $data["address"],
				":_city"            => $data["city"],
				":_state"           => $data["state"],
				":_zip"             => $data["zip"],
				":_supervisorName"  => $data["supervisorName"],
				":_supervisorPhone" => $data["supervisorPhone"],
				":_yearsEmployed"   => $data["yearsEmployed"],
				":_monthlyIncome"   => $data["monthlyIncome"],
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
		
		# add new credit
		public function addCredit($data) {
			$this->db->query("CALL spAddCredit(:_applicantId, :_bankrupt, :_evicted, :_latePayments, :_convicted, :_explanation)");
			
			$params = [
				":_applicantId"  => $data["applicantId"], 
				":_bankrupt"     => $data["bankrupt"],
				":_evicted"      => $data["evicted"],
				":_latePayments" => $data["latePayments"],
				":_convicted"    => $data["convicted"],
				":_explanation"  => $data["explanation"]
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
		
		# add new dependent
		public function addDependent($data) {
			$this->db->query("CALL spAddDependent(:_applicantId, :_name, :_dob)");
			
			$params = [
				":_applicantId" => $data["applicantId"], 
				":_name"        => $data["name"],
				":_dob"         => $data["dob"]
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
		
		# add new residence
		public function addResidence($data) {
			$this->db->query("CALL spAddResidence(:_applicantId, :_type, :_address, :_city, :_state, :_zip, :_payment, :_rentOwn, :_landlordName, :_landlordPhone, :_leavingReason)");
			
			$params = [
				":_applicantId"   => $data["applicantId"], 
				":_type"          => $data["type"],
				":_address"       => $data["address"],
				":_city"          => $data["city"],
				":_state"         => $data["state"],
				":_zip"           => $data["zip"],
				":_payment"       => $data["payment"],
				":_rentOwn"       => $data["rentOwn"],
				":_landlordName"  => $data["landlordName"],
				":_landlordPhone" => $data["landlordPhone"],
				":_leavingReason" => $data["leavingReason"],
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
		
		# add new reference
		public function addReference($data) {
			$this->db->query("CALL spAddReference(:_applicantId, :_name, :_phone, :_relationship, :_yearsKnown, :_address)");
			
			$params = [
				":_applicantId"  => $data["applicantId"], 
				":_name"         => $data["name"],
				":_phone"        => $data["phone"],
				":_relationship" => $data["relationship"],
				":_yearsKnown"   => $data["yearsKnown"],
				":_address"      => $data["address"]
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
		
		# add new emergency contact
		public function addEmergency($data) {
			$this->db->query("CALL spAddEmergency(:_applicantId, :_name, :_phone, :_relationship, :_address)");
			
			$params = [
				":_applicantId"  => $data["applicantId"], 
				":_name"         => $data["name"],
				":_phone"        => $data["phone"],
				":_relationship" => $data["relationship"],
				":_address"      => $data["address"]
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
		
		# add new vehicle
		public function addVehicle($data) {
			$this->db->query("CALL spAddVehicle(:_applicantId, :_make, :_model, :_color, :_year, :_licensePlateNumber, :_licensePlateState)");
			
			$params = [
				":_applicantId"        => $data["applicantId"], 
				":_make"               => $data["make"],
				":_model"              => $data["model"],
				":_color"              => $data["color"],
				":_year"               => $data["year"],
				":_licensePlateNumber" => $data["licensePlateNumber"],
				":_licensePlateState"  => $data["licensePlateState"]
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
		
		# add new additional information
		public function addAdditional($data) {
			$this->db->query("CALL spAddAdditional(:_applicantId, :_additionalInfo, :_signature, :_dateSubmitted)");
			
			$params = [
				":_applicantId"    => $data["applicantId"], 
				":_additionalInfo" => $data["additionalInfo"],
				":_signature"      => $data["signature"],
				":_dateSubmitted"  => $data["dateSubmitted"]
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
		
		# update date emailed
		public function updateDateEmailed($arr) {
			$this->db->query("CALL spUpdateDateEmailed(:_applicantId, :_coapplicantId, :_dateEmailed)");
			
			$params = [
				":_applicantId"   => $arr[0], 
				":_coapplicantId" => empty($arr[1]) ? null : $arr[1],
				":_dateEmailed"   => $arr[2]
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