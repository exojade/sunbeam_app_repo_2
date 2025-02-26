<?php
    ini_set("display_errors", true);
    error_reporting(E_ALL);

    require("constants.php");
    require("functions.php");
    require ('./vendor/autoload.php');
	
	date_default_timezone_set('Asia/Manila');
	
    session_start();



    if(isset($_SESSION["sunbeam_app"])){

        


        


        // // $clientID = '538691118774-50b5ak993tc510dlrmoishso1pi8qv2q.apps.googleusercontent.com';
        // // $clientSecret = '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';
        // // $redirectUri = 'http://hrmis-systems.com:7000/hrmis_system/google_login';
        // $scopes = array('https://www.googleapis.com/auth/calendar.events', // Google Calendar Events API scope
        // 'https://www.googleapis.com/auth/calendar', // Google Calendar API scope
        //  // Read-only access to Google Meet API
        // 'https://www.googleapis.com/auth/meetings',
        // );
        
        // $google = new Google_Client();
        
        // $google->setClientId(clientID);
        // $google->setClientSecret(clientSecret);
        // $google->setRedirectUri(redirectUri);
       
        // $google->setScopes($scopes);
        // $google->setAccessType('offline');
        // dump($google);
    }
	
   
	
?>