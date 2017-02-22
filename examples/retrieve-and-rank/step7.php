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
	 * Step 7 - verify ranker is ready   [status] => Available
	 */

	$response = $retrieveAndRankObj->getRanker("1eec74x28-rank-1000");

	print_r($response);


	/*
	Array ( [success] => 1 [message] => Success. Search and rank. [results] => stdClass Object ( [ranker_id] => 1eec74x28-rank-1000 [name] => example_ranker [created] => 2017-02-22T02:44:25.697Z [url] => https://gateway.watsonplatform.net/retrieve-and-rank/api/v1/rankers/1eec74x28-rank-1000 [status] => Available [status_description] => The ranker instance is now available and is ready to take ranker requests. ) )
	*/
?>