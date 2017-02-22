<?php
	/*
	 * What's this vendor/autoload.php? This is used with composer.
	 * You need to run `composer install`
	*/
	// require_once "../../vendor/autoload.php";
	require_once "../../src/RetrieveAndRank.php";

	$retrieveAndRankObj = new \Kweaver\Watson\RetrieveAndRank();

	//Set your IBM Watson Bluemix Service Credentials
	$retrieveAndRankObj->setServiceCredentials("ea7df130-724c-4074-8add-e5e753c19acb","sTRQVp3Bd6NZ");

	/*
	 * These steps match https://www.ibm.com/watson/developercloud/doc/retrieve-rank/tutorial.shtml#create-collection
	 *
	 * Step 4 is create a collection
	 *
	 * cranfield-solr-config.zip <-- is the configuration name from the previous step
	 * 								 and this is the file name
	 */

	// createCollection (clusterId, collectionName, configurationName)
	$response = $retrieveAndRankObj->createCollection("sc9a0b6b6d_bc72_43e8_acfd_99ad14267e59","ExampleCollectionName","cranfield-solr-config.zip");

	print_r($response);


	/*
	Array ( [success] => 1 [message] => Success. Created collection. [results] => stdClass Object ( [responseHeader] => stdClass Object ( [status] => 0 [QTime] => 11138 ) [success] => stdClass Object ( [10.176.43.111:5937_solr] => stdClass Object ( [responseHeader] => stdClass Object ( [status] => 0 [QTime] => 2492 ) [core] => ExampleCollectionName_shard1_replica2 ) [10.176.42.14:5704_solr] => stdClass Object ( [responseHeader] => stdClass Object ( [status] => 0 [QTime] => 2861 ) [core] => ExampleCollectionName_shard1_replica1 ) ) ) )
	*/
?>