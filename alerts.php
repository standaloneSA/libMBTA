<?php
// Responsible for alert queries
//

namespace libMBTA; 

include_once("generic.php"); 

class alerts extends mbtaObj { 

	function __construct() { 
		parent::__construct(); 
	}

	public function getAlerts($arrParams="") { 
		// Two optional parameters are accepted: 
		//  - include_access_alerts 
		//  		specific to alerts on elevators and excalators
		//  - include_service_alerts
		//  
		//  Values for each of these should be "true" or "false". 
		//  Default is "true"
		//

		if ( $arrParams = "" ) { 
			$results = $this->queryMBTA("alerts"); 
		} else { 
			$params = http_build_query($arrParams); 
			$results = $this->queryMBTA("alerts", $arrParams); 
		}

		if ( $this->isError($results) ) { 
			throw new AlertNotAvailable($this->isError($results)); 
		} else { 
			return $results; 
		} 

	} 

} // end class alerts
