<?php
	/*
	 * What's this vendor/autoload.php? This is used with composer.
	 * You need to run `composer install`
	*/
	require_once "../../vendor/autoload.php";
	// require_once "../../src/RetrieveAndRank.php";

	$retrieveAndRankObj = new \Kweaver\Watson\RetrieveAndRank();

	//Set your IBM Watson Bluemix Service Credentials
	$retrieveAndRankObj->setServiceCredentials("ea7df130-724c-4074-8add-e5e753c19acb","sTRQVp3Bd6NZ");

	/*
	 * These steps match https://www.ibm.com/watson/developercloud/doc/retrieve-rank/tutorial.shtml#create-collection
	 *
	 * Step 1 is Create Cluster
	 */

	$response = $retrieveAndRankObj->createCluster("NewTestCluster",1);

	print_r($response);


	/*
	Array ( [success] => 1 [message] => Success. Cluster created [results] => stdClass Object ( [solr_cluster_id] => sc9a0b6b6d_bc72_43e8_acfd_99ad14267e59 [cluster_name] => NewTestCluster [cluster_size] => 1 [solr_cluster_status] => NOT_AVAILABLE ) )
	*/
?>