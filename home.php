<?php

require 'ackroo.php';
require 'defs.php';
session_start();

// if they posted the form with the shop name
if ($_SERVER['REQUEST_METHOD']== "POST") {

	$sc = new AckrooClient($api, $_SESSION['access_token'], $app_id, $secret);

    try
    {
        // Get all products
        $result = $sc->call('GET', 'cardholder/root');
    }
    catch (AckrooApiException $e)
    {
        /* 
         $e->getMethod() -> http method (GET, POST, PUT, DELETE)
         $e->getPath() -> path of failing request
         $e->getResponseHeaders() -> actually response headers from failing request
         $e->getResponse() -> curl response object
         $e->getParams() -> optional data that may have been passed that caused the failure

        */
        echo implode(' ', $e->getResponse());
        exit;
    }
    catch (AckrooCurlException $e)
    {
        echo implode(' ', $e->getMessage()); // returns value of curl_errno() and $e->getCode() returns value of curl_ error()
        exit;
    }

	?>
		<p style="padding-bottom: 1em;">
			<span class="hint">Application installed successfully. You now have an OAuth Access token </span>
		</p> 
		<p> 
			<span class="hint"><?php echo $result; ?> </span>
		</p> 
	<?php	
	exit;
}

// first time to the page, show the form below
?>

<p style="padding-bottom: 1em;">
	<span class="hint">Application installed successfully. You now have an OAuth Access token </span>
</p> 

<form action="/api_client/home.php" method="post">
	<p> 
		<input id="api" name="commit" type="submit" value="Test API" /> 
	</p> 
</form>
