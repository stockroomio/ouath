<?php
session_start();
error_reporting(-1);
ini_set('display_errors','On');
/*
 * login_with_bitbucket.php
 *
 * @(#) $Id: login_with_bitbucket.php,v 1.2 2013/07/31 11:48:04 mlemos Exp $
 *
 */

	/*
	 *  Get the http.php file from http://www.phpclasses.org/httpclient
	 */
	require('http.php');
	require('oauth_client.php');

	$client = new oauth_client_class;
	$client->debug = false;
	$client->debug_http = true;
	$client->server = 'Bitbucket';
	$client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].
		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/login_with_bitbucket.php';

	$client->client_id = 'QAQVNNRpLgybFALWfv'; 
	$application_line = __LINE__;
	$client->client_secret = 's2jx3kFJHSFfPTYQvnXVxHCVgTYH7Ypq';

	if(strlen($client->client_id) == 0
	|| strlen($client->client_secret) == 0)
		die('Please go to Bitbucket page to Manage Account '.
			'https://bitbucket.org/account/ , click on Integrated Applications, '.
			'then Add Consumer, and in the line '.$application_line.
			' set the client_id with Key and client_secret with Secret. '.
			'The URL must be '.$client->redirect_uri);

	if(($success = $client->Initialize()))
	{
		if(($success = $client->Process()))
		{
			if(strlen($client->access_token))
			{
				$success = $client->CallAPI(
					'https://api.bitbucket.org/1.0/user', 
					'GET', array(), array('FailOnAccessError'=>true), $user);
			}
		}
		$success = $client->Finalize($success);
	}
	if($client->exit)
		exit;
	if($success)
	{
?>

<?php
		// $url = "https://api.bitbucket.org/2.0/users/paul/followers";
		// $json=json_decode(file_get_contents($url), true);
		// echo $json->size;
		// echo '<h1>', HtmlSpecialChars($user->user->first_name), 
		// 	' you have logged in successfully with Bitbucket!</h1>';
		// echo '<pre>', HtmlSpecialChars(print_r($user, 1)), '</pre>';
		// $name = $user->user->first_name;
		// echo $name;
			echo json_encode($user);
?>
<?php
	}
	else
	{
?>

<pre>Error: <?php echo HtmlSpecialChars($client->error); ?></pre>
<?php
	}

?>