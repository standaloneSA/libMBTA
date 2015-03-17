<?php

	// standaloneSA\libMBTA\libMBTA.php
	//
	// This is the "central" script that ties together the
	// various requests and realtime queries. It's not strictly
	// necessary to include this - the useful functions are in
	// each of the php scripts included here.

	namespace standaloneSA\libMBTA;

	require_once("mbtaObj.php");
	require_once("Queries/alerts.php");
	require_once("Queries/vehicles.php");
	require_once("Queries/predictions.php");
	require_once("Queries/schedule.php");
	require_once("Queries/stops.php");
	require_once("Queries/routes.php");

	$alerts = new Queries\alerts;

	try {
		$result = $alerts->getAlerts();
	} catch ( AlertNotAvailable $e) {
		echo $e->errorMessage();
		exit;
	}

	print_r($result);
