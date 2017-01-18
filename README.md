# unofficial-ibm-watson-php-sdk

## Installing Using Composer

```
composer require kweaver00/watson_php
```

## Natural Language Classifier

### Creating A New Object

```
$naturalLangObj = new \Kweaver\Watson\NaturalLanguageClassifier();
```

### API Methods

**[Create classifier](https://www.ibm.com/watson/developercloud/natural-language-classifier/api/v1/#create_classifier)** - Sends data to create and train a classifier and returns information about the new classifier.



### Example
```
require_once "/vendor/autoload.php";

$naturalLangObj = new \Kweaver\Watson\NaturalLanguageClassifier();
$naturalLangObj->setServiceCredentials("YOUR_WATSON_SERVICE_CREDENTIALS_USER_NAME","YOUR_WATSON_SERVICE_CREDENTIALS_PASSWORD");

$localFilePathForTrainingMetaDataJSON = realpath("./new_training_data_meta_data.json");
$localFilePathForTrainingData = realpath("./weather_data_train.csv");

//Creating a new classifier
$response = $naturalLangObj->create($localFilePathForTrainingData,$localFilePathForTrainingMetaDataJSON);
```

## Document Conversion Example

```
require_once "/vendor/autoload.php";

$documentConversionObj = new \Kweaver\Watson\DocumentConversion();
$documentConversionObj->setServiceCredentials("YOUR_USERNAME_FOR_THE_DOC_CONVERSION_SERVICE","YOUR_PASSWORD");

$configFilePath = realpath('./config.json');
$uploadedFilePath = realpath('./sample.pdf');

$version = date('Y-m-d');

$result = $documentConversionObj->convert($configFilePath, $uploadedFilePath, $version);
```
