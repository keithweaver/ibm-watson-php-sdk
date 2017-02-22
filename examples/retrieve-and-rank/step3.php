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
	 * Step 3 is add solr config files
	 */

	$localPathToSolrZip = realpath("./docs/cranfield-solr-config.zip");

	$response = $retrieveAndRankObj->uploadSolrConfiguration("sc9a0b6b6d_bc72_43e8_acfd_99ad14267e59", $localPathToSolrZip);

	print_r($response);


	/*
	Array ( [success] => 1 [message] => Success. Uploaded Solr Configuration for sc9a0b6b6d_bc72_43e8_acfd_99ad14267e59. [results] => stdClass Object ( [message] => WRRCSR026: Successfully uploaded named config [cranfield-solr-config.zip] for Solr cluster [sc9a0b6b6d_bc72_43e8_acfd_99ad14267e59]. [statusCode] => 200 ) )
	*/
?>