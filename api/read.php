<?php
	
	class Read {

		private $conn;


		function __construct($conn) {

			$this->conn = $conn;
		}


		function query_db($params_select, $params_match = null) {

			// Create SQL query
			$query = 'SELECT ';
			if(sizeof($params_select) > 0)
				$query .= join(', ', $params_select).' FROM menu';
			else
				$query .= '* FROM menu';

			if($params_match != null) {
				// Add parameters to SQL query in the order they are submitted
				$query .= ' WHERE '.key($params_match).'=:'.key($params_match);
				next($params_match);
				while(key($params_match) != null) {

					$query .= ' AND '.key($params_match).'=:'.key($params_match);
					next($params_match);

				}

			}

			$query .= ';';

			// Build prepared statement
			$stmt = $this->conn->prepare($query);

			if($params_match != null) {

				// Bind values to query parameters
				foreach($params_match as $key => $value) {

					$stmt->bindParam(':'.$key, $value);

				}

			}
			// Execute statement
			if(!$stmt->execute()) {

				// Throw error info
				print("Error in SQL query: \n");
				print_r($stmt->errorInfo());
				exit(1);

			} else {

				// Return result from query
				$result = array();

				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

					array_push($result, $row);

				}

				return $result;

			}


		}

	}