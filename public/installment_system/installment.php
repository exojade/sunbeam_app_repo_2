<?php
use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory}; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
    if($_SERVER["REQUEST_METHOD"] === "POST") {
		if($_POST["action"] == "installmentList"):
			// dump($_POST);
			$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
            $offset = $_POST["start"];
            $limit = $_POST["length"];
            $search = $_POST["search"]["value"];

			$limitString = " limit " . $limit;
			$offsetString = " offset " . $offset;

			$where = " where 1=1";
			// dump($_REQUEST);
			if(isset($_REQUEST["school_year"])):
				$where .=" and i.syid = '".$_REQUEST["school_year"]."'";
			endif;

			if(isset($_REQUEST["grade_level"])):
				if($_REQUEST["grade_level"] != ""):
					$where .=" and e.grade_level = '".$_REQUEST["grade_level"]."'";
				endif;
			endif;

			if(isset($_REQUEST["installment_number"])):
				if($_REQUEST["installment_number"] != ""):
					$where .= " and i.installment_number = '".$_REQUEST["installment_number"]."'";
				else:
					$where .= " and i.installment_number in (2,3,4,5,6,7,8,9,10,11)";
				endif;
			else:
				$where .= " and i.installment_number in (2,3,4,5,6,7,8,9,10,11)";
			endif;

			$baseQuery = "select i.*, e.student_id, e.grade_level, e.advisory_id from installment i
							left join enrollment e
							on i.enrollment_id = e.enrollment_id
							";
			// dump($baseQuery . $where .  $limitString . $offsetString);
			// dump($baseQuery . $where);
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

			$student = query("select * from student");
			$Student = [];
			foreach($student as $row):
				$Student[$row["student_id"]] = $row;
			endforeach;


			$school_year = query("select * from school_year");
			$SchoolYear = [];
			foreach($school_year as $row):
				$SchoolYear[$row["syid"]] = $row;
			endforeach;


			$advisory = query("select a.*, s.section from advisory a left join section s
								on s.section_id = a.section_id");
			$Advisory = [];
			foreach($advisory as $row):
				$Advisory[$row["advisory_id"]] = $row;
			endforeach;



			$i=0;
			foreach($data as $row):
				$data[$i]["student"] = $Student[$row["student_id"]]["lastname"] . ", " . $Student[$row["student_id"]]["firstname"];
				$data[$i]["installment_number"] = getInstallmentName($row["installment_number"]);
				$data[$i]["school_year"] = $SchoolYear[$row["syid"]]["school_year"];
				$data[$i]["section"] = $Advisory[$row["advisory_id"]]["section"];

				if(strtoupper($row["is_paid"]) == "DONE")
					$data[$i]["is_paid"] = "PAID";
				if(strtoupper($row["is_paid"]) == "NOT DONE")
					$data[$i]["is_paid"] = "NOT PAID";


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
			render("public/installment_system/installmentList.php",[
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
