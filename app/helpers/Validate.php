<?php
	class Validate {
		public static function isValid($obj) {
			foreach($obj as $key => $childObj) {
				if (strlen($childObj->error) > 0) {
					return false;
				}
			}
			
			return true;
		}
		
		public static function getFirstError($obj) {
			foreach($obj as $key => $childObj) {
				if (strlen($childObj->error) > 0) {
					return $key;
				}
			}
			
			return false;
		}
		
		public static function isNotEmpty($obj, $msg) {	
			$test = strlen(trim($obj->value)) == 0;
			
			return self::toggleError($obj, $test, $msg);
		}
		
		public static function isEmail($obj, $msg) {	
			$test = !filter_var($obj->value, FILTER_VALIDATE_EMAIL);
			
			return self::toggleError($obj, $test, $msg);
		}
		
		public static function isUrl($obj, $msg) {	
			$test = !filter_var($obj->value, FILTER_VALIDATE_URL);
			
			return self::toggleError($obj, $test, $msg);
		}
		
		public static function isDate($obj, $msg) {
			$test = strlen(trim($obj->value)) == 0;
			
			if ($test) {
				return self::toggleError($obj, $test, $msg);	
			}
			else {
				$test = strlen(preg_replace("/[^0-9]/", "", $obj->value)) == 8;
				
				if ($test) {
					$date = explode("/", $obj->value);
					$test = checkdate($date[0], $date[1], $date[2]);
				}
				
				return self::toggleError($obj, !$test, $msg);
			}			
		}
		
		public static function isPastDate($obj, $msg) {
			$test = self::isDate($obj, $msg);
			
			if ($test) {
				$today = new DateTime("now");
				$date  = new DateTime($obj->value);
				$test  = $date < $today;
			}
			
			return self::toggleError($obj, !$test, $msg);
		}
		
		public static function isFutureDate($obj, $msg) {
			$test = self::isDate($obj, $msg);
			
			if ($test) {
				$today = new DateTime("now");
				$date  = new DateTime($obj->value);
				$test  = $date > $today;
			}
			
			return self::toggleError($obj, !$test, $msg);
		}
		
		public static function isYear($obj, $msg) {
			$test = strlen(trim($obj->value)) == 0;
			
			if ($test) {
				return self::toggleError($obj, $test, $msg);	
			}
			else {
				$test = checkdate("01", "01", $obj->value);
				
				return self::toggleError($obj, !$test, $msg);
			}			
		}
		
		public static function isPhone($obj, $msg) {	
			$test = strlen(preg_replace("/[^0-9]/", "", $obj->value)) != 10;
			
			return self::toggleError($obj, $test, $msg);
		}
		
		public static function isSsn($obj, $msg) {	
			$test = strlen(preg_replace("/[^0-9]/", "", $obj->value)) != 9;
			
			return self::toggleError($obj, $test, $msg);
		}
		
		public static function isZip($obj, $msg) {	
			$test = strlen(preg_replace("/[^0-9]/", "", $obj->value)) != 5;
			
			return self::toggleError($obj, $test, $msg);
		}
		
		public static function checkImageFile($obj, $filename, $tmpname, $filesize) {
			$errors_file   = "";

			// Check if image file is a actual image or fake image			
			$targetDir     = dirname( __FILE__, 3) . "\\uploads\\";
			$targetFile    = $targetDir . basename($filename);
			$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

			if (getimagesize($tmpname) !== false) {			
				if ($filesize > 512000) {
					$errors_file = "File size cannot exceed 500KB.";
				}
				else {
					if ($imageFileType != "jpg" && $imageFileType != "jpeg") {
						$errors_file = "Only JPG and JPEG are allowed.";
					}
				}
			} 
			else {
				$errors_file = $filename . " is not an image.";
			}
			
			return self::toggleError($obj, strlen($errors_file) > 0, $errors_file);
		}
		
		public static function toggleError($obj, $bln, $msg) {
			if ($bln) {
				$obj->error = $msg;
				return false;
			}
			else {
				$obj->error = "";
				return true;
			}
		}
		
		public static function setProperties($props, $arr=[]) {
			$obj  = new stdClass();
			
			foreach($props as $prop) {
				$obj->$prop = new stdClass();
				$obj->$prop->value = array_key_exists($prop, $arr) ? is_array($arr[$prop]) ? implode(",", $arr[$prop]) : trim($arr[$prop]) : "";
				$obj->$prop->error = "";
			}
			
			return $obj;
		}
		
		public static function getErrors($data) {
			$errors = new stdClass();

			foreach($data as $key => $value) {
				if ($value->error) {
					$errors->$key = $value->error;
				}
			}

			return count((array)$errors) > 0 ? $errors : null;
		}
	}
?>