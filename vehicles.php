<?php
// Responsible for vehicle queries
//

namespace libMBTA; 

include_once("generic.php"); 

class vehicles extends mbtaObj { 
	
	function __construct() { 
		parent::__construct(); 
	} 

	public function getVehiclesByRoute($routeID) { 
		// Accepts only routeID
		//

		$params = "route=" . rawurlencode($routeID); 

		$results = $this->queryMBTA("vehiclesbyroute", $params); 

		if ( $this->isError($results) ) { 
			throw new VehicleNotAvailable($this->isError($results)); 
		} else { 
			return $results; 
		} 
	}

	public function getVehiclesByTrip($tripID) { 
		// Accepts only tripID
		//

		$params = "trip=" . rawurlencode($tripID); 

		$results = $this->queryMBTA("vehiclesbytrip", $params); 

		if ( $this->isError($results) ) { 
			throw new VehicleNotAvailable($this->isError($results)); 
		} else { 
			return $results; 
		} 
	}
} // end class vehicles

