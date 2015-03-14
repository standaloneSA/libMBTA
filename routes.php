<?php
// Responsible for the relatively simple act of getting routes. 
//

namespace libMBTA;

include_once("generic.php"); 

class routes extends mbtaObj { 
	public $routes = array(); 

	function __construct() { 
		parent::__construct(); 
		$results = $this->queryMBTA("routes");
		$this->routes = json_decode($results); 
	}

	public function getRoutes() { 
		return $this->routes; 
	}

} // end class routes

?>
