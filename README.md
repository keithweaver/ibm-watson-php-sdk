# unofficial-ibm-watson-php-sdk


## Installing Using Composer

```
composer require kweaver00/watson_php
```


## Supported Services

[Natural Language Classifier](https://github.com/kweaver00/unofficial-ibm-watson-php-sdk#natural-language-classifier)

[Document Conversion](https://github.com/kweaver00/unofficial-ibm-watson-php-sdk#document-conversion-example)




## Natural Language Classifier

### Creating A New Object

```
$naturalLangObj = new \Kweaver\Watson\NaturalLanguageClassifier();
```


### API Methods

**[Create classifier](https://www.ibm.com/watson/developercloud/natural-language-classifier/api/v1/#create_classifier)** - Sends data to create and train a classifier and returns information about the new classifier.

**[List classifiers](https://www.ibm.com/watson/developercloud/natural-language-classifier/api/v1/#get_classifiers)** - Retrieves the list of classifiers for the service instance. Returns an empty array if no classifiers are available.

**[Get information about a classifier](https://www.ibm.com/watson/developercloud/natural-language-classifier/api/v1/#get_status)** - Returns status and other information about a classifier

**[Delete classifier](https://www.ibm.com/watson/developercloud/natural-language-classifier/api/v1/#delete_classifier)** - Deletes a classifier.

**[Classify](https://www.ibm.com/watson/developercloud/natural-language-classifier/api/v1/#classify)** - Returns label information for the input. The status must be "Available" before you can classify calls. Use the Get information about a classifier method to retrieve the status.


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

### Creating A New Object

```
$documentConversionObj = new \Kweaver\Watson\DocumentConversion();
```


### API Methods

**[Convert a document](https://www.ibm.com/watson/developercloud/document-conversion/api/v1/#convert-document)** - Converts a document to answer units, HTML or text. This method accepts a multipart/form-data request. Upload the document as the "file" form part and the configuration as the "config" form part.


### Example

```
require_once "/vendor/autoload.php";

$documentConversionObj = new \Kweaver\Watson\DocumentConversion();
$documentConversionObj->setServiceCredentials("YOUR_USERNAME_FOR_THE_DOC_CONVERSION_SERVICE","YOUR_PASSWORD");

$configFilePath = realpath('./config.json');
$uploadedFilePath = realpath('./sample.pdf');

$version = date('Y-m-d');

$result = $documentConversionObj->convert($configFilePath, $uploadedFilePath, $version);
```
