<?php
use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory}; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
    if($_SERVER["REQUEST_METHOD"] === "POST") {
		if($_POST["action"] == "parentsList"):
			// dump($_POST);
			$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
            $offset = $_POST["start"];
            $limit = $_POST["length"];
            $search = $_POST["search"]["value"];

			$limitString = " limit " . $limit;
			$offsetString = " offset " . $offset;

			$where = " where (parent_id != '' or parent_id is not null)";
			$baseQuery = "select * from student";
			// dump($baseQuery . $where .  $limitString . $offsetString);

			$data = query($baseQuery . $where .  $limitString . $offsetString);
			$all_data = query($baseQuery . $where);
			// dump($data);



			// if($search != ""):
			// 	$baseQuery .= " where firstname like '%".$search."%' or lastname like '%".$search."%'";
			// 	$data = query($baseQuery . $limitString . $offsetString);
			// else:
			// 	$data = query($baseQuery . $limitString . $offsetString);
			// 	$all_data = query($baseQuery);
			// endif;

			$users = query("select * from users where role = 'parent'");
			$Users = [];
			foreach($users as $row):
				$Users[$row["id"]] = $row;
			endforeach;
			$i=0;
			foreach($data as $row):
				$data[$i]["action"] = '<form class="generic_form_trigger" data-url="parents">
											<input type="hidden" name="action" value="deleteParent">
											<input type="hidden" name="student_id" value="'.$row["student_id"].'">
											<button class="btn btn-block btn-danger">REMOVE</button>
										</form>';
				$data[$i]["parent"] = $Users[$row["parent_id"]]["fullname"];
				$data[$i]["username"] = $Users[$row["parent_id"]]["username"];
				$data[$i]["student_name"] = $row["firstname"] . " " . $row["lastname"];
				$data[$i]["student_address"] = $row["city_mun"] . ", " . $row["barangay"] . ", " . $row["address"];
				$i++;
			endforeach;
            $json_data = array(
                "draw" => $draw + 1,
                "iTotalRecords" => count($all_data),
                "iTotalDisplayRecords" => count($all_data),
                "aaData" => $data
            );
            echo json_encode($json_data);

		elseif($_POST["action"] == "addParent"):
			// dump($_POST);

			query("update student set parent_id = ? where student_id = ?", $_POST["parent_id"], $_POST["student_id"]);
		
			$res_arr = [
				"result" => "success",
				"title" => "Success",
				"message" => "Successful Registering Parent",
				"link" => "parents",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();
		
		endif;
    }
	else {
		if(!isset($_GET["action"])):
			render("public/parents_system/parentsList.php",[
			]);
		else:
			if($_GET["action"] == "new"):
				render("public/enrollment_system/newEnrollmentForm.php",[
				]);
			elseif($_GET["action"] == "specific"):
				render("public/studentAccounts_system/studentAccountsSpecific.php",[
				]);
			elseif($_GET["action"] == "profile"):
				render("public/enrollment_system/enrollmentProfileStudent.php",[
				]);
			elseif($_GET["action"] == "cashier"):
				render("public/enrollment_system/enrollmentCashier.php",[
				]);

			endif;
		endif;
	}
?>
