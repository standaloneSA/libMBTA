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

	protected function queryMBTA($query,$otherParams = "", $format = "json") { 
		// Example: 
		// 	queryMBTA("routesbystop", "stop=place-bbsta", "xml")
		// or
		// 	queryMBTA("routes"); 
		//
		// Returns: 
		// 	Raw content from server
		//
		// Throws:
		// 	Exception ServerNotAvailable

		global $APIKEY;
	
		if ( $otherParams != "" ) { 
			// We can't have two &s together or the API wigs out. By doing this we can
			// make sure that we can throw in an empty string or a well-formatted variable
			$otherParams = "&" . $otherParams;
		}

		$url = $this->baseURL . $query . "?api_key=" . $APIKEY .  $otherParams . "&format=$format";
		print "URL: $url\n"; 
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		$result = curl_exec($ch); 

		if ( ! $result ) { 
			throw new ServerNotAvailable("Error retrieving information: " . curl_error($ch)); 
		}

		curl_close($ch); 

		return $result; 

	} // end queryMBTA()

} // end class mbtaObj

class ServerNotAvailable extends \RuntimeException { protected $code = 100; }
class RouteNotAvailable extends \RuntimeException { protected $code = 200; } 
class ScheduleNotAvailable extends \RuntimeException { protected $code = 300; } 
class StopNotAvailable extends \RuntimeException { protected $code = 400; } 
class PlaceNotAvailable extends \RuntimeException { protected $code = 500; } 
class VehicleNotAvailable extends \RuntimeException { protected $code = 600; } 
class TripNotAvailable extends \RuntimeException { protected $code = 700; } 
class PredictionNotAvailable extends \RuntimeException { protected $code = 800; } 

// Generic catch-all if it doesn't fit the above
class InformationNotAvailable extends \RuntimeException { protected $code = 900; } 


?>
