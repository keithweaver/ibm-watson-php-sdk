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

	//Analyze phrase
	$response = $retrieveAndRankObj->analyze("SOME_RANDOM_CODE","Is it mild?");

	/*
	{
		"success" : true,
		"message" : "Listed the classifiers that have been created.",
		"top_class" : "conditions",
		"classes" : [
						{
							"name" : "conditions",
							"confidence" : 0.9678053667066
						},
						{
							"name" : "temperature",
							"confidence" : 0.0321946332934
						}
					]
	}
	*/
?>