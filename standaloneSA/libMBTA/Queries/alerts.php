<?php

	// Responsible for alert queries
	//

	namespace standaloneSA\libMBTA\Queries;

	use standaloneSA\libMBTA as libMBTA;

	class alerts extends libMBTA\mbtaObj {
		private $IncludeAccessAlerts = true;
		private $IncludeServiceAlerts = true;

		public function __construct() {
			parent::__construct();

			return;
		}

		public function excludeAccessAlerts() {
			$this->IncludeAccessAlerts = false;

			return $this;
		}

		public function excludeServiceAlerts() {
			$this->IncludeServiceAlerts = false;

			return $this;
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
				$params = array(
					'include_access_alerts=' . ($this->IncludeAccessAlerts) ? 'true' : 'false',
					'include_service_alerts=' . ($this->IncludeServiceAlerts) ? 'true' : 'false'
				);

				$arrParams = implode('&', $params);
			}

			$results = $this->queryMBTA("alerts", $arrParams);

			if ( $this->isError($results) ) {
				throw new libMBTA\AlertNotAvailable($this->isError($results));
			} else {
				return $results;
			}
		}

		public function includeAccessAlerts() {
			$this->IncludeAccessAlerts = true;

			return $this;
		}

		public function includeServiceAlerts() {
			$this->IncludeServiceAlerts = true;

			return $this;
		}

		public function isIncludingAccessAlerts() {
			return $this->IncludeAccessAlerts;
		}

		public function isIncludingServiceAlerts() {
			return $this->IncludeServiceAlerts;
		}
	} // end class alerts
