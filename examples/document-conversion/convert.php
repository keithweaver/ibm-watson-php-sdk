<?php
	require_once "../../vendor/autoload.php";
	
	$documentConversionObj = new \Kweaver\Watson\DocumentConversion();
		
	
	//Set your IBM Bluemix Credentials for the document conversion service
	$documentConversionObj->setServiceCredentials("YOUR_USERNAME_FOR_THE_DOC_CONVERSION_SERVICE","YOUR_PASSWORD");

	
	/*
	
	With proper permissions you can create a config like and just pass in the
	file name or nothing at all. 
	The code below creates a configuration json file.

	$configContent = '{"conversion_target":"answer_units"}';
	$configFileName = 'config.json';
	$configFile = fopen($configFileName,'w+');
	fwrite($configFile, $configContent);
	fclose($configFile);

	$configFilePath = realpath('./' . $configFileName);

	*/

	//These are two require files to convert the document. The first is information about the
	//results of the conversion. The second is the file that is being converted.
	//Using answer_units and pdf returns a json file.
	//File limitations and rules are included in the actual function call or on the IBM Bluemix website.
	$configFilePath = realpath('./config.json');
	$uploadedFilePath = realpath('./sample.pdf');
		
	$version = date('Y-m-d');//Version must be following YYYY-MM-DD format.

	$result = $documentConversionObj->convert($configFilePath, $uploadedFilePath, $version);

	echo var_dump($result);

	
?>