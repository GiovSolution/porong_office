<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter JsonCI Class
 *
 * This class contains functions that enable config files to be managed
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Wachid Asari
 * @link		http://wachid.zxq.net
 */
require "JSON.php";

class JsonCI extends Services_JSON 
{
	function sendJSONsuccess($responseText = "", $data_a = "")
	{
		$ajax_res = array(
		"responseText" => $responseText,
		"success" => "true",
		);

		if (is_array($data_a))
		$ajax_res = array_merge($ajax_res, $data_a);

		$this->sendJSON($ajax_res);
	}

	function sendJSONfailure($responseText = "", $data_a = "")
	{
		$ajax_res = array(
			"responseText" => $responseText,
			"success" => "false",
		);

		if (is_array($data_a))
			$ajax_res = array_merge($ajax_res, $data_a);

		$this->sendJSON($ajax_res);
	}

	function sendJSON($json_array)
	{
		if (function_exists('json_encode')){
			$json_str = json_encode($json_array);
		}
		else{
			$json_str = $this->encode($json_array);
		}

		header("Content-length: ". strlen($json_str));
		echo $json_str;
		exit;
	}

	function getStringJSON($json_array)
	{
		if (function_exists('json_encode')){
			$json_str = json_encode($json_array);
		}
		else{
			$json_str = $this->encode($json_array);
		}

		header("Content-length: ". strlen($json_str));
		echo $json_str;
	}
} 

// END JsonCI class
?>