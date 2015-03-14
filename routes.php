<?php
// Responsible for the relatively simple act of getting routes. 
//

namespace libMBTA;

include_once("generic.php"); 

class routes extends mbtaObj { 
	public $allRoutes = array();

	function __construct() { 
		parent::__construct(); 
	}

	public function getAllRoutes() {
		$this->routes = $this->queryMBTA("routes");
		return $this->routes; 
	}

	public function getRoutesByStop($stopID) { 
		$results = $this->queryMBTA("routesbystop", "stop=$stopID"); 
		
		if ( $this->isError($results) ) { 
			throw new RouteNotAvailable($this->isError($results)); 
		} else { 
			return $results; 
		}
	} 

} // end class routes

?>
