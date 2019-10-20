<?php
	
	class Update {

		private $conn;


		function __construct($conn) {

			$this->conn = $conn;

		}

		function query_db($params_update, $params_match = null) {

			// Create INSERT SQL query
			$query = 'UPDATE menu SET ';

			if(sizeof($params_update) > 0) {
				// Add parameters to SQL query in the order they are submitted
				$query .= key($params_update).'=:'.key($params_update).'_update';
				next($params_update);
				while(key($params_update) != null) {

					$query .= ', '.key($params_update).'=:'.key($params_update).'_update';
					next($params_update);

				}
			} else {

				print("Error: no parameters provided for UPDATE query");
				exit(1);
				
			}

			if($params_match != null) {

				$query .= ' WHERE '.key($params_match).'=:'.key($params_match);
				next($params_match);
				while(key($params_match) != null) {

					$query .= ' AND '.key($params_match).'=:'.key($params_match);
					next($params_match);
				}
			}

			$query .= ';';

			print($query);

			// Build prepared statement
			$stmt = $this->conn->prepare($query);

			// Bind values to query parameters
			foreach($params_update as $key_update => $value_update) {

				print_r(':'.$key_update.'_update, '.$value_update.' \n');
				$stmt->bindValue(':'.$key_update.'_update', $value_update);

			}

			foreach($params_match as $key_match => $value_match) {

				$stmt->bindValue(':'.$key_match, $value_match);

			}

			// Execute statement
			if(!$stmt->execute()) {

				// Throw error info
				print_r($stmt->errorInfo());
				exit(1);

			} else {

				// Return result
				echo("Update successfull! </br>");
				return True;

			}
		}

	}