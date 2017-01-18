# unofficial-ibm-watson-php-sdk

## Installing Using Composer

```
composer require kweaver00/watson_php
```

## Natural Language Example

```
require_once "/vendor/autoload.php";

$naturalLangObj = new \Kweaver\Watson\NaturalLanguageClassifier();
$naturalLangObj->setServiceCredentials("YOUR_WATSON_SERVICE_CREDENTIALS_USER_NAME","YOUR_WATSON_SERVICE_CREDENTIALS_PASSWORD");

$localFilePathForTrainingMetaDataJSON = realpath("./new_training_data_meta_data.json");


```

