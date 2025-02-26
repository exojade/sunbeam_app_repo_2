<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {
		if($_POST["action"] == "setSchoolYear"):
			query("update school_year set active_status = 'INACTIVE'");
			query("update school_year set active_status = 'ACTIVE' where syid = ?", $_POST["school_year"]);
			$res_arr = [
				"result" => "success",
				"title" => "Success",
				"message" => "Success on updating data",
				"link" => "settings",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();
		elseif($_POST["action"] == "addSchoolYear"): 
			// dump($_POST);
			$syid = create_trackid("SY");
			$school_year = $_POST["fromSY"]."-".$_POST["toSY"];
					query("insert INTO school_year (syid, school_year, active_status) 
					VALUES(?,?,?)", 
					$syid,
					$school_year,
					"INACTIVE"
				);

				$res_arr = [
					"result" => "success",
					"title" => "Success",
					"message" => "Success on adding School Year",
					"link" => "settings",
					// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
					];
					echo json_encode($res_arr); exit();
		
		elseif($_POST["action"] == "setGradeSettings"):
			// dump($_POST);
			$grading = $_POST["grading"];

			query("update settings set active_status = ? where grading_period = ?", $_POST["active_status"], $_POST["grading"]);
			$res_arr = [
				"result" => "success",
				"title" => "Success",
				"message" => "Success on Updating Grading Settings",
				"link" => "settings",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();
		
		endif;
    }
	else {

		if(!isset($_GET["action"])):
			render("public/settings_system/settingsForm.php",[
			]);
		else:
			if($_GET["action"] == "specific"):
				render("public/student_system/studentSpecific.php",[
				]);
			endif;
		endif;
	}
?>
