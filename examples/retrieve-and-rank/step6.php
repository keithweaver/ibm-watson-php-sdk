<?php
	/*
	 * In step 7, there's actually no PHP code. You are using the file train.py to
	 * train a ranker (the python code will create it) with cranfield-gt.csv. This
	 * is the train data file, there are rules associated with it, that can be 
	 * found online at the IBM site.
	 *
	 * Open your terminal and run:
	 *  python ./train.py -u {username}:{password} -i {/path_to_file}/cranfield-gt.csv -c {solr_cluster_id} -x example_collection -n "example_ranker"
	 *
	 
	My query was and wont work for you: 

	python ./train.py -u ea7df130-724c-4074-8add-e5e753c19acb:sTRQVp3Bd6NZ -i ./cranfield-gt.csv -c sc9a0b6b6d_bc72_43e8_acfd_99ad14267e59 -x ExampleCollectionName -n "example_ranker"

	// Output

	Input file is ./cranfield-gt.csv
	Solr cluster is sc9a0b6b6d_bc72_43e8_acfd_99ad14267e59
	Solr collection is ExampleCollectionName
	Ranker name is example_ranker
	Rows per query 10
	Generating training data...
	Generating training data complete.
	  % Total    % Received % Xferd  Average Speed   Time    Time     Time  Current
	                                 Dload  Upload   Total   Spent    Left  Speed
	100  304k    0   319  100  304k     93  91206  0:00:03  0:00:03 --:--:-- 91221
	{"ranker_id":"1eec74x28-rank-1000","name":"example_ranker","created":"2017-02-22T02:44:25.697Z","url":"https://gateway.watsonplatform.net/retrieve-and-rank/api/v1/rankers/1eec74x28-rank-1000","status":"Training","status_description":"The ranker instance is in its training phase, not yet ready to accept rank requests"}

	 */
?>