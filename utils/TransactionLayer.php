<?php

	include_once "api/read.php";
	include_once 'api/update.php';
	include_once 'api/create.php';
	include_once 'api/delete.php';
	include_once 'parser.php';

	class TransactionLayer {

		private static $inst = null;
		private $conn;


		public static function instance() {

			if(self::$inst == null) {
				self::$inst = new TransactionLayer();
			}

			return self::$inst;
		}


		private function __construct() {

			$this->conn = new PDO('mysql:host=localhost;dbname=menu;', 'root', '');

		}


		public function post_query($cmd_args) {

			$args = args_parser($cmd_args);
			$query_result = null;

			if(array_key_exists('-read', $args)) {

				$params_select = $args['-read'];
				$params_match = array_key_exists('-match', $args) ? $args['-match'] : null;
				$read_query = new Read($this->conn);
				$query_result = $read_query->query_db($params_select, $params_match);
				return json_encode($query_result);

			} elseif(array_key_exists('-create', $args)) {

				$params_create = $args['-create'];
				$create_query = new Create($this->conn);
				$query_result = $create_query->query_db($params_create);
				return $query_result;

			} elseif(array_key_exists('-update', $args)) {

				$params_update = $args['-update'];
				$params_match = array_key_exists('-match', $args) ? $args['-match'] : null;
				$update_query = new Update($this->conn);
				print_r($params_update);
				print_r($params_match);
				$query_result = $update_query->query_db($params_update, $params_match);
				return $query_result;

			} elseif(array_key_exists('-delete', $args)) {

				$params_match = array_key_exists('-match', $args) ? $args['-match'] : null;
				$delete_query = new Delete($this->conn);
				$query_result = $delete_query->query_db($params_match);
				return $query_result;

			} elseif(array_key_exists('-search', $args)) {

				$params_select = array();
				$params_match = array_key_exists('-match', $args) ? $args['-match'] : null;
				$read_query = new Read($this->conn);
				$query_result = $read_query->query_db($params_select, $params_match);
				printf('There are '.sizeof($query_result).' entries in the database that match your requirements');
				exit(0);

			}

		}

	}