<?php
	class Property {
		private $db;
		
		public function __construct() {
			$this->db = new Database();
		}
		
		public function addProperty($data) {
			$this->db->query("CALL spAddProperty(:_address, :_city, :_state, :_zip, :_rent, :_deposit, :_status, :_map, :_description, :_sqft, :_garage, :_bedrooms, :_bathrooms, :_lease, :_elementaryschool, :_middleschool, :_highschool)");
			
			$params = [
				":_address"          => $data->address->value,
				":_city"             => $data->city->value,
				":_state"            => $data->state->value,
				":_zip"              => $data->zip->value,
				":_rent"             => str_replace(",", "", $data->rent->value),
				":_deposit"          => str_replace(",", "", $data->deposit->value),
				":_status"           => $data->status->value,
				":_map"              => $data->map->value,
				":_description"      => $data->description->value,
				":_sqft"             => $data->sqft->value,
				":_garage"           => $data->garage->value,
				":_bedrooms"         => $data->bedrooms->value,
				":_bathrooms"        => $data->bathrooms->value,
				":_lease"            => $data->lease->value,
				":_elementaryschool" => $data->elementaryschool->value,
				":_middleschool"     => $data->middleschool->value,
				":_highschool"       => $data->highschool->value
			];
			
			$this->db->bindArray($params);
			
			# execute
			return $this->db->executeAndGetId();
		}
		
		public function updateProperty($data) {
			$this->db->query("CALL spUpdateProperty(:_propertyId, :_address, :_city, :_state, :_zip, :_rent, :_deposit, :_status, :_map, :_description, :_sqft, :_garage, :_bedrooms, :_bathrooms, :_lease, :_elementaryschool, :_middleschool, :_highschool)");
			
			$params = [
				":_propertyId"       => $data->propertyId->value,
				":_address"          => $data->address->value,
				":_city"             => $data->city->value,
				":_state"            => $data->state->value,
				":_zip"              => $data->zip->value,
				":_rent"             => str_replace(",", "", $data->rent->value),
				":_deposit"          => str_replace(",", "", $data->deposit->value),
				":_status"           => $data->status->value,
				":_map"              => $data->map->value,
				":_description"      => $data->description->value,
				":_sqft"             => $data->sqft->value,
				":_garage"           => $data->garage->value,
				":_bedrooms"         => $data->bedrooms->value,
				":_bathrooms"        => $data->bathrooms->value,
				":_lease"            => $data->lease->value,
				":_elementaryschool" => $data->elementaryschool->value,
				":_middleschool"     => $data->middleschool->value,
				":_highschool"       => $data->highschool->value
			];
			
			$this->db->bindArray($params);
			
			# execute
			return $this->db->execute();
		}
		
		public function addPropertyInterior($id, $interior, $sortOrder) {
			$this->db->query("CALL spAddPropertyInterior(:_propertyId, :_interiorimage, :_sortOrder)");
			
			$params = [
				":_propertyId"    => $id,
				":_interiorimage" => $interior,
				":_sortOrder"     => $sortOrder
			];
			
			$this->db->bindArray($params);
			
			# execute
			return $this->db->execute();
		}
		
		public function deletePropertyInterior($id) {
			$this->db->query("CALL spDeletePropertyInterior(:_propertyId)");
			$this->db->bind(":_propertyId", $id);
			
			# execute
			return $this->db->execute();
		}
		
		public function updatePropertyExterior($id, $exterior) {
			$this->db->query("CALL spUpdatePropertyExterior(:_propertyId, :_exteriorimage)");
			
			$params = [
				":_propertyId"    => $id,
				":_exteriorimage" => $exterior
			];
			
			$this->db->bindArray($params);
			
			# execute
			return $this->db->execute();
		}
		
		public function updateInteriorImagesSort($id, $order) {
			$this->db->query("CALL spUpdateInteriorImagesSort(:_imageId, :_sortOrder)");
			
			$params = [
				":_imageId"   => $id,
				":_sortOrder" => $order
			];
			
			$this->db->bindArray($params);
			
			# execute
			return $this->db->execute();
		}
		
		public function deleteProperty($id) {
			$this->db->query("CALL spDeleteProperty(:_propertyId)");
			$this->db->bind(":_propertyId", $id);
			
			# execute
			return $this->db->execute();
		}
		
		# find all properties
		public function getProperties() {
			$this->db->query("CALL spGetProperties()");
			$results = $this->db->resultSet();

			return $results;
		}
		
		# find all available properties
		public function getAvailableProperties() {
			$this->db->query("CALL spGetAvailableProperties()");
			$results = $this->db->resultSet();

			return $results;
		}
		
		# find property by id
		public function getPropertyById($id) {
			$this->db->query("CALL spGetPropertyById(:_propertyId)");
			$this->db->bind(":_propertyId", $id);
			$row = $this->db->single();

			return $row;
		}
		
		# find interior images by property id
		public function getInteriorImagesByPropertyId($id) {
			$this->db->query("CALL spGetInteriorImagesByPropertyId(:_propertyId)");
			$this->db->bind(":_propertyId", $id);
			$results = $this->db->resultSet();

			return $results;
		}
		
		# get database error
		public function getError() {
			return $this->db->getError();
		}
	}
?>