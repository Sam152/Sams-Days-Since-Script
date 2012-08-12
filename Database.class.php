<?php

/*
 * @filedoc
 * A simple class used to connect to and query the database.
 * Currently this class has known bugs and cannot be trusted.
 */

class Database{

	private $connection;
	private $db_user;
	private $db_host;
	private $db_password;
	private $last_query;

	/**
	 * Connect to the database.
	 */
	function __construct($db_details){
			
		//Create a PHP connection resource
		$this->connection = mysql_connect(
			$db_details['host'],
			$db_details['user'],
			$db_details['password']
		);
		
		mysql_select_db($db_details['database'],$this->connection);

	}
	
	/**
	 * Query the database.
	 */
	function query($query,$variables){
		
		//Loop through all of the variables we are using in the query
		foreach($variables as $search_string => $unsafe_replacement){

			//Make the variables we are using safe from MySQL injection
			$safe_replacement = mysql_real_escape_string($unsafe_replacement);

			//Substitute them into the query
			$query = str_replace($search_string,$safe_replacement,$query);
		}
		
		//ASSERT we have a safe query in the $query variable
		$this->last_query = $query;

		//Query the database
		$result = mysql_query($query, $this->connection);
		
		if(!$result)
			print('<div class="error">Error: '.mysql_error().'<br/>'.$query.'</div>');
		
		//Return the result of the query to the user
		return $result;

	}
	
	/**
	 * Get the last ID.
	 */
	function lastId(){
		return mysql_insert_id($this->connection);
	}
	
	/**
	 * Return the value of any property in this class private or otherwise.
	 */
	function getProperty($name){
		return $this->{$name};
	}

}
