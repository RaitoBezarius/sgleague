<?php

function validCaptcha($form_captcha) 
{
	global $CONFIG_recaptcha_private;

	try
	{
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$data = ['secret'   => $CONFIG_recaptcha_private,
			'response' => $form_captcha,
			'remoteip' => $_SERVER['REMOTE_ADDR']];

		$options = [
			'http' => [
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data) 
				]
			];

		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		return json_decode($result)->success;
	}
	catch (Exception $e)
	{
		return null;
	}
}

?>