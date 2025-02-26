<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {

		
		
    }
	else {

		if(!isset($_GET["action"])):
			render("public/grade_system/gradeList.php",[
			]);
		else:
			if($_GET["action"] == "specific"):
				render("public/student_system/studentSpecific.php",[
				]);
			endif;
		endif;
	}
?>
