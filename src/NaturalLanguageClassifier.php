<?php

namespace Kweaver\Watson;

class NaturalLanguageClassifier
{

    // @var string The Watson Bluemix Service user name credential for Natural Language Classifier to be used for requests.
    public static $username;

    // @var string The Watson Bluemix Service password credential for Natural Language Classifier to be used for requests.
    public static $password;

    
    // @var string The base URL for the Stripe API.
    public static $apiBase = 'https://gateway.watsonplatform.net/natural-language-classifier/api/v1/';

    const VERSION = '1.0.0';


    /**
     * Create a new NaturalLanguageClassifier Instance
     */
    public function __construct()
    {
    }

    /**
     * @return string The User Name and Password used for requests.
     */
    public static function getServiceCredentials()
    {
        return (self::$username) . ":" . (self::$password);
    }

    /**
     * @return string The User Name used for requests.
     */
    public static function getUserName()
    {
        return (self::$username);
    }

    /**
     * @return string The User Name used for requests.
     */
    public static function getPassword()
    {
        return (self::$password);
    }

    /**
     * Sets the User Name and Password to be used for requests.
     *
     * @param string $username
     * @param string $password
     */
    public static function setServiceCredentials($username, $password)
    {
        self::$username = $username;
        self::$password = $password;
    }

    /**
     * Used for testing
     *
     * @param string $phrase Phrase to return
     *
     * @return string Returns the phrase passed in
     */
    public function echoPhrase($phrase)
    {
        return $phrase;
    }

    /**
     * Create classifer
     * 
     * @param string filePathToTrainingData - File path to training data (csv)
     * @param string filePathToTrainingMetaData - File path to training metadata json file
     *
     * @return object Information about your new classifier. The most important part 
     *                of the response is the classifierId.
     */
    public function create($filePathToTrainingData, $filePathToTrainingMetaData){

        $data = array();

        $URL =  self::$apiBase . "/classifiers";
        
        //Used for PHP 5.5 and above
        $trainingDataFile = new \CURLFile($filePathToTrainingData, 'text/csv', 'training_data');
        $trainingDataMetaFile = new \CURLFile($filePathToTrainingMetaData, 'application/json', 'training_metadata');


        $post = array();
        $post['training_data'] = $trainingDataFile;
        $post['training_metadata'] = $trainingDataMetaFile;

        //Makes the call to the server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, self::$username . ":" . self::$password);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $headers = array('Accept: application/json','Content-Type: multipart/form-data');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $resp = curl_exec($ch);
        $results = json_decode($resp);

        $info = curl_getinfo($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        
        //If invalid response
        if($httpStatus != 200){
            
            $data['message'] = $info['description'];
            $data['errorCode'] = $info['code'];
            $data['success'] = false;
            $data['httpStatus'] = $httpStatus; 
            $data['results'] = $results;
            
            return $data;
        }
        

        //Creates a response object
        $data['classifierId'] = $results->classifier_id;
        $data['classifierName'] = $results->name;
        $data['classifierStatus'] = $results->status;
        $data['classifierStatusDescription'] = $results->status_description;
        $data['success'] = true;
        $data['message'] = "Success. Created new classifier.";

        return $data;
    }

    /**
     * Get a list of analyzers/classifiers that have previously
     * been created.
     *
     * @return object and inside of that is a list of analyzers
     */
    public function getAnalyzers(){
        $data = array();

        $URL =  self::$apiBase . "/classifiers";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, self::$username . ":" . self::$password);
        $resp = curl_exec($ch);
        $results = json_decode($resp);

        $info = curl_getinfo($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close ($ch);

        //If invalid response
        if($httpStatus != 200){
            
            $data['message'] = $info['description'];
            $data['errorCode'] = $info['code'];
            $data['success'] = false;
            $data['httpStatus'] = $httpStatus; 
            $data['results'] = $results;
            
            return $data;
        }
        

        //Creates the response
        $data['classifiers'] = $results->classifiers;
        $data['success'] = true;
        $data['message'] = "Listed the classifiers that have been created.";

        return $data;
    }

    /**
     * Get information about the classifier based on
     * the identifier.
     *
     * 
     *
     */
    public function getInfo($classiferId){
        
        $data = array();

        $URL =  self::$apiBase . "/classifiers/" . $classiferId;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, self::$username . ":" . self::$password);
        $resp = curl_exec($ch);
        $results = json_decode($resp);

        $info = curl_getinfo($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close ($ch);

        if($httpStatus != 200){
            
            $data['message'] = $info['description'];
            $data['errorCode'] = $info['code'];
            $data['success'] = false;
            $data['httpStatus'] = $httpStatus; 
            $data['results'] = $results;
            
            return $data;
        }
        
        $classifier = array();
        $classifier['id'] = $results->classifier_id;
        $classifier['name'] = $results->name;
        $classifier['language'] = $results->language;
        $classifier['created'] = $results->created;

        $data['classifier'] = $classifier;
        $data['success'] = true;
        $data['message'] = "Successfully loaded classifier information.";

        return $data;
    }

    public function delete($classifierId){
        
        $data = array();

        $URL =  self::$apiBase . "/classifiers/" . $classiferId;

        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL,$URL);
        //curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $headers = array('Accept: application/json','Content-Type: multipart/form-data');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, self::$username . ":" . self::$password);
        
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $resp = curl_exec($ch);
        $results = json_decode($resp);

        $info = curl_getinfo($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close ($ch);

        if($httpStatus != 200){
            
            $data['message'] = $info['description'];
            $data['errorCode'] = $info['code'];
            $data['success'] = false;
            $data['httpStatus'] = $httpStatus; 
            $data['results'] = $results;
            
            return $data;
        }

        $data['success'] = true;
        $data['message'] = "Removed " . $classifierId;

        return $data;
    }

    public function analyze($classifierId, $query){
        $data = array();

        $URL =  self::$apiBase . "/classifiers/" . $classifierId . "/classify";
        
        

        $post = array();
        $post['text'] = $query;
        $data_strings = json_encode($post);
        

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, self::$username . ":" . self::$password);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_strings);
        $headers = array('Accept: application/json','Content-Type: application/json');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt ($ch, CURLOPT_SAFE_UPLOAD, false);
        $resp = curl_exec($ch);
        $results = json_decode($resp);

        $info = curl_getinfo($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close ($ch);
        
        if($httpStatus != 200){
            
            $data['message'] = $info['description'];
            $data['errorCode'] = $info['code'];
            $data['success'] = false;
            $data['httpStatus'] = $httpStatus; 
            $data['results'] = $results;
            
            return $data;
        }
        

        $cs = array();
        foreach ($results->classes as $class) {
            $c = array();
            $c["name"] = $class->class_name;
            $c["confidence"] = $class->confidence;
            array_push($cs, $c);
        }

        $data['classes'] = $cs;
        $data['top_class'] = $results->top_class;
        $data['success'] = true;
        $data['message'] = "Success. Created new classifier.";

        return $data;
    }

}