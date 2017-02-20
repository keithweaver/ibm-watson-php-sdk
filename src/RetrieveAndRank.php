<?php
/*
1. Create Cluster
2. Check cluster status
3. Upload (.zip) configuration
4. Create collection
5. Add documents (.json)
6. create ranker (not recommended use)
*/
namespace Kweaver\Watson;

class RetrieveAndRank
{

    // @var string The Watson Bluemix Service user name credential for Natural Language Classifier to be used for requests.
    public static $username;

    // @var string The Watson Bluemix Service password credential for Natural Language Classifier to be used for requests.
    public static $password;

    
    // @var string The base URL for the Stripe API.
    public static $apiBase = 'https://gateway.watsonplatform.net/retrieve-and-rank/api/v1/';

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
     * Tutorial Related
     */
    public function createCluster($clusterName, $clusterSize){
        $data = array();

        $URL =  self::$apiBase . "solr_clusters";


        $post = array();
        $post['cluster_size'] = $clusterSize;
        $post['cluster_name'] = $clusterName;
                
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
        $data['message'] = "Success. Cluster created";
        $data['results'] = $results;
        return $data;
    }
    //Verify Cluster
    public function getCluster($clusterId){
        $data = array();

        $URL =  self::$apiBase . "solr_clusters/" . $clusterId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
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
                        
            return $data;
        }
        


        $data['success'] = true;
        $data['message'] = "Success. Cluster " . $clusterId . " info returned.";
        $data['results'] = $results;
        return $data;
    }
    public function uploadSolrConfiguration($clusterId, $realpathToConfigZip){
        $data = array();

        $URL =  self::$apiBase . "solr_clusters/" . $clusterId . "/config/" . basename($realpathToConfigZip);

        $zipFile = new \CURLFile($realpathToConfigZip, 'application/zip', '@');

        $post = array();
        $post['@'] = $zipFile;

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


        if($httpStatus != 200){         
            $data['message'] = $info['description'];
            $data['errorCode'] = $info['code'];
            $data['success'] = false;
            $data['httpStatus'] = $httpStatus; 
                        
            return $data;
        }
                


        $data['success'] = true;
        $data['message'] = "Success. Uploaded Solr Configuration for " . $clusterId . ".";
        $data['results'] = $results;
        return $data;
    }
    public function createCollection($clusterId, $collectionName, $configurationName){
        $data = array();

        $URL =  self::$apiBase . "solr_clusters/" . $clusterId . "/solr/admin/collections";

        $post = array();
        $post['action'] = 'CREATE';
        $post['name'] = $collectionName;
        $post['collection.configName'] = $configurationName;
        $post['wt'] = 'json';

        $data_strings = json_encode($post);
        $URL .= '?action=CREATE&name=' . $collectionName . '&collection.configName=' . $configurationName . '&wt=json';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, self::$username . ":" . self::$password);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_strings);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_strings)
        ));

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
                        
            return $data;
        }
                


        $data['success'] = true;
        $data['message'] = "Success. Created collection.";
        $data['results'] = $results;
        return $data;
    }
    public function uploadDataJSON($clusterId, $collectionName, $realpathToDataJSON){
        $data = array();

        $URL =  self::$apiBase . "solr_clusters/" . $clusterId . "/solr/" . $collectionName . "/update";

        $dataJSON = new \CURLFile($realpathToDataJSON, 'application/json', '@');

        $post = array();
        $post['body'] = $dataJSON;
        $post['solr_cluster_id'] = $clusterId;
        $collection_name['collection_name'] = $collectionName;

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

        if($httpStatus != 200){         
            $data['message'] = $info['description'];
            $data['errorCode'] = $info['code'];
            $data['success'] = false;
            $data['httpStatus'] = $httpStatus; 
                        
            return $data;
        }
                


        $data['success'] = true;
        $data['message'] = "Success. Uploaded Solr Configuration for " . $clusterId . ".";
        $data['results'] = $results;
        return $data;
    }
    public function searchAndRank($clusterId, $collectionName, $rankerId, $query){
        $query = rawurlencode($query);

        $URL =  self::$apiBase . "solr_clusters/" . $clusterId . "/solr/" . $collectionName . "/select";

        $post = array();
        $post['solr_cluster_id'] = $clusterId;
        $post['name'] = $collectionName;
        $post['q'] = $query;
        $post['wt'] = 'json';
        $post['rankerId'] = $rankerId;

        $URL .= '?solr_cluster_id=' . $post['solr_cluster_id'] . '&name=' . $post['name'] . '&q=' . $post['q'] . '&wt=' . $post['wt'] . '&ranker_id=' . $rankerId;

        $data_strings = json_encode($post);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, self::$username . ":" . self::$password);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_strings);
        $resp = curl_exec($ch);
        $results = json_decode($resp);
        curl_close ($ch);

        if($httpStatus != 200){         
            $data['message'] = $info['description'];
            $data['errorCode'] = $info['code'];
            $data['success'] = false;
            $data['httpStatus'] = $httpStatus; 
                        
            return $data;
        }
                


        $data['success'] = true;
        $data['message'] = "Success. Search and rank.";
        $data['results'] = $results;
        return $data;
    }
    /*
     * Non-Tutorial Related
     */
    public function createRanker($clusterId, $rankerName, $realpathToTrainingData, $realpathToTrainingMetaDatas){
        //cranfield-gt.csv is a list of training questions
        //
        //Layout of this csv file:
        //Question   id1 id2 id3
        //Question2  id3
        //
        //id1, id2, id3 are document id files.
        //Dont include ? on the end of the questions
        //
        //Training data has to be prepped: https://www.ibm.com/watson/developercloud/doc/retrieve-rank/training_data.shtml#manual
        //
        //The create ranker API expects a comma-separated-value (CSV) 
        //training-data file with feature vectors. 
        //Each feature vector represents a query-candidate answer pair 
        //and occupies a single row in the file. 
        //
        //The first column ofevery row in the file is the query ID used
        // to group together all of the candidate-answer feature vectors
        // associated with a single query.
        //
        //The last column in the file is the ground-truth label (also 
        //called the relevance label), which indicates how relevant 
        //that candidate answer is to the query. The remaining columns
        // are various features used to score the match between the 
        //query and the candidate answer. 
        //
        //query_id, feature1, feature2, feature3,...,ground_truth
        //question_id_1, 0.0, 3.4, -900,...,0
        //question_id_1, 0.5, -70, 0,...,1
        //
        // Rules for the training data:
        // - The file must contain at least 49 unique questions.
        // - The number of feature vectors (that is, rows in your
        //      CSV training-data file) must be 10 times the number
        //      of features (that is, feature columns) in each row.
        // - The relevance label must be a non-negative integer
        // - At least two different relevance labels must exist in the data
        // - At least 25% of the questions must have some label variety
        //       in the answer set. That is, all of the candidate answers 
        //       for a single question cannot be labeled with a single 
        //       relevance level.
        // - The relevance value zero (0) has specific implications when 
        //      training a ranker. Any documents labeled 0 are considered 
        //      totally irrelevant to the question. That being said, the 
        //      training data must contain some zero-labeled documents to 
        //      strengthen the system's ability to search for relevant labels.
        //
        // Create gt_train.csv and gt_test.csv, 70% and 30% split
        //
        //How is proctitis diagnosed?,a605c109–07c5–4670–9b21–3b52fe01a53f,1
        //
        // cranfield-gt.csv is an example training questions

        $URL =  self::$apiBase . "rankers";

        $trainingFile = new \CURLFile($realpathToTrainingData, 'text/csv', 'training_data');
        $trainingMetaFile = new \CURLFile($realpathToTrainingMetaDatas, 'application/json', 'training_metadata');

        $post = array();
        $post['training_data'] = $trainingFile;
        $post['training_metadata'] = $trainingMetaFile;

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
        curl_close ($ch);

        if($httpStatus != 200){         
            $data['message'] = $info['description'];
            $data['errorCode'] = $info['code'];
            $data['success'] = false;
            $data['httpStatus'] = $httpStatus; 
                        
            return $data;
        }
                


        $data['success'] = true;
        $data['message'] = "Success. Created ranker.";
        $data['results'] = $results;
        return $data;
    }
    public function deleteCollection(){
        $query = rawurlencode($query);

        $URL =  self::$apiBase . "solr_clusters/" . $clusterId . "/solr/" . $collectionName . "/select";

        $post = array();
        $post['solr_cluster_id'] = $clusterId;
        $post['name'] = $collectionName;
        $post['q'] = $query;
        $post['wt'] = 'json';
        $post['rankerId'] = $rankerId;

        $URL .= '?solr_cluster_id=' . $post['solr_cluster_id'] . '&name=' . $post['name'] . '&q=' . $post['q'] . '&wt=' . $post['wt'] . '&ranker_id=' . $rankerId;

        $data_strings = json_encode($post);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, self::$username . ":" . self::$password);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_strings);
        $resp = curl_exec($ch);
        $results = json_decode($resp);
        curl_close ($ch);

        if($httpStatus != 200){         
            $data['message'] = $info['description'];
            $data['errorCode'] = $info['code'];
            $data['success'] = false;
            $data['httpStatus'] = $httpStatus; 
                        
            return $data;
        }
                


        $data['success'] = true;
        $data['message'] = "Success. Search and rank.";
        $data['results'] = $results;
        return $data;
    }
    public function deleteRanker($rankerId){
        $query = rawurlencode($query);

        $URL =  self::$apiBase . "rankers/" . $rankerId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, self::$username . ":" . self::$password);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $resp = curl_exec($ch);
        $results = json_decode($resp);
        curl_close ($ch);

        if($httpStatus != 200){         
            $data['message'] = $info['description'];
            $data['errorCode'] = $info['code'];
            $data['success'] = false;
            $data['httpStatus'] = $httpStatus; 
                        
            return $data;
        }
                


        $data['success'] = true;
        $data['message'] = "Success. Search and rank.";
        $data['results'] = $results;
        return $data;
    }
    public function getSolrConfiguration($clusterId, $configurationName){
        $URL =  self::$apiBase . "solr_clusters/" . $clusterId . "/config/" . $configurationName;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, self::$username . ":" . self::$password);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/zip'));
        $resp = curl_exec($ch);
        $results = json_decode($resp);
        curl_close ($ch);

        if($httpStatus != 200){         
            $data['message'] = $info['description'];
            $data['errorCode'] = $info['code'];
            $data['success'] = false;
            $data['httpStatus'] = $httpStatus; 
                        
            return $data;
        }
                


        $data['success'] = true;
        $data['message'] = "Success. Search and rank.";
        $data['results'] = $results;
        return $data;
    }
    public function getRanker($rankerId){
        $URL =  self::$apiBase . "rankers/" . $rankerId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, self::$username . ":" . self::$password);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $resp = curl_exec($ch);
        $results = json_decode($resp);
        curl_close ($ch);
        
        if($httpStatus != 200){         
            $data['message'] = $info['description'];
            $data['errorCode'] = $info['code'];
            $data['success'] = false;
            $data['httpStatus'] = $httpStatus; 
                        
            return $data;
        }
                


        $data['success'] = true;
        $data['message'] = "Success. Search and rank.";
        $data['results'] = $results;
        return $data;
    }
    public function getAllCollections($clusterId){
        $URL =  self::$apiBase . "solr_clusters/" . $clusterId . "/solr/admin/collections?action=LIST&wt=json";

        $post = array();
        $post['action'] = 'LIST';
        $post['wt'] = 'json';

        $data_strings = json_encode($post);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, self::$username . ":" . self::$password);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_strings);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_strings)));
        $resp = curl_exec($ch);
        $results = json_decode($resp);
        curl_close ($ch);
        
        if($httpStatus != 200){         
            $data['message'] = $info['description'];
            $data['errorCode'] = $info['code'];
            $data['success'] = false;
            $data['httpStatus'] = $httpStatus; 
                        
            return $data;
        }
                


        $data['success'] = true;
        $data['message'] = "Success. Search and rank.";
        $data['results'] = $results;
        return $data;
    }
    public function getAllSolrConfigurations($clusterId){
        $URL =  self::$apiBase . "solr_clusters/" . $clusterId . "/config/";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, self::$username . ":" . self::$password);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $resp = curl_exec($ch);
        $results = json_decode($resp);
        curl_close ($ch);
        
        if($httpStatus != 200){         
            $data['message'] = $info['description'];
            $data['errorCode'] = $info['code'];
            $data['success'] = false;
            $data['httpStatus'] = $httpStatus; 
                        
            return $data;
        }
                


        $data['success'] = true;
        $data['message'] = "Success. Search and rank.";
        $data['results'] = $results;
        return $data;
    }
    public function getAllRankers(){
        $URL =  self::$apiBase . "rankers";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, self::$username . ":" . self::$password);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $resp = curl_exec($ch);
        $results = json_decode($resp);
        curl_close ($ch);
        
        if($httpStatus != 200){         
            $data['message'] = $info['description'];
            $data['errorCode'] = $info['code'];
            $data['success'] = false;
            $data['httpStatus'] = $httpStatus; 
                        
            return $data;
        }
                


        $data['success'] = true;
        $data['message'] = "Success. Search and rank.";
        $data['results'] = $results;
        return $data;
    }

}