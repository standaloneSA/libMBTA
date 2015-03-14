<?php 
// generic.php
//
// Creates a relatively generic class that other, more 
// specific MBTA-related classes can inherit from. 

namespace libMBTA;

class mbtaObj { 
	public $apiVersion = "2"; 
	private $baseURL = "http://realtime.mbta.com/developer/api/v2/"; 
	private $initTime = ""; 

	public function __construct() { 
		$this->initTime = new \DateTime('now'); 
	} 

	protected function queryMBTA($query,$otherParams = "") { 
		// Example: 
		// 	queryMBTA("routesbystop", "stop=place-bbsta", "xml")
		// or
		// 	queryMBTA("routes"); 
		//
		// Returns: 
		// 	Associative array consisting of json_decoded information
		// 	from the server.
		//
		// Throws:
		// 	Exception ServerNotAvailable

		global $APIKEY;
	
		if ( $otherParams != "" ) { 
			// We can't have two &s together or the API wigs out. By doing this we can
			// make sure that we can throw in an empty string or a well-formatted variable
			$otherParams = "&" . $otherParams;
		}

		$url = $this->baseURL . $query . "?api_key=" . $APIKEY .  $otherParams . "&format=json";
		print "URL: $url\n"; 
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		$result = curl_exec($ch); 

		if ( ! $result ) { 
			throw new ServerNotAvailable("Error retrieving information: " . curl_error($ch)); 
		}

		curl_close($ch); 

		return json_decode($result, true); 

	} // end queryMBTA()

	protected function isError($response) { 
		// This function checks for the existance of an "error" element in the json and
		// if found, returns the message, otherwise returns zero. 

		if (array_key_exists("error", $response)) { 
			return $response["error"]["message"];
		} else {
			return 0; 
		}
	}

} // end class mbtaObj

class MBTAException extends \Exception { 
	protected $code = 0; 

	public function errorMessage() { 
		$errorMessage = "Error:\n   File: " . $this->getFile() . "\n   Line: " . $this->getLine()
			. "\n   Code: " . $this->code . "\n   Message: " . $this->getMessage() . "\n"; 
		return $errorMessage; 
	}
}

class ServerNotAvailable extends MBTAException { protected $code = 100; }
class RouteNotAvailable extends MBTAException { protected $code = 200; } 
class ScheduleNotAvailable extends MBTAException { protected $code = 300; } 
class StopNotAvailable extends MBTAException { protected $code = 400; } 
class PlaceNotAvailable extends MBTAException { protected $code = 500; } 
class VehicleNotAvailable extends MBTAException { protected $code = 600; } 
class TripNotAvailable extends \Exception { protected $code = 700; } 
class PredictionNotAvailable extends \Exception { protected $code = 800; } 

// Generic catch-all if it doesn't fit the above
class InformationNotAvailable extends \Exception { protected $code = 900; } 


?>
