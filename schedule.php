<?php
// Responsible for dealing with schedules
//

namespace libMBTA; 

include_once("generic.php"); 

class schedules extends mbtaObj { 

	function __construct() { 
		parent::__construct(); 
	}

	public function getScheduleByStop($stopID, $arrParams) { 
		// arrParams is an array of key/value pairs that will 
		// be glued together with http_build_query. 
		//
		// Valid fields can be found in the MBTA docs, but currently 
		// consist of: 
		// 	- stop (manditory)	: GTFS-compatible stop_id 
		// 	- route (opt)			: GTFS-compatible route_id
		// 	- direction (opt)		: GTFS-compatible direction_id (bool) 
		// 	- datetime (opt)		: Epoch time within next 7 days
		// 	- max_time (opt)		: minutes ahead. Max 24 hours, default 60
		// 	- max_trips (opt)		: Maximum number of trips. Max val 100, default 5
		//
		//
		// Example: 
		//
		// getScheduleByStop("Back Bay", array('route' => 'CR-Providence', 
		// 												'direction' => '1', 
		// 												'max_time' => '120')); 
		//

		$params = "stop=" . rawurlencode($stopID) . "&" . http_build_query($arrParams); 

		$results = $this->queryMBTA("schedulebystop", $params); 

		if ( $this->isError($results) ) { 
			throw new ScheduleNotAvailable($this->isError($results)); 
		} else { 
			return $results; 
		}
	}

	public function getScheduleByRoute($routeID, $arrParams) { 
		// arrParams has identical optiosn to the one in getScheduleByStop()

		$params = "route=" . rawurlencode($routeID) . "&" . http_build_query($arrParams);

		$results = $this->queryMBTA("schedulebyroute", $params); 

		if ( $this->isError($results) ) { 
			throw new ScheduleNotAvailable($this->isError($results)); 
		} else { 
			return $results; 
		}
	}

} //end class schedules

?>
