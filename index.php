<?php

require 'ackroo.php';
require 'defs.php';
session_start();

if (isset($_SESSION['access_token'])) {
	if ($_SESSION['access_token'] != '') {
		header("Location: home.php");
		exit;
	}
}
if (isset($_GET['code'])) { // if the code param has been sent to this page... we are in Step 2
	// Step 2: do a form POST to get the access token
	$ackrooClient = new AckrooClient($oauth_provider, "", $app_id, $secret);
	session_unset();

	// Now, request the token and store it in your session.
	$_SESSION['access_token'] = $ackrooClient->getAccessToken($_GET['code'], $redirect_uri);

	header("Location: home.php");
	exit;       
}
// if they posted the form with the shop name
else if ($_SERVER['REQUEST_METHOD']== "POST") {

	// Step 1: redirect the user to the Ackroo authorization page where they can choose to authorize this app
	$ackrooClient = new AckrooClient($oauth_provider, "", $app_id, $secret);

	// redirect to authorize url
	header("Location: " . $ackrooClient->getAuthorizeUrl($scopes, $redirect_uri));
	exit;
}

// first time to the page, show the form below
?>
<p>Welcome to Ackroo API client demo application. Click below to start the API Authorization process.</p> 

<p style="padding-bottom: 1em;">
	<span class="hint">Don&rsquo;t have an ackroo developer account to install your application? 
		<a href=
			<?php echo $dev_portal; ?>
		>Create an ackroo application.</a></span>
</p> 

<form action="" method="post">
	<p> 
		<input name="commit" type="submit" value="Install" /> 
	</p> 
</form>
