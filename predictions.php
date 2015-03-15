<?php
// Responsible for pulling prediction
//

namespace libMBTA; 

include_once("generic.php"); 

class predictions extends mbtaObj { 

	function __construct() { 
		parent::__construct(); 
	}

	public function getPredictionsByStop($stopID, $arrParams="") { 
		// arrParams is an array of key/value pairs that will
		// be glued together with http_build_query. 
		//
		// Valid fields can be found in the MBTA docs, but currently
		// consist of: 
		// 	- stop (mandatory)			: GFTS-compatible stop_id
		// 	- include_access_alerts		: "true" or "false", not 0/1
		// 	- include_service_alerts	: "true" or "false", not 0/1
		//
		// Example: 
		//
		// getPredictionsByStop("Providence", array(
		// 	'include_access_alerts'		=> "false", 
		// 	'include_service_alerts'	=> "true"); 
		//

		if ( $arrParams == "" ) { 
			$params = "stop=" . rawurlencode($stopID); 
		} else { 
			$params = "stop=" . rawurlencode($stopID) . "&" . http_build_query($arrParams);
		} 

		$results = $this->queryMBTA("predictionsbystop", $params); 

		if ( $this->isError($results) ) { 
			throw new PredictionNotAvailable($this->isError($results)); 
		} else { 
			return $results;
		}
	} 

	public function getPredictionsByRoute($routeID, $arrParams="") { 
		// Takes the same $arrParams as getPredictionsByStop()
		//

		if ( $arrParams == "" ) { 
			$params = "route=" . rawurlencode($routeID); 
		} else { 
			$params = "route=" . rawurlencode($routeID) . "&" . http_build_query($arrParams); 
		} 

		$results = $this->queryMBTA("predictionsbyroute", $params); 

		if ( $this->isError($results) ) { 
			throw new PredictionNotAvailable($this->isError($results)); 
		} else { 
			return $results; 
		} 
	}

	public function getPredictionsByTrip($tripID) { 
		// Only accepts $tripID

		$params = "trip=" . rawurlencode($tripID); 

		$results = $this->queryMBTA("predictionsbytrip", $params); 

		if ( $this->isError($results) ) { 
			throw new PredictionNotAvailable($this->isError($results)); 
		} else { 
			return $results; 
		}
	}
} // end class predictions


?>
