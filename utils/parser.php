<?php

	function args_parser($argv) {

		$args = array();
		$arg_values = array();
		$last_arg = null;

		unset($argv[0]);

		foreach($argv as $arg) {

			if(preg_match('/^-/', $arg)) {

				$last_arg = $arg;
				$arg_values = array();
				$args[$last_arg] = $arg_values;


			} else {

				if(preg_match('/=/', $arg)) {

					$tmp_values = explode('=', $arg);
					$args[$last_arg][$tmp_values[0]] = $tmp_values[1];

				} else {

					array_push($args[$last_arg], $arg);

				}


			}

		}

		check_repeat($args);
		check_exclusive($args);

		return $args;

	}

	function check_repeat($args) {

		$tmp_array = array();
		foreach(array_keys($args) as $key) {

			if(!array_key_exists($key, $tmp_array))

				$tmp_array[$key] = 1;

			else {

				print("Error: Each argument can be passed only once!");
				exit(1);
			}

		}

	}

	function check_exclusive($args) {

		$tmp_array = array();
		foreach(array_keys($args) as $key) {

			if($key == '-create' || $key == '-read' || $key == '-update' || $key == '-delete' || $key == '-search')
				array_push($tmp_array, $key);

		}

		if(sizeof($tmp_array) > 1) {

			print("Error: only one of the arguments -create, -read, -update, -delete or -search must be passed to the script!");
			exit(1);

		}elseif(sizeof($tmp_array) < 1){

			print("Error: one of the arguments -create, -read, -update, -delete or -search must be passed to the script!");
			exit(1);

		}

	}