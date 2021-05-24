<?php	
class Utility {
	public static function isActive($path) {
		return $_SERVER["REQUEST_URI"] == $path;
	}

	public static function setActive($path) {
		return self::isActive($path) ? " active" : "";
	}		

	public static function redirect($location) {
		header("location: ".URL_ROOT."/$location");
	}

	public static function isAdmin() {
		return isset($_SESSION["admin"]);
	}

	public static function login() {
		$_SESSION["admin"] = "yes";
	}

	public static function logout() {
		$_SESSION["admin"] = "";
		session_destroy();
		self::redirect("login");
	}

	public static function getPages($data, $numPerPage) {
		$pages = [];

		while (count($data) > 0) {
			array_push($pages, array_splice($data, 0, $numPerPage));
		}

		return $pages;
	}

	public static function getStates() {
		return [
			"AL", "AK", "AZ", "AR", "CA", "CO", "CT", "DE", "DC", "FL", 
			"GA", "HI", "ID", "IL", "IN", "IA", "KS", "KY", "LA", "ME", 
			"MD", "MA", "MI", "MN", "MS", "MO", "MT", "NE", "NV", "NH", 
			"NJ", "NM", "NY", "NC", "ND", "OH", "OK", "OR", "PA", "RI", 
			"SC", "SD", "TN", "TX", "UT", "VT", "VA", "WA", "WV", "WI", 
			"WY"
		];
	}
		
	public static function sendEmail($to, $subj, $msg, $doc=null) {
		# random hash to send mixed content
		$separator = md5(time());

		# carriage return type
		$eol = PHP_EOL;
		
		# cc
		$cc = "jennylynn0789@live.com";

		# email headers
		$hdrs = [
			'To'           => $to,
			'Cc'           => $cc,
			'From'         => MAIL_USER, 
			'Subject'      => $subj,
			'MIME-Version' => 1, 
			'Content-type' => "multipart/mixed; boundary=\"".$separator."\""
		];

		# email body
		$body  = "--".$separator.$eol;
		$body .= "Content-Type: text/html; charset=\"utf-8\"".$eol;
		$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
		$body .= $msg.$eol;
		
		if (!empty($doc)) {
			# encode data
			$attachment = chunk_split(base64_encode($doc));

			# attachment
			$body .= "--".$separator.$eol;
			$body .= "Content-Type: application/octet-stream; name=\"application.pdf\"".$eol; 
			$body .= "Content-Transfer-Encoding: base64".$eol;
			$body .= "Content-Disposition: attachment".$eol.$eol;
			$body .= $attachment.$eol;
			$body .= "--".$separator."--";
		}

		$smtp = Mail::factory('smtp', [
				'host'     => MAIL_HOST,
				'port'     => MAIL_PORT,
				'auth'     => true,
				'username' => MAIL_USER,
				'password' => MAIL_PASS
		]);

		return $smtp->send("$to, $cc", $hdrs, $body);
	}
}
?>