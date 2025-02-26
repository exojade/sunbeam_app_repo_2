<?php
// dump($_SESSION);
// require("includes/google_class.php"); 

use Google\Client;
use Google\Service\Calendar;
// $google->setAccessToken($_SESSION["sunbeam_app"]['accessToken']);
// $service = new Google_Service_Drive($google);
    if($_SERVER["REQUEST_METHOD"] === "POST") {

		if($_POST["action"] == "updatePaymentSchedule"):

			query("delete from payment_settings");
			query("insert INTO payment_settings (dueDate, installment_number) 
				VALUES(?,?)", 
				$_POST["dueDate"], $_POST["installment_number"]);


			$res_arr = [
				"result" => "success",
				"title" => "Success",
				"message" => "Updated Payment Schedule Successfully",
				"link" => "index",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();

		endif;


		if($_POST["action"] == "switchUser"):

			// dump($_POST);
			$user = query("select * from users where id = ?", $_POST["user"]);
			$user = $user[0];
			// dump($user);

			$_SESSION["sunbeam_app"] = [
				"userid" => $user["id"],
				"uname" => $user["username"],
				"role" => $user["role"],
				"fullname" => $user["fullname"],
				"profile_image" => "",
				"application" => "sunbeam_app"
			];


			$res_arr = [
				"result" => "success",
				"title" => "Success",
				"message" => "Switch Success",
				"link" => "index",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();

		endif;

		

	
    }
	else {
		
		// if(isset($_SESSION["sunbeam_app"]["accessToken"])):
		// 	// dump($google);
		// 	// $client = new Client();
		// 	// $client->addScope(Calendar::CALENDAR_EVENTS);
		// 	// $client->setAccessType('offline'); // Enables the refresh token
		// 	$google->setAccessToken($_SESSION["dnsc_geoanlytics"]['accessToken']['access_token']);
		// 	$service = new Calendar($google);
		// 	$events = $service->events->listEvents('primary');
		// 	try {
		// 		// Retrieve the list of meetings (Google Calendar events)
		// 		$events = $service->events->listEvents('primary', ['q' => 'meet.google.com']);
		// 		// Process the list of events
		// 		foreach ($events as $event) {
		// 			// Print or process each event
		// 			dump( 'Event ID: ' . $event->getId() . '<br>');
		// 			echo 'Summary: ' . $event->getSummary() . '<br>';
		// 			// Add more details as needed
		// 		}
		// 	} catch (Exception $e) {
		// 		dump('An error occurred: ' . $e->getMessage());
		// 	}
		// 	// dump($service);
		// endif;


		$role = $_SESSION["sunbeam_app"]["role"];
		// dump($role);
		if($role == "admin"){
			render("public/dashboard_system/dashboard_admin.php",[]);
		}
		else if($role == "student"){
			render("public/student_system/studentSpecific.php",[]);
		}
		else if($role == "cashier"){
			render("public/dashboard_system/dashboard_cashier.php",[]);
		}
		else if($role == "parent"){
			render("public/dashboard_system/dashboard_parent.php",[]);
		}
		else if($role == "teacher"){
			render("public/dashboard_system/dashboard_teacher.php",[]);
		}
	}
?>
