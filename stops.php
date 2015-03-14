<?php
// Responsible for dealing with stops
//

namespace libMBTA;

include_once("generic.php"); 

class stops extends mbtaObj { 
	public $allRoutes = array();

	function __construct() { 
		parent::__construct(); 
	}

	public function getStopsByRoute($stopID) { 
		$results = $this->queryMBTA("stopsbyroute", "route=$stopID"); 
		
		if ( $this->isError($results) ) { 
			throw new StopNotAvailable($this->isError($results)); 
		} else { 
			return $results; 
		}
	} 

	public function getStopsByLocation($coord) { 
		// $coord is a numeric array, where [0] is latitude, and [1] is longitute

		$results = $this->queryMBTA("stopsbylocation", "lat=" . $coord[0] . "&lon=" . $coord[1]);

		if ( $this->isError($results) ) { 
			throw new StopNotAvailable($this->isError($results)); 
		} else { 
			return $results; 
		}
	}

} // end class routes

?>
