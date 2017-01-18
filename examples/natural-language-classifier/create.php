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

	//Create a JSON Object for Meta Data
	$localFilePathForTrainingMetaDataJSON = realpath("./new_training_data_meta_data.json");
	//Language Options: English (en), Arabic (ar), French (fr), German, (de), Italian (it), Japanese (ja), Portuguese (pt), and Spanish (es)

	//Upload the CSV file for training
	$localFilePathForTrainingData = realpath("./weather_data_train.csv");
	

	$response = $naturalLangObj->create($localFilePathForTrainingData,$localFilePathForTrainingMetaDataJSON);
	/*
	{
		classifierId : "SOME_RANDOM_CODE",
		classifierName : "Example Name From JSON File",
		classifierStatus : "training",
		classifierStatusDescription : "The classifer is currently in training. You can not use it yet.",
		success : true,
		message : "Success. Created new classifier."
	}
	*/

	
	
?>