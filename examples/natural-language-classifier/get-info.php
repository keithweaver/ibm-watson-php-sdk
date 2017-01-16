<?php
	/*
	What's this vendor/autoload.php? This is used with composer.
	You need to run `composer install`
	*/
	require_once "../../vendor/autoload.php";
	
	$naturalLangObj = new \Kweaver\Watson\NaturalLanguageClassifier();
	
	//Set your IBM Watson Bluemix Service Credentials
	$naturalLangObj->setServiceCredentials("YOUR_WATSON_SERVICE_CREDENTIALS_USER_NAME","YOUR_WATSON_SERVICE_CREDENTIALS_PASSWORD");
		
	/*

	//You can reference IBM Watson Bluemix Service Credentials
	
	echo $naturalLangObj->getUserName();
	echo $naturalLangObj->getPassword();
	echo $naturalLangObj->getServiceCredentials();
	
	*/

	//Get information about an analyzer
	$response = $retrieveAndRankObj->getInfo("SOME_RANDOM_CODE");

	/*
	{
		"success" : true,
		"message" : "Listed the classifiers that have been created.",
		"classifier" : {
							"id" : "SOME_RANDOM_CODE",
							"name" : "Example Name",
							"language" : "en",
							"created" : "2016-11-29T00:53:21.049Z"
						}
	}
	*/
?>