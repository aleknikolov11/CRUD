<?php

	class Delete {

		private $conn;


		function __construct($conn) {

			$this->conn = $conn;
		}


		function query_db($params_match = null) {

			// Create SQL query
			$query = 'DELETE FROM menu';

			if($params_match != null) {

				// Add parameters to SQL query in the order they are submitted
				$query .= ' WHERE '.key($params_match).' = :'.key($params_match);
				next($params_match);
				while(key($params_match) != null) {

					$query .= ' AND '.key($params_match).' = :'.key($params_match);
					next($params_match);

				}

			}

			$query .= ';';

			// Build prepared statement
			$stmt = $this->conn->prepare($query);

				if($params_match != null) {

				// Bind values to query parameters
				foreach($params_match as $key => $value) {

					$stmt->bindValue(':'.$key, $value);

				}

			}

			// Execute statement
			if(!$stmt->execute()) {

				// Throw error info
				print_r('$s.\n', $stmt->errorInfo());
				exit(1);

			} else {

				// Return result
				echo("Delete successfull! </br>");
				return True;

			}


		}

	}