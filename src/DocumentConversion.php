<?php

namespace Kweaver\Watson;

class DocumentConversion
{

    // @var string The Watson Bluemix Service user name credential for Natural Language Classifier to be used for requests.
    public static $username;

    // @var string The Watson Bluemix Service password credential for Natural Language Classifier to be used for requests.
    public static $password;

    
    // @var string The base URL for the Stripe API.
    public static $apiBase = 'https://gateway.watsonplatform.net/document-conversion/api/v1/';

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

    /*
    success => true
    message => 
    */
    public function convert($filePathToConfigurationFile, $filePathToPDF, $version){
        /*
        ToDO:
        The release date of the version of the API you want to use. Specify dates in YYYY-MM-DD format.

        The file to convert. Maximum file size is 50 MB. The API detects the type, but you can specify it if incorrect. Acceptable MIME type values are text/html, text/xhtml+xml, application/pdf, application/msword, and application/vnd.openxmlformats-officedocument.wordprocessingml.document.

        A config part that identifies the output type. You can optionally include information to define tags and structure in the conversion output. Maximum size of the part is 1 MB.

        Valid values are answer_units, normalized_html, and normalized_text.
        */

        $data = array();


        if($version == ""){
            $version = date('Y-m-d');
        }

        $URL =  self::$apiBase . "convert_document?version=2015-12-15";
            
        $data['pdf'] = $filePathToPDF;
        $data['config'] = $filePathToConfigurationFile;

        //Used for PHP 5.5 and above
        $pdfFile = new \CURLFile($filePathToPDF, 'application/pdf', 'file');
        $configFile = new \CURLFile($filePathToConfigurationFile, 'application/json', 'config');


        $post = array();
        $post['file'] = $pdfFile;
        $post['config'] = $configFile;
        

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
        if($httpStatus != 200){
            
            $data['message'] = $info['description'];
            $data['errorCode'] = $info['code'];
            $data['success'] = false;
            $data['httpStatus'] = $httpStatus; 
            
            return $data;
        }
        


        $data['success'] = true;
        $data['message'] = "Success. Converted the document.";
        $data['results'] = $results;
        return $data;
    }
}