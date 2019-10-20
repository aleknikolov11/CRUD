<?php

	class Create {

		private $conn;


		function __construct($conn) {

			$this->conn = $conn;

		}

		function query_db($query_params) {

			// Create INSERT SQL query
			$query = 'INSERT INTO menu ('.join(', ', array_keys($query_params)).') VALUES (:'.join(', :', array_keys($query_params)).');';

			print($query);
			// Build prepared statement
			$stmt = $this->conn->prepare($query);

			// Bind values to query parameters
			foreach($query_params as $key => $value) {

				$stmt->bindParam(':'.$key, $value);

			}

			// Execute statement
			if(!$stmt->execute()) {

				// Throw error info
				print_r($stmt->errorInfo());
				exit(1);

			} else {

				// Return result
				echo("Create successfull! </br>");
				return True;

			}
		}
	}