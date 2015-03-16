<?php

	// Responsible for the relatively simple act of getting routes. 
	//

	namespace standaloneSA\libMBTA\Queries;

	use standaloneSA\libMBTA as libMBTA; 

	class routes extends libMBTA\mbtaObj {
		public $allRoutes = array();

		function __construct() {
			parent::__construct();
		}

		public function getAllRoutes() {
			$results = $this->queryMBTA("routes");

			if ( $this->isError($results) ) {
				throw new libMBTA\RouteNotAvailable($this->isError($results));
			} else {
				$this->routes = $results;

				return $this->routes;
			}
		}

		public function getRoutesByStop($stopID) {
			$results = $this->queryMBTA("routesbystop", "stop=$stopID");

			if ( $this->isError($results) ) {
				throw new libMBTA\RouteNotAvailable($this->isError($results));
			} else {
				return $results;
			}
		}
	} // end class routes
