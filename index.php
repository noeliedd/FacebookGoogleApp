<?php  
  error_reporting(E_ALL); 
  session_start();
  require_once("dbConnect.php");
  require_once('facebook/src/FacebookSession.php');
  require_once('facebook/src/FacebookRequest.php');
  require_once('facebook/src/FacebookResponse.php');
  require_once('facebook/src/FacebookSDKException.php');
  require_once('facebook/src/FacebookRequestException.php');
  require_once('facebook/src/FacebookRedirectLoginHelper.php');
  require_once('facebook/src/FacebookAuthorizationException.php');
  require_once('facebook/src/GraphObject.php');
  require_once('facebook/src/GraphUser.php');
  require_once('facebook/src/GraphLocation.php');  
  require_once('facebook/src/GraphSessionInfo.php');
  require_once('facebook/src/Entities/AccessToken.php');
  require_once('facebook/src/HttpClients/FacebookCurl.php');
  require_once('facebook/src/HttpClients/FacebookHttpable.php');
  require_once('facebook/src/HttpClients/FacebookCurlHttpClient.php');

  use facebook\FacebookSession;
  use facebook\FacebookRedirectLoginHelper;
  use facebook\FacebookRequest;
  use facebook\FacebookResponse;
  use facebook\FacebookSDKException;
  use facebook\FacebookRequestException;
  use facebook\FacebookAuthorizationException;
  use facebook\GraphObject;
  use facebook\GraphUser;
  use facebook\GraphLocation;
  use facebook\GraphSessionInfo;
  use facebook\FacebookHttpable;
  use facebook\FacebookHttpCurlClient;
  use facebook\FacebookCurl;

  $config = parse_ini_file('AWS_config.ini');
  $permissions = array(
    'email'
  );

  FacebookSession::setDefaultApplication($config['AWS_app_id'],$config['AWS_app_secret']);
  $helper = new FacebookRedirectLoginHelper($config['Nitrous_redirect_url']);
  $session = $helper->getSessionFromRedirect();

  if(isset($session)){  
  $_SESSION['fb_token'] = $session->getToken();
  header('Location: loggedIn.php');
  }
  if(isset($_SESSION['fb_token'])){
      $session = new FacebookSession($_SESSION['fb_token']);      
  }
  if(isset($_POST['submit']))
    {   
      if(isset($session)){
          //$session = new FacebookSession( $_SESSION['fb_token'] );
          $_SESSION['fb_token'] = $session->getToken();
          header('Location: loggedIn.php');
          }else{    
          $loginUrl = $helper->getLoginUrl($permissions);             
          header("Location: $loginUrl");
        }   
    }   
?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Cloud Mashup App</title>
		<meta name="description" content="Cloud Mashup Application">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js"></script>
		<link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="assets/css/custom.css" rel="stylesheet" type ="text/css">		    
	</head>   
  <body>
		<div class="navbar navbar-fixed-top navbar-inverse">
		  <div class="navbar-inner">
			<div class="container">
			  <a class="brand">Mashup App</a>
			  <div class="nav-collapse">
				<ul class="nav pull-right">
				  <li class="divider-vertical"></li>
				</ul>
			  </div>
			</div>
		  </div>
		</div>    
		<div class="container hero-unit">  
       <div id ="index-container">   
          <h2>Fitness Route Planner</h2> 
          <h3>A Mashup Application Combining Facebook and Google Maps </h3>
          <ul>
              <li>Login using your facebook credentials</li>
              <li>Your current location will be displayed</li>
              <li>You can click on the map to create a route</li>
              <li>The distance of the route you have selected will be displayed in kilometers</li>
          </ul>
          <br/><br/>
 		    	<form method ="POST">			
				   <button type="submit" name = "submit"class="btn btn-primary btn-sm">Login with Facebook</button>	
		    	</form> 
       </div>
	  </div>
	</body>
</html>
