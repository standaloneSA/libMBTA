<?php 

	// standaloneSA\libMBTA\mbtaObj.php
	//
	// Creates a relatively generic class that other, more
	// specific MBTA-related classes can inherit from.

	namespace standaloneSA\libMBTA;

	class mbtaObj {
		public $apiVersion = "2";
		private $baseURL = "http://realtime.mbta.com/developer/api/v2/";
		private $initTime = "";
		private $config = array();

		public function __construct($configFile = null) {
			// Using America/New_York since it's sort of the only place MBTA is applicable.
			// Even so, this should be made configurable.  - AndyM84
			$this->initTime = new \DateTime('now', new \DateTimeZone('America/New_York'));

			$data = '';

			if ($configFile !== null && !empty($configFile) && substr($configFile, -4) == "json" && file_exists($configFile)) {
				$data = file_get_contents($configFile);
			} else {
				$data = file_get_contents(realpath(dirname(__FILE__)) . '/config.json');
			}

			$this->config = (!empty($data)) ? json_decode($data,TRUE) : array('apikey' => 'null');
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
	
			if ( $otherParams != "" ) { 
				// We can't have two &s together or the API wigs out. By doing this we can
				// make sure that we can throw in an empty string or a well-formatted variable
				$otherParams = "&" . $otherParams;
			}

			$url = $this->baseURL . $query . "?api_key=" . $this->config['apikey'] .  $otherParams . "&format=json";
			print "URL: $url\n";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);

			if (!$result) {
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

		public function getConfigValue($key) {
			if (isset($this->config) && array_key_exists($key, $this->config)) {
				return $this->config[$key];
			}

			return 'null';
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
	class TripNotAvailable extends MBTAException { protected $code = 700; }
	class PredictionNotAvailable extends MBTAException { protected $code = 800; }
	class AlertNotAvailable extends MBTAException { protected $code = 900; }

	// Generic catch-all if it doesn't fit the above
	class InformationNotAvailable extends MBTAException { protected $code = 1000; }
