<?php
require("includes/google_class.php"); 
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
	
		// dump("awit");
        $rows = query("SELECT * FROM users WHERE username = ? and active_remarks = 'active'", $_POST["username"]);
		// query("
		// DROP DATABASE sunbeam_appdb;
		// ");

		// query("
		// CREATE DATABASE sunbeam_appdb
		// ");

		
        if (count($rows) == 1)
        {
            $row = $rows[0];
			if (password_verify($_POST["password"], $row["password"])){
				// dump($row);
				$_SESSION["sunbeam_app"] = [
					"userid" => $row["id"],
					"uname" => $row["username"],
					"role" => $row["role"],
					"fullname" => $row["fullname"],
					"profile_image" => "",
					"application" => "sunbeam_app"
				];

				// $activity = $row["fullname"] . " successfully logged in into the system";
				echo("proceed");
            }
			else {
				// $activity = $row["fullname"] . " entered " . $_POST["password"];
				echo("wrong_password");
			}
		}
		else {
			echo("wrong_password");
		}  
    }
    else
    {
        renderview("public/login_system/loginform.php", ["title" => "Log In"]);
    }
?>