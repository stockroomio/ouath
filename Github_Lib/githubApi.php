<?php
/*
 * 9lessons Programming Blog www.9lessons.info
 * Author : Arun Kumar Sekar (email : arunkumarsekar@hotmail.com)
 * Objective : To authendicate with GITHUB and get user details
 */

error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);

class githubApi {
	
	
	private $client_id = '';
	private $client_secret = '';
	private $redirect_url = '';
	private $app_name = '';
	
	public $auth_base = 'https://github.com/';
	public $api_base = 'https://api.github.com/';
	public $git_code = '';
	/*
	 * Variable declaration for future use
	 */
	private $result = array();
	private $user = array();
	
	public function __construct($config) {
		if(is_array($config)){
			$this->client_id = $config['client_id'];
			$this->client_secret = $config['client_secret'];
			$this->redirect_url = $config['redirect_url'];
			$this->app_name = str_replace(' ','-',$config['app_name']);
			
			$this->git_code = $_GET['code'];
			
			$this->sendAccessTokenReq();
			
		} else
			die('Invalid configuration..!');
	}
	
	private function parseResponse($response) {
		$content = '';
		$status = 200;
		$header = true;
		$limit = 0;
		$remining = 0;
		if(!empty($response)){
			foreach(explode("\r\n", $response) as $line){
			 	if ($line == '') {
					$header = false;
				}
				else if ($header) {
					$line = explode(': ', $line);
					switch($line[0]) {
						case 'Status': $status = substr($line[1], 0, 3); break;
						case 'X-RateLimit-Limit': $limit = intval($line[1]); break;
						case 'X-RateLimit-Remaining': $remining = intval($line[1]); break;
					}
				} else {
					$content[] = $line;
				}
			}
			return array($status, json_decode(implode("\n", $content)));
		}
		
	}
	
	private function sendRequest($config, $debug=false){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if($config['header'] and is_array($config['header'])) {
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $config['header']);
		}
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		if($config['method'] == 'POST' and !empty($config['data'])){
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $config['data']);
		} else {
			curl_setopt($ch, CURLOPT_HTTPGET, true);
		}
		curl_setopt($ch, CURLOPT_URL, $config['url']);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		if($debug) var_dump($response);
		return $this->parseResponse($response);
	}
	
	private function sendAccessTokenReq(){
		$config = array('method' => 'POST',
						'data' => $this->buildParams(),
						'header' => array("Content-Type: application/x-www-form-urlencoded","Accept: application/json"),
						'url' => $this->auth_base.'login/oauth/access_token');
		$this->result = $this->sendRequest($config);
	}
	
	private function buildParams(){
		return http_build_query(array(
		         'client_id' => $this->client_id ,
		         'redirect_uri' => $this->redirect_url ,
		         'client_secret' => $this->client_secret,
		         'code' => $this->git_code
		     ));
	}
	
	public function getAccessToken(){
		return $this->result[1]->access_token;
	}
	
	public function getStatusCode(){
		return $this->result[0];
	}
	
	public function getTokenType(){
		return $this->result[1]->token_type;
	}
	
	public function getScope(){
		return $this->result[1]->scope;
	}
	
	private function sendUserDetailsReq() {
		$config = array('method' => 'GET',
						'header' => array("Content-Type: application/x-www-form-urlencoded",
										  "Accept: application/json",
										  "User-Agent: ".$this->app_name),
						'url' => $this->api_base.'user?access_token='.$this->getAccessToken());
		$this->user = $this->sendRequest($config);
	}
	
	public function getUserDetails() {
		$this->sendUserDetailsReq();
	}
	
	public function getAllUserDetails() {
		return $this->user[1];
	}
	
	public function userData($key){
		return $this->user[1]->$key;
	}
	
}
?>