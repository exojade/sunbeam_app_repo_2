<?php
use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory}; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
    if($_SERVER["REQUEST_METHOD"] === "POST") {
		if($_POST["action"] == "newEnrollment"):
			// dump($_POST);
			// $_POST["id_fee"] = filterize($_POST["id_fee"]);
			// $_POST["registration_fee"] = filterize($_POST["registration_fee"]);
			// $_POST["electricity_fee"] = filterize($_POST["electricity_fee"]);
			// $_POST["books_fee"] = filterize($_POST["books_fee"]);
			// $_POST["tuition_fee"] = filterize($_POST["tuition_fee"]);
			// $_POST["misc_fee"] = filterize($_POST["misc_fee"]);
			// $_POST["downpayment"] = filterize($_POST["downpayment"]);
			// $i=0;
			// foreach($_POST["account"] as $row):
			// 	$_POST["amount"][$i] = filterize($_POST["amount"][$i]);
			// 	$i++;
			// endforeach;

			$currSY = query("select * from school_year where active_status = 'ACTIVE'");
			$currSY = $currSY[0]["syid"];

			$student_id = create_trackid("LRN405592-");
			$nextId = query("show table status like 'student'");
			$nextId = $nextId[0]["Auto_increment"];
			$student_id = sprintf("LRN405592%08d", $nextId);
			// dump($nextId);

				query("insert INTO student (
					student_id,
					firstname,
					middlename,
					lastname,
					name_extension,
					region,
					province,
					city_mun,
					barangay,
					address,
					active_sy,
					birthDate,
					birthPlace,
					sex,
					religion,
					father_firstname,
					father_middlename,
					father_lastname,
					mother_firstname,
					mother_middlename,
					mother_lastname,
					father_contact,
					father_fb,
					mother_contact,
					mother_fb,
					father_occupation,
					father_education,
					mother_occupation,
					mother_education,
					guardian_firstname,
					guardian_middlename,
					guardian_lastname,
					guardian_phone,
					guardian_occupation
					) 
				VALUES(
					?,?,?,?,?,?,?,?,?,?,
					?,?,?,?,?,?,?,?,?,?,
					?,?,?,?,?,?,?,?,?,
					?,?,?,?,?
					)", 
				$student_id,
				$_POST["firstname"],
				$_POST["middlename"],
				$_POST["lastname"],
				$_POST["nameExtension"],
				$_POST["region"],
				$_POST["province"],
				$_POST["cityMun"],
				$_POST["barangay"],
				$_POST["address_home"],
				$currSY,
				$_POST["birthdate"],
				$_POST["birthplace"],
				$_POST["gender"],
				$_POST["religion"],
				$_POST["father_firstname"],
				$_POST["father_middlename"],
				$_POST["father_lastname"],
				$_POST["mother_firstname"],
				$_POST["mother_middlename"],
				$_POST["mother_lastname"],
				$_POST["father_contact"],
				$_POST["father_fb"],
				$_POST["mother_contact"],
				$_POST["mother_fb"],
				$_POST["father_occupation"],
				$_POST["father_education"],
				$_POST["mother_occupation"],
				$_POST["mother_education"],
				$_POST["guardian_firstname"],
				$_POST["guardian_middlename"],
				$_POST["guardian_lastname"],
				$_POST["guardian_contact"],
				$_POST["guardian_occupation"]
			);
			// dump($_POST);

			$advisory = query("select * from advisory where advisory_id = ?", $_POST["section"]);
			$advisory = $advisory[0];


			$enrollmentId = create_trackid("ENR");
			query("insert INTO enrollment (
				enrollment_id,
				dateEnrolled,
				syid,
				student_id,
				grade_level,
				advisory_id,
				status
				) 
			VALUES(?,?,?,?,?,?,?)", 
			$enrollmentId,
			date("Y-m-d H:i:s"),
			$currSY,
			$student_id,
			$advisory["grade_level"],
			$_POST["section"],
			"PENDING"
		);

		if($_POST["birthCertificate"] == "yes"):
			$_POST["birthCertificate"] = "YES";
		elseif($_POST["birthCertificate"] == "no"):
			$_POST["birthCertificate"] = "NO";
		elseif($_POST["birthCertificate"] == "na"):
			$_POST["birthCertificate"] = "NOT APPLICABLE";
		endif;


		if($_POST["goodMoral"] == "yes"):
			$_POST["goodMoral"] = "YES";
		elseif($_POST["goodMoral"] == "no"):
			$_POST["goodMoral"] = "NO";
		elseif($_POST["goodMoral"] == "na"):
			$_POST["goodMoral"] = "NOT APPLICABLE";
		endif;

		if($_POST["form137"] == "yes"):
			$_POST["form137"] = "YES";
		elseif($_POST["form137"] == "no"):
			$_POST["form137"] = "NO";
		elseif($_POST["form137"] == "na"):
			$_POST["form137"] = "NOT APPLICABLE";
		endif;

		query("insert INTO enrollment_requirements (
			enrollment_id,
			document_name,
			status,
			student_id
			) 
			VALUES(?,?,?,?)", 
			$enrollmentId,
			"BIRTH CERTIFICATE",
			$_POST["birthCertificate"],
			$student_id
		);


		query("insert INTO enrollment_requirements (
			enrollment_id,
			document_name,
			status,
			student_id
			) 
			VALUES(?,?,?,?)", 
			$enrollmentId,
			"GOOD MORAL",
			$_POST["goodMoral"],
			$student_id
		);


		query("insert INTO enrollment_requirements (
			enrollment_id,
			document_name,
			status,
			student_id
			) 
			VALUES(?,?,?,?)", 
			$enrollmentId,
			"FORM 137",
			$_POST["form137"],
			$student_id
		);
		



		// $EnrollmentFees = [];


		// $enrollment_fees["title"] = "ELECTRICITY FEE";
		// $enrollment_fees["amount"] = $_POST["electricity_fee"];
		// $EnrollmentFees[] = $enrollment_fees;

		// $enrollment_fees["title"] = "REGISTRATION FEE";
		// $enrollment_fees["amount"] = $_POST["registration_fee"];
		// $EnrollmentFees[] = $enrollment_fees;

		// $enrollment_fees["title"] = "BOOKS FEE";
		// $enrollment_fees["amount"] = $_POST["books_fee"];
		// $EnrollmentFees[] = $enrollment_fees;

		// $enrollment_fees["title"] = "TUITION FEE";
		// $enrollment_fees["amount"] = $_POST["tuition_fee"];
		// $EnrollmentFees[] = $enrollment_fees;

		// $enrollment_fees["title"] = "ID / INSUR. FEE";
		// $enrollment_fees["amount"] = $_POST["id_fee"];
		// $EnrollmentFees[] = $enrollment_fees;

		// $enrollment_fees["title"] = "MISCELLANEOUS FEE";
		// $enrollment_fees["amount"] = $_POST["misc_fee"];
		// $EnrollmentFees[] = $enrollment_fees;

		// $i=0;
		// foreach($_POST["account"] as $row):
		// 	$enrollment_fees["title"] = $_POST["account"][$i];
		// 	$enrollment_fees["amount"] = $_POST["amount"][$i];
		// 	$EnrollmentFees[] = $enrollment_fees;
		// 	$i++;
		// endforeach;
		// dump($EnrollmentFees);
		// $total = 0;
		// foreach($EnrollmentFees as $row):
		// 	$total += $row["amount"];
		// 	query("insert INTO enrollment_fees (
		// 		enrollment_id,
		// 		fee,
		// 		amount
		// 		) 
		// 	VALUES(?,?,?)", 
		// 	$enrollmentId,
		// 	$row["title"],
		// 	$row["amount"]
		// );
		// endforeach;
	// 	$balance = $total - $_POST["downpayment"];
	// 	$per_month = $balance / 10;
	// 	query("update enrollment set balance = ?, per_month = ? where enrollment_id = ?", $balance, $per_month ,$enrollmentId);
	// 	$paymentId = create_trackid("PAY");
	// 	query("insert INTO payment (
	// 		payment_id,
	// 		enrollment_id,
	// 		syid,
	// 		amount_paid,
	// 		date_paid,
	// 		method_of_payment,
	// 		or_number,
	// 		remarks,
	// 		paid_by
	// 		) 
	// 	VALUES(?,?,?,?,?,?,?,?,?)", 
	// 	$paymentId,
	// 	$enrollmentId,
	// 	$currSY,
	// 	$_POST["downpayment"],
	// 	date("Y-m-d H:i:s"),
	// 	"CASH",
	// 	$_POST["or_number"],
	// 	"DOWNPAYMENT",
	// 	$_POST["paid_by"],
	// );

	// $permonthfee = $balance / 10;

	// for ($i = 1; $i <= 10; $i++) {
	// 	query("insert INTO installment (
	// 		enrollment_id,
	// 		installment_number,
	// 		amount_due,
	// 		is_paid,
	// 		syid
	// 		) 
	// 	VALUES(?,?,?,?,?)", 
	// 	$enrollmentId,
	// 	$i,
	// 	$permonthfee,
	// 	0,
	// 	$currSY
	// );
    // }
// 	query("insert INTO users (
// 		id,
// 		username,
// 		password,
// 		role,
// 		active_remarks,
// 		fullname
// 		) 
// 	VALUES(?,?,?,?,?,?)", 
// 	$student_id,
// 	$student_id,
// 	password_hash("p@55word", PASSWORD_DEFAULT),
// 	"student",
// 	"active",
// 	$_POST["lastname"] . ", " . $_POST["firstname"],
// );


	$res_arr = [
		"result" => "success",
		"title" => "Success",
		"message" => "Successful Enrollment",
		"link" => "enrollment",
		// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
		];
		echo json_encode($res_arr); exit();

	elseif($_POST["action"] == "reEnroll"):
		// dump($_POST);

		$advisory = query("select * from advisory where advisory_id = ?", $_POST["advisory"]);

		$enrollmentId = create_trackid("ENR");
			query("insert INTO enrollment (
				enrollment_id,
				dateEnrolled,
				syid,
				student_id,
				grade_level,
				advisory_id,
				status
				) 
			VALUES(?,?,?,?,?,?,?)", 
			$enrollmentId,
			date("Y-m-d H:i:s"),
			$_POST["school_year"],
			$_POST["student"],
			$advisory[0]["grade_level"],
			$_POST["advisory"],
			"PENDING"
		);

		$res_arr = [
			"result" => "success",
			"title" => "Success",
			"message" => "Successful Enrollment",
			"link" => "enrollment",
			// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
			];
			echo json_encode($res_arr); exit();


		elseif($_POST["action"] == "enrollmentList"):
			// dump($_POST);
			$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
            $offset = $_POST["start"];
            $limit = $_POST["length"];
            $search = $_POST["search"]["value"];

			$limitString = " limit " . $limit;
			$offsetString = " offset " . $offset;

			$sy = query("select * from school_year where active_status = 'ACTIVE'");
			$sy = $sy[0];

			$where = " where syid = '".$sy["syid"]."'";

			if($_SESSION["sunbeam_app"]["role"] == "cashier"):
				$where .= " and status = 'PENDING'";
			endif;

		

			if(isset($_REQUEST["student_id"])):
				if($_REQUEST["student_id"] != ""):
					$where .= " and student_id = '".$_REQUEST["student_id"]."'";
				endif;
			endif;
			$baseQuery = "select * from enrollment " . $where . " order by dateEnrolled desc";

			if($search == ""):
                $data = query($baseQuery . " " . $limitString . " " . $offsetString);
                $all_data = query($baseQuery);
            else:
                                // dump($query_string);
                $data = query($baseQuery . " and CONCAT(teacher_firstname, ' ', teacher_lastname) LIKE '%".$search."%'" . " " . $limitString . " " . $offsetString);
                $all_data = query($baseQuery . " and CONCAT(teacher_firstname, ' ', teacher_lastname) LIKE '%".$search."%'");
                // $all_data = $data;
            endif;


			$students = query("select * from student");
			$Students = [];
			foreach($students as $row):
				$Students[$row["student_id"]] = $row;
			endforeach;

			$advisory = query("select a.*, s.section from advisory a 
								left join section s
								on s.section_id = a.section_id where school_year = ?", $sy["syid"]);
			$Advisory = [];
			foreach($advisory as $row):
				$Advisory[$row["advisory_id"]] = $row;
			endforeach;

			$teacher = query("select * from teacher");
			$Teacher = [];
			foreach($teacher as $row):
				$Teacher[$row["teacher_id"]] = $row;
			endforeach;



			$i = 0;
			foreach($data as $row):

				if($_SESSION["sunbeam_app"]["role"] == "admin"):
					$data[$i]["action"] = '

				

						<form class="generic_form_no_trigger" data-url="enrollment">
							<input type="hidden" name="action" value="printEnrollmentForm">
							<input type="hidden" name="enrollmentId" value="'.$row["enrollment_id"].'">
							<div class="btn-group btn-block">
								<button class="btn btn-success btn-sm" type="submit">Print Form</button>
								<a href="student?action=records&id='.$row["student_id"].'" class="btn btn-sm btn-info">View</a>
							</div>
						</div>
					';
				else:
					$data[$i]["action"] = '
						<a href="enrollment?action=cashier&id='.$row["enrollment_id"].'" class="btn btn-sm btn-warning btn-block">STEP 2</a>
					';
				endif;

				$student = $Students[$row["student_id"]];

				$data[$i]["student"] = $student["lastname"] .", " . $student["firstname"];		
				$data[$i]["dateEnrolled"] = date("Y-m-d h:i a", strtotime($row["dateEnrolled"]));		
				$data[$i]["section"] = "";
				$data[$i]["teacher"] = "";
				// $data[$i]["balance"] = to_peso($data[$i]["balance"]);
				if(isset($Advisory[$row["advisory_id"]])):
					$advisory = $Advisory[$row["advisory_id"]];
					$teacher = $Teacher[$advisory["teacher_id"]];
					$data[$i]["section"] = $advisory["section"];
					$data[$i]["teacher"] = $teacher["teacher_lastname"] . ", " . $teacher["teacher_firstname"];
				endif;


				


                $i++;
            endforeach;
            $json_data = array(
                "draw" => $draw + 1,
                "iTotalRecords" => count($all_data),
                "iTotalDisplayRecords" => count($all_data),
                "aaData" => $data
            );
            echo json_encode($json_data);

			elseif($_POST["action"] == "proceedDownpayment"):
				// dump($_SESSION);
				$enrollment = query("select * from enrollment where enrollment_id = ?", $_POST["enrollment_id"]);
				$fixedFees = query("select * from fees where grade_level = ? and fee_type = 'MAIN' and status = 'ACTIVE'", $enrollment[0]["grade_level"]);
				$otherFees = query("select * from enrollment_fees where enrollment_id = ?", $_POST["enrollment_id"]);

				$total_fee = 0;
				foreach($fixedFees as $row):
					$total_fee += floatval($row["fee_amount"]);
					query("insert INTO enrollment_fees (
						enrollment_id,
						fee,
						type,
						amount,
						status
						) 
					VALUES(
						?,?,?,?,?
						)", 
					$_POST["enrollment_id"],
					$row["fee_title"],
					$row["fee_type"],
					$row["fee_amount"],
					"PAYMENT"
				);
				endforeach;

				foreach($otherFees as $row):
					$total_fee += floatval($row["amount"]);
				endforeach;

				$newTotal = $total_fee - $_POST["downpayment"];

				$installment = round(round($newTotal, 2) / 10, 2);

			query("update enrollment set status = 'ENROLLED', monthly = ? where enrollment_id = ?",
						$installment, $_POST["enrollment_id"]);

			query("update student set current_enrollment_id = ? where student_id = ?",
			$_POST["enrollment_id"], $enrollment[0]["student_id"]);

			

			query("insert INTO payment (
					enrollment_id,
					syid,
					amount_paid,
					date_paid,
					method_of_payment,
					or_number,
					type,
					cashier
					) 
				VALUES(
					?,?,?,?,?,?,?,?
					)", 
				$_POST["enrollment_id"],
				$enrollment[0]["syid"],
				$_POST["downpayment"],
				date("Y-m-d H:i:00"),
				"CASH",
				$_POST["or_number"],
				"DOWNPAYMENT",
				$_SESSION["sunbeam_app"]["userid"]
			);
			$payment_id = query("SELECT LAST_INSERT_ID() as payment_id");
			$payment_id = $payment_id[0]["payment_id"];
				query("insert INTO installment (
								enrollment_id,
								amount_due,
								is_paid,
								installment_number,
								syid,
								type
								
								) 
							VALUES(
								?,?,?,?,?,?
								)", 
							$_POST["enrollment_id"],
							$_POST["downpayment"],
							"DONE",
							1,
							$enrollment[0]["syid"],
							"DOWNPAYMENT",
							
						);
				$installment_id = query("SELECT LAST_INSERT_ID() as installment_id");
				$installment_id = $installment_id[0]["installment_id"];
				query("insert INTO payment_installment (
					payment_id,
					installment_id,
					enrollment_id,
					from_balance,
					to_balance,
					paid,
					amount_due
					) 
				VALUES(
					?,?,?,?,?,?,?
					)", 
				$payment_id,
				$installment_id,
				$_POST["enrollment_id"],
				$total_fee,
				$newTotal,
				$_POST["downpayment"],
				$_POST["downpayment"]
			);


				for($i = 2; $i <= 11; $i++):
					query("insert INTO installment (
						enrollment_id,
						amount_due,
						is_paid,
						installment_number,
						syid
						) 
					VALUES(
						?,?,?,?,?
						)", 
					$_POST["enrollment_id"],
					$installment,
					"NOT DONE",
					$i,
					$enrollment[0]["syid"]
				);
				endfor;


				$schedules = query("SELECT * FROM schedule WHERE advisory_id = ?", $enrollment[0]["advisory_id"]);
				$TheSchedules = [];
				foreach($schedules as $row):
					$TheSchedules[$row["subject_id"]] = $row;
				endforeach;

				// dump($TheSchedules);


$subjectIds = array_column($schedules, 'subject_id'); // Assuming schedule has 'subject_id'
// dump($subjectIds);
$subjectIdsString = implode(',', array_map(function($id) {
    return "'$id'";
}, $subjectIds));
// dump($subjectIdsString);

// Fetch relevant subjects with schedule_id
$subjects = query("
    select * from subjects");
				// dump($TheSchedules);
			// $child
			// dump($subjects);
			foreach($subjects as $row):
				$schedule_id = "";
				if(isset($TheSchedules[$row["subject_id"]])):
					// dump($row);
					$childSubjects = query("select * from subjects where subject_parent_id = ?", $row["subject_id"]);

					if(!empty($childSubjects)):
						foreach($childSubjects as $child):
							$schedule_id = $TheSchedules[$row["subject_id"]]["schedule_id"];
							query("insert INTO student_grades (subject_id, schedule_id, student_id, advisory_id) 
								VALUES(?,?,?,?)", 
								$child["subject_id"],
								$schedule_id,
								$enrollment[0]["student_id"], $enrollment[0]["advisory_id"]
							);
						endforeach;
					else:
						$schedule_id = $TheSchedules[$row["subject_id"]]["schedule_id"];
						query("insert INTO student_grades (subject_id, schedule_id, student_id, advisory_id) 
							VALUES(?,?,?,?)", 
							$row["subject_id"],
							$schedule_id,
							$enrollment[0]["student_id"], $enrollment[0]["advisory_id"]
						);
					endif;
				endif;



			
			endforeach;


			



				




		$res_arr = [
		"result" => "success",
		"title" => "Success",
		"message" => "Successful Enrollment",
		"link" => "studentAccounts?action=specific&id=".$enrollment[0]["student_id"],
		// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
		];
		echo json_encode($res_arr); exit();







			elseif($_POST["action"] == "enrollmentCashierFee"):
				// dump($_POST);


				$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
				$offset = $_POST["start"];
				$limit = $_POST["length"];
				$search = $_POST["search"]["value"];
	
				$limitString = " limit " . $limit;
				$offsetString = " offset " . $offset;
			
	
			
				// $baseQuery = "select * from enrollment " . $where;

				$enrollment = query("select * from enrollment where enrollment_id = ?", $_POST["enrollment_id"]);
				$enrollment = $enrollment[0];

				$grade_level = $enrollment["grade_level"];
				$enrollment_id = $_POST["enrollment_id"];

				$data = query("
				SELECT 
    f.fee_title AS fee,
    f.fee_amount,
    f.fee_type,
    f.fees_id AS fee_id
FROM 
    fees f
WHERE 
    f.fee_type = 'MAIN'
    AND f.status = 'ACTIVE'
    AND f.grade_level = ?

UNION ALL

SELECT 
    f.fee_title AS fee,
    ef.amount AS  fee_amount,
    f.fee_type,
    f.fees_id AS fee_id
FROM 
    fees f
JOIN 
    enrollment_fees ef 
    ON ef.fees_id = f.fees_id
WHERE 
    ef.enrollment_id = ?
				",  $grade_level, $enrollment_id);
				// dump($sql);

				// $data = query($baseQuery);
				$all_data = $data;
	

	
	
	
				$i = 0;
				foreach($data as $row):
					if($row["fee_type"] == "MAIN" || $row["fee_type"] == "MISCELLANEOUS"):
						$data[$i]["action"] = '<button disabled class="btn btn-warning btn-block btn-sm">FIXED</button>';
					else:
						$data[$i]["action"] = '
						<form class="generic_form_trigger" data-url="enrollment">
							<input type="hidden" name="action" value="deleteFee">
							<input type="hidden" name="fee_id" value="'.$row["fee_id"].'">
						<button type="submit" class="btn btn-danger btn-block btn-sm">DELETE</button>
						</form>
						
						';
					endif;
					$i++;
				endforeach;
				$json_data = array(
					"draw" => $draw + 1,
					"iTotalRecords" => count($all_data),
					"iTotalDisplayRecords" => count($all_data),
					"aaData" => $data
				);
				echo json_encode($json_data);

		elseif($_POST["action"] == "addOn"):
					

			$addon = query("select * from fees where fees_id = ?", $_POST["addOns"]);
			$addon = $addon[0];
			// dump($addon);

			query("insert INTO enrollment_fees (
				enrollment_id,
				fee,
				type,
				amount,
				status,
				fees_id
				) 
			VALUES(
				?,?,?,?,?,?
				)", 
			$_POST["enrollment_id"],
			$addon["fee_title"],
			$addon["fee_type"],
			$_POST["amount"],
			"PAYMENT",
			$addon["fees_id"]
		);


			$res_arr = [
				"result" => "success",
				"title" => "Success",
				"message" => "Add-on payment added successfully",
				"link" => "refresh",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();

		elseif($_POST["action"] == "deleteFee"):
			// dump($_POST);
			query("delete from enrollment_fees where fees_id = ?", $_POST["fee_id"]);				
			$res_arr = [
				"result" => "success",
				"title" => "Success",
				"message" => "Successful Enrollment",
				"link" => "refresh",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();
		
				
		elseif($_POST["action"] == "printEnrollmentForm"):
			// dump($_POST);
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("reports/enrollment_form.xlsx");
			$sheet = $spreadsheet->getActiveSheet();

			$enrollment = query("select e.*, s.school_year from enrollment e 
									left join school_year s
									on s.syid = e.syid
									where e.enrollment_id = ?", $_POST["enrollmentId"]);
			// dump($enrollment);
			$enrollment = $enrollment[0];
			$student = query("select * from student where student_id = ?", $enrollment["student_id"]);
			$student = $student[0];

			// Get all drawings (shapes) in the sheet
			
			$sheet->setCellValue("C9", $enrollment["school_year"]);
			$sheet->setCellValue("D16", $student["student_id"]);
			$sheet->setCellValue("B18", strtoupper($student["lastname"]));
			$sheet->setCellValue("B20", strtoupper($student["firstname"]));
			$sheet->setCellValue("B22", strtoupper($student["middlename"]));

			$date = "2024-12-12";
			list($year, $month, $day) = explode("-", $student["birthDate"]);
			$sheet->setCellValue("B26", $month);
			$sheet->setCellValue("D26", $day);
			$sheet->setCellValue("F26", $year);
			$sheet->setCellValue("K26", calculateAge($student["birthDate"]));
			$sheet->setCellValue("B28", strtoupper($student["birthPlace"]));
			$sheet->setCellValue("H31", strtoupper($student["religion"]));
			$sheet->setCellValue("A35", strtoupper($student["address"]));
			$sheet->setCellValue("A37", strtoupper($student["barangay"]));
			$sheet->setCellValue("A39", strtoupper($student["city_mun"] . " , " . $student["province"] . ", PHILIPPINES"));
			$sheet->setCellValue("A43", strtoupper($student["father_lastname"]));
			$sheet->setCellValue("C43", strtoupper($student["father_firstname"]));
			$sheet->setCellValue("E43", strtoupper($student["father_middlename"]));
			$sheet->setCellValue("G43", strtoupper($student["mother_lastname"]));
			$sheet->setCellValue("I43", strtoupper($student["mother_firstname"]));
			$sheet->setCellValue("I16", strtoupper($enrollment["grade_level"]));
			$sheet->setCellValue("K43", strtoupper($student["mother_middlename"]));
			$sheet->setCellValue("A46", strtoupper($student["father_occupation"]));
			$sheet->setCellValue("A48", strtoupper($student["father_education"]));
			$sheet->setCellValue("G46", strtoupper($student["mother_occupation"]));
			$sheet->setCellValue("G48", strtoupper($student["mother_education"]));
			$sheet->setCellValue("B49", strtoupper($student["father_contact"]));
			$sheet->setCellValue("B50", strtoupper($student["father_fb"]));

			$sheet->setCellValue("A52", !empty($student["guardian_lastname"]) ? strtoupper($student["guardian_lastname"]) : "");
			$sheet->setCellValue("C52", !empty($student["guardian_firstname"]) ? strtoupper($student["guardian_firstname"]) : "");
			$sheet->setCellValue("E52", !empty($student["guardian_middlename"]) ? strtoupper($student["guardian_middlename"]) : "");
			$sheet->setCellValue("H52", !empty($student["guardian_occupation"]) ? strtoupper($student["guardian_occupation"]) : "");
			$sheet->setCellValue("H53", !empty($student["guardian_phone"]) ? strtoupper($student["guardian_phone"]) : "");


			if($student["sex"] == "Male"):
				$sheet->setCellValue("A82", 1);
				$sheet->setCellValue("B82", 0);
			else:
				$sheet->setCellValue("A82", 0);
				$sheet->setCellValue("B82", 1);
			endif;

			$sheet->setCellValue("H49", strtoupper($student["mother_contact"]));
			$sheet->setCellValue("H50", strtoupper($student["mother_fb"]));
			
			// $sheet->setCellValue("B7", $d["DeptCode"]);
			// $sheet->setCellValue("AG11", strtoupper(to_month($pg["month"])));
			// $sheet->setCellValue("AH11", strtoupper(to_month($pg["month"])));
			// $sheet->setCellValue("AG12", "1-15");
			// $sheet->setCellValue("AH12", "16-".$end_date);
			// $sheet->setCellValue("AF8", $date_prepared);
			// $sheet->setCellValue("AH8", $pg["time_created"]);


	
			$writer = new Xlsx($spreadsheet);
			$filename = "report.xlsx";
			$path = 'reports/'.$filename;
			$writer->save($path);
			$res_arr = [
				"result" => "success",
				"title" => "Success",
				"message" => "Success on updating data",
				"link" => $path,
				"newlink" => "newlink",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();
		elseif($_POST["action"] == "printSOA"):
			// dump($_POST);
			$enrollment_fees = query("select * from enrollment_fees where enrollment_id = ?", $_POST["enrollment_id"]);
			$enrollment = query("select e.*, sy.school_year from enrollment e
			left join school_year sy on sy.syid = e.syid where enrollment_id = ?", $_POST["enrollment_id"]);
			$enrollment = $enrollment[0];
			// dump($enrollment);
			$student = query("select * from student where student_id = ?", $enrollment["student_id"]);
			$student = $student[0];
			// $payment = query("select * from payment where enrollment_id = ?", $_POST["enrollment_id"]);
			$advisory = query("select a.*, s.section from advisory a
								left join section s
								on s.section_id = a.section_id
								where advisory_id = ?", $enrollment["advisory_id"]);

			$payment_installment = query("
			
			
			SELECT 
    p.*,
    ef.total_fee,
    (ef.total_fee - SUM(p2.amount_paid)) AS running_balance
FROM 
    payment p
LEFT JOIN 
    -- Subquery to calculate the total fees for the specific enrollment_id
    (SELECT enrollment_id, SUM(amount) AS total_fee
     FROM enrollment_fees
     WHERE enrollment_id = ? -- Filter for the specific enrollment_id
     GROUP BY enrollment_id) ef
ON 
    ef.enrollment_id = p.enrollment_id
LEFT JOIN 
    -- Self-join to calculate cumulative payments for the same enrollment_id
    payment p2 
ON 
    p2.enrollment_id = p.enrollment_id AND p2.payment_id <= p.payment_id
WHERE 
    p.enrollment_id = ? -- Filter for the specific enrollment_id
GROUP BY 
    p.payment_id, p.enrollment_id, ef.total_fee, p.amount_paid
ORDER BY 
    p.payment_id DESC;
			", $_POST["enrollment_id"], $_POST["enrollment_id"]);


			// $installment = query("select * from installment i
			// 						left join payment p
			// 						on p.payment_id = i.payment_id
			// 						where i.enrollment_id = ? and is_paid IN ('DONE', 'PROMISSORY')
			// 						order by date_paid desc
			// 						", $_POST["enrollment_id"]);
			// 						dump($installment);
			if(!empty($advisory)):
				$advisory = $advisory[0];
			endif;

			
			$downpayment = query("select * from payment where enrollment_id = ? and type='DOWNPAYMENT'", $_POST["enrollment_id"]);
			$users = query("select * from users");
			$Users = [];
			foreach($users as $row):
				$Users[$row["id"]] = $row;
			endforeach;
			// dump($downpayment);
			$downpayment = $downpayment[0];
					$mpdf = new \Mpdf\Mpdf([
						'mode' => 'utf-8', 'format' => 'A4',
						'debug' => true,
						'margin_top' => 15,
						'margin_left' => 5,
						'margin_right' => 5,
						'margin_bottom' => 5,
						'margin_footer' => 1,
						'default_font' => 'helvetica'
					]);
					// dump($mpdf);

					$html = "";

					$html .='
					<link rel="stylesheet" href="AdminLTE/dist/css/AdminLTE.min.css">
					<link rel="stylesheet" href="AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
					<link rel="stylesheet" href="AdminLTE/dist/css/skins/_all-skins.min.css">
					<style>
					.table, th, td, thead, tbody{
						border: 2px solid black !important;
						padding: 3px !important;
					}
					h5{
						margin:0px !important;
						padding:0px !important;
						margin-bottom: 4px !important
						font-size: 15px !important;
						font-weight: 800;
					}

					h4{
						margin:0px !important;
						padding:0px !important;
						margin-bottom: 4px !important
						font-size: 100px !important;
						font-weight: 800;
					}
					h5{
						margin:0px !important;
						padding:0px !important;
						margin-bottom: 4px !important
						font-size: 90px !important;
					}
					b{
						font-weight: bold;
					}

					</style>
				
					<div class="row">
						<div class="col-xs-2">
							<div class="text-center"><img src="resources/logo.png" width="85" height="85" class="img-responsive"></div>
						</div>
						<div class="col-xs-7">
							<h4 class="text-center"><b>SUNBEAM CHRISTIAN SCHOOL OF PANABO INC.</b></h4>
							<h5 class="text-center"><b>San Isidro St., Prk. Daisy Brgy Gredu, Panabo City</b></h5>
							<h5 class="text-center"><b>"The School Where True Wisdom Begins"</b></h5>
						</div>
					</div>

					<div class="background">
					<hr>
					<h1 style="margin-top:-10px;" class="text-center"><b>STATEMENT OF ACCOUNT</b></h1>
					<br>
					<div class="row">
					<div class="col-xs-6">
							<h5><b>STUDENT LEARNER ID:</b> '.$student["student_id"].'</h5>
						</div>
						<div class="col-xs-4">
							<h5><b>SCHOOL YEAR:</b> '.$enrollment["school_year"].'</h5>
						</div>
						<div class="col-xs-6">
							<h5><b>STUDENT NAME:</b> '.$student["lastname"] . ", " . $student["firstname"].'</h5>
						</div>
						<div class="col-xs-4">';

						if(!empty($advisory)):
							$html.='<h5><b>CLASS:</b> '.$enrollment["grade_level"] . " - " . $advisory["section"].'</h5>';
						else:
							$html.='<h5><b>CLASS:</b> '.$enrollment["grade_level"].'</h5>';
						endif;

						$html.='
						</div>
					</div>
					<br>

					<table id="feeTable" class="table table-bordered">
							
						<tbody>
						<td colspan="2" class="text-center">Enrollment Fees</td>
						';
						$total = 0;
						foreach($enrollment_fees as $row):
							$total+=floatval($row["amount"]);
							$html.='<tr>';
								$html.='<td><b>'.$row["fee"].'</b></td>';
								$html.='<td class="text-right">'.to_peso($row["amount"]).'</td>';
							$html.='</tr>';
							

						endforeach;
						$html.='<tr>';
								$html.='<td class="text-right"><b>Total</b></td>';
								$html.='<td class="text-right">'.to_peso($total).'</td>';
							$html.='</tr>';
							$html.='<tr>';
								$html.='<td class="text-right"><b>Downpayment (Upon Enrollment)</b></td>';
								$html.='<td class="text-right">('.to_peso($downpayment["amount_paid"]).')</td>';
							$html.='</tr>';
							$html.='<tr>';
								$html.='<td class="text-right"><b>Balance (Total Enrollment Fee - Downpayment)</b></td>';
								$html.='<td class="text-right">'.to_peso($total - $downpayment["amount_paid"]).'</td>';
							$html.='</tr>';
							$html.='<tr>';
								$html.='<td class="text-right"><b>Installment per Exam (total / 10)</b></td>';
								$html.='<td class="text-right">'.to_peso($enrollment["monthly"]).'</td>';
							$html.='</tr>';

					$html.='	</tbody>

					</table>
					
					<hr>
					<h3>Payment</h3>
					<table id="feeTable" class="table table-bordered">
						<tbody>
						<tr>
							<td><b>Date Paid</b></td>
							<td><b>Amount</b></td>
							<td><b>Remarks</b></td>
							<td><b>OR Number</b></td>
							<td><b>Balance</b></td>
							<td><b>Cashier</b></td>
						</tr>
						';	
						$total = 0;
						foreach($payment_installment as $row):
							// dump($row);
							// $payment = $

							// dump(date("F d, Y", strtotime($row["date_paid"])));
							$html.='<tr>';
							$html .= '<td>' . date("F d, Y", strtotime($row["date_paid"])) . '</td>';
								$html.='<td >'.to_peso($row["amount_paid"]).'</td>';
								$html.='<td >'.($row["type"]).'</td>';
								$html.='<td >'.($row["or_number"]).'</td>';
								$html.='<td >'.to_peso($row["running_balance"]).'</td>';
								$html.='<td >'.$Users[$row["cashier"]]["fullname"].'</td>';
							$html.='</tr>';
						endforeach;
					$html.='</tbody>

					</table>
					</div>

					<div style="position: absolute; bottom: 0; left: 0; right: 0; text-align: center; border-top:2px solid black;padding-top:20px; padding-bottom: 10px;">
					<div class="row">
						<div class="col-xs-10" style="padding-left: 30px;">
							<p style="text-align: left;"><b>For more info contact us:</b></p>
							<p style="text-align: left;"><b>Mobile:</b> 0910-6538-730 (<b>TNT</b>) / 0966-3524-915 (<b>GLOBE</b>)</p>
							<p style="text-align: left;"><b>FB Page:</b> Sunbeam Christian School of Panabo</p>
						</div>
					</div>
				</div>
					';

					$fullname = $student["lastname"] . ", " . $student["firstname"];

					$filename = "SOA - " . $fullname;
					$path = "reports/".$filename.".pdf";
					$mpdf->WriteHTML($html);
					$mpdf->Output($path, \Mpdf\Output\Destination::FILE);

					$res_arr = [
						"result" => "success",
						"title" => "Submitted Successfully",
						"newlink" => "newlink",
						"message" => "You have successfully downloaded the Statement of Account! Please click OK to continue.",
						"link" => $path,
						// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
						];
						echo json_encode($res_arr); exit();
					// dump($mpdf);
		endif;
    }
	else {
		if(!isset($_GET["action"])):
			render("public/enrollment_system/enrollmentList.php",[
			]);
		else:
			if($_GET["action"] == "new"):
				render("public/enrollment_system/newEnrollmentForm.php",[
				]);
			elseif($_GET["action"] == "specific"):
				render("public/enrollment_system/enrollmentSpecific.php",[
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
