<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {

		if($_POST["action"] == "getData"):
			// dump($_GET);
			$pds = query("select * from student where student_id = ?", $_REQUEST["student_id"]);
			$data = $pds[0];
			echo json_encode($pds);
		endif;
		if($_POST["action"] == "studentList"):
			// dump($_POST);
			$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
            $offset = $_POST["start"];
            $limit = $_POST["length"];
            $search = $_POST["search"]["value"];

			$limitString = " limit " . $limit;
			$offsetString = " offset " . $offset;
			$orderString = " order by lastname asc, firstname asc";
			
			$where = "1=1";
	
			$baseQuery = "select *,
    TIMESTAMPDIFF(YEAR, birthDate, CURDATE()) AS age  from student where " . $where;

			if($search == ""):
                $data = query($baseQuery . " " . $orderString . " " .  $limitString . " " . $offsetString);
                $all_data = query($baseQuery);
            else:
                                // dump($query_string);
                $data = query($baseQuery . " and CONCAT(firstname, ' ', lastname) LIKE '%".$search."%'" . " " . $orderString . " " . $limitString . " " . $offsetString);
                $all_data = query($baseQuery . " and CONCAT(firstname, ' ', lastname) LIKE '%".$search."%'");
                // $all_data = $data;
            endif;






			$i = 0;
			foreach($data as $row):
				$data[$i]["action"] = '
				<a href="student?action=records&id='.$row["student_id"].'" class="btn btn-sm btn-info btn-block">View</a>
				';
				$data[$i]["address"] = $row["city_mun"] . ", " . $row["barangay"] . ", " . $row["address"];
                $i++;
            endforeach;
            $json_data = array(
                "draw" => $draw + 1,
                "iTotalRecords" => count($all_data),
                "iTotalDisplayRecords" => count($all_data),
                "aaData" => $data
            );
            echo json_encode($json_data);

		endif;

		if($_POST["action"] == "updateStudentInfo"):
			// dump($_POST);

			$student = $_POST["student"];

			query("
			update student
			set 
				lastname = ?,
				firstname = ?,
				middlename = ?,
				name_extension = ?,
				region = ?,
				province = ?,
				city_mun = ?,
				barangay = ?,
				address = ?,
				birthDate = ?,
				birthPlace = ?,
				sex = ?,
				religion = ?,
				father_lastname = ?,
				father_middlename = ?,
				father_firstname = ?,
				father_contact = ?,
				father_fb = ?,
				father_occupation = ?,
				father_education = ?,
				mother_lastname = ?,
				mother_middlename = ?,
				mother_firstname = ?,
				mother_contact = ?,
				mother_fb = ?,
				mother_occupation = ?,
				mother_education = ?,
				guardian_lastname = ?,
				guardian_middlename = ?,
				guardian_firstname = ?,
				guardian_phone = ?,
				guardian_occupation = ?
			where student_id = ?
			",
			$student["lastname"],
			$student["firstname"],
			$student["middlename"],
			$student["name_extension"],
			$student["region"],
			$student["province"],
			$student["city_mun"],
			$student["barangay"],
			$student["address"],
			$student["birthDate"],
			$student["birthPlace"],
			$student["sex"],
			$student["religion"],
			$student["father_lastname"],
			$student["father_middlename"],
			$student["father_firstname"],
			$student["father_contact"],
			$student["father_fb"],
			$student["father_occupation"],
			$student["father_education"],
			$student["mother_lastname"],
			$student["mother_middlename"],
			$student["mother_firstname"],
			$student["mother_contact"],
			$student["mother_fb"],
			$student["mother_occupation"],
			$student["mother_education"],
			$student["guardian_lastname"],
			$student["guardian_middlename"],
			$student["guardian_firstname"],
			$student["guardian_phone"],
			$student["guardian_occupation"],
			$student["student_id"]
		
		);

		echo(1);

		endif;


		if($_POST["action"] == "advisoryDetailsHTML"){
			

			$enrollment = query("select e.*, s.section, concat(t.teacher_lastname, ', ', t.teacher_firstname) as teacher,
									sy.school_year
									from enrollment e
									left join advisory a
									on a.advisory_id = e.advisory_id
									left join section s
									on s.section_id = a.section_id
									left join teacher t
									on t.teacher_id = a.teacher_id
									left join school_year sy
									on sy.syid = e.syid
									where e.enrollment_id = ?", $_POST["enrollment_id"]);
									// dump($enrollment);
									$enrollment = $enrollment[0];
			$html ='
			<tr>
                   <th>Grade Level:</th>
                   <td>'.$enrollment["grade_level"].'</td>
                   <th>Section:</th>
                   <td>'.$enrollment["section"].'</td>
                 </tr>

                 <tr>
                   <th>Adviser:</th>
                   <td>'.$enrollment["teacher"].'</td>
                   <th>School Year:</th>
                   <td>'.$enrollment["school_year"].'</td>
                 </tr>';
			

		

			echo($html);
		}

		if($_POST["action"] == "gradeList"){
			// dump($_REQUEST);
			$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
            $offset = $_POST["start"];
            $limit = $_POST["length"];
            $search = $_POST["search"]["value"];

			$limitString = " limit " . $limit;
			$offsetString = " offset " . $offset;

			// $sy = query("select * from school_year where active_status = 'ACTIVE'");
			// $sy = $sy[0];

			// $where = " where syid = '".$sy["syid"]."'";
			if(isset($_REQUEST["thisEnrollmentID"])):
				$_REQUEST["enrollment_id"] = $_REQUEST["thisEnrollmentID"];
			endif;

			


			$enrollment = query("select * from enrollment where enrollment_id = ?", $_REQUEST["enrollment_id"]);
			$e = $enrollment[0];

			$baseQuery = "select * from student_grades sg
							where student_id = '".$e["student_id"]."' and sg.advisory_id = '".$e["advisory_id"]."'";

			$student = query("select * from student where student_id = ?", $e["student_id"]);
			$student = $student[0];
		
			$subjects = query("select * from subjects sub left join subject_main sm on sm.subject_head_id = sub.subject_head_id");
			$Subjects = [];
			foreach($subjects as $row):
				$Subjects[$row["subject_id"]] = $row;
			endforeach;

			$data = query($baseQuery . " order by sg.grade_id asc " .  $limitString . $offsetString . " ");
			// dump($data);
			$all_data = query($baseQuery);
			// dump($Subjects);
		


			$i=0;
			foreach($data as $i => $row):
				// Adding the action button
				$data[$i]["action"] = '
					<a href="#" data-id="'.$row["grade_id"].'" data-toggle="modal" data-target="#updateGradesModal" class="btn btn-sm btn-block btn-warning">Update Grade</a>
				';
				
				// Determining the subject title
				$subject_title = "";
				if ($Subjects[$row["subject_id"]]["subject_type"] == "CHILD"):
					$subject_title = $Subjects[$Subjects[$row["subject_id"]]["subject_parent_id"]]["subject_head_name"] . " - " . $Subjects[$row["subject_id"]]["subject_title"];
				else:
					$subject_title = $Subjects[$row["subject_id"]]["subject_head_name"];
				endif;
				$data[$i]["subject"] = $subject_title;

				// if($student["grade_settings"] == "ACTIVE"):
					if (!empty($row["first_grading"]) && !empty($row["second_grading"]) && !empty($row["third_grading"]) && !empty($row["fourth_grading"])) {
						// If all grades are present, calculate the average
						$grades = [
							$row["first_grading"], 
							$row["second_grading"], 
							$row["third_grading"], 
							$row["fourth_grading"]
						];
				
						$average = array_sum($grades) / count($grades);  // Calculate the average
						$data[$i]["average"] = round($average);  // Round to the nearest whole number
				
						// Set remarks based on the average grade
						$data[$i]["remarks"] = ($average >= 75) ? "PASSED" : "FAILED";
					} else {
						// If any grade is missing, do not compute the average
						$data[$i]["average"] = null;
						$data[$i]["remarks"] = "";  // Remarks will be empty if grades are incomplete
					}
				// else:
				// 	$data[$i]["first_grading"] = "hidden";
				// 	$data[$i]["second_grading"] = "hidden";
				// 	$data[$i]["third_grading"] = "hidden";
				// 	$data[$i]["fourth_grading"] = "hidden";
				// 	$data[$i]["average"] = null;
				// 	$data[$i]["remarks"] = "";


				// endif;
				
				// Check if all grades are present
				
				
				$i++;
			endforeach;
            $json_data = array(
                "draw" => $draw + 1,
                "iTotalRecords" => count($all_data),
                "iTotalDisplayRecords" => count($all_data),
                "aaData" => $data
            );
            echo json_encode($json_data);

		}
		
		if($_POST["action"] == "updateGradesModal"):
			// dump($_POST);
			$myGrades = query("select sg.*, sm.subject_head_name from student_grades sg 
								left join subjects sub on sub.subject_id = sg.subject_id
								left join subject_main sm on sm.subject_head_id = sub.subject_head_id where grade_id = ?", $_POST["grade_id"]);
			$myGrade = $myGrades[0];
			$mySchedule = query("select sch.*, concat(teacher_lastname, ', ', teacher_firstname) as teacher from schedule sch
									left join teacher t on t.teacher_id = sch.teacher_id
									where schedule_id = ?", $myGrade["schedule_id"]);
			$mySchedule = $mySchedule[0];
			// dump($myGrade);


			$hint = '
			<input type="hidden" name="grade_id" value="'.$_POST["grade_id"].'">
			<table class="table table-bordered">
				<thead>
					<tr>	
						<th colspan="2">'.$mySchedule["teacher"].'</th>
						<th colspan="3">'.$mySchedule["from_time"].' - '.$mySchedule["to_time"].'</th>
					</tr>
					<tr>	
						<th width="20%">Subject</th>
						<th>1</th>
						<th>2</th>
						<th>3</th>
						<th>4</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>'.$myGrade["subject_head_name"].'</td>
						<td><input class="form-control" type="number" name="first_grading" value="'.$myGrade["first_grading"].'"></td>
						<td><input class="form-control" type="number" name="second_grading" value="'.$myGrade["second_grading"].'"></td>
						<td><input class="form-control" type="number" name="third_grading" value="'.$myGrade["third_grading"].'"></td>
						<td><input class="form-control" type="number" name="fourth_grading" value="'.$myGrade["fourth_grading"].'"></td>
					</tr>
				</tbody>
			</table>
			';
echo($hint);


		endif;

		if($_POST["action"] == "updateAllGrades"):
			// dump($_POST);
			query("update student_grades set first_grading = ?, second_grading = ?, third_grading = ?, fourth_grading = ?
			where grade_id = ?", $_POST["first_grading"], $_POST["second_grading"], $_POST["third_grading"], $_POST["fourth_grading"],
			$_POST["grade_id"]);

			$res_arr = [
				"result" => "success",
				"title" => "Submitted Successfully",
				"message" => "You have successfully updated the grade of your student! Please click OK to continue.",
				"link" => "refresh",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();
		endif;
		
		if($_POST["action"] == "captureForm137"){
			// dump($_POST);
					query("insert INTO captureform137 (school_name, school_id, district, division, region, grade_level, 
														section, school_year, adviser_name, student_id) 
					VALUES(?,?,?,?,?,?,?,?,?,?)", 
					$_POST["school_name"],
					$_POST["school_id"],
					$_POST["school_district"],
					$_POST["school_division"],
					$_POST["school_region"],
					$_POST["grade_level"],
					$_POST["section"],
					$_POST["school_year"],
					$_POST["adviser_name"],
					$_POST["student_id"]
				);


				$res_arr = [
					"result" => "success",
					"title" => "Success",
					"message" => "Success on updating data",
					"link" => "refresh",
					// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
					];
					echo json_encode($res_arr); exit();


		}

		if($_POST["action"] == "modalUpdateGrades"){
			// dump($_POST);

			$rows = query("select * from captureform137_grades where form137_id = ?", $_POST["form137_id"]);
			// dump($rows);
			$data = array();
			foreach($rows as $row):
				$datum = array(
					"subject" => $row["subject"],
					"first_grading" => $row["first_grading"],
					"second_grading" => $row["second_grading"],
					"third_grading" => $row["third_grading"],
					"fourth_grading" => $row["fourth_grading"],
					"final_rating" => $row["final_rating"],
					"remarks" => $row["remarks"]
				);
				$data[] = $datum;
			endforeach;
			echo json_encode($data);
		}

		if($_POST["action"] == "updateRequirementsModal"):
			// dump($_POST);
			$hint = "";
			$requirements = query("select * from enrollment_requirements where student_id = ?", $_POST["student_id"]);
			// dump($requirements);
			$options = ["YES", "NO", "NOT APPLICABLE"];
			foreach($requirements as $row):
				$hint.='
				<div class="form-group">
					<label>'.$row["document_name"].'</label>
					<select class="form-control" name="'.$row["tblid"].'">';
						foreach($options as $o):
							// dump($options);
							if($o == "YES")
								$hint.='<option ' . ($row["status"] == $o ? 'selected' : '') . ' value="'.$o.'"><i class="fa fa-check"></i> PROVIDED</option>';
							if($o == "NO")
								$hint.='<option ' . ($row["status"] == $o ? 'selected' : '') . ' value="'.$o.'"><i class="fa fa-check"></i> NOT PROVIDED</option>';
							if($o == "NOT APPLICABLE")
								$hint.='<option ' . ($row["status"] == $o ? 'selected' : '') . ' value="'.$o.'"><i class="fa fa-check"></i> NOT APPLICABLE</option>';
						endforeach;
					$hint.='
					</select>
				</div>
				';
			endforeach;
			// dump($hint);

			echo($hint);
			
		endif;

		if($_POST["action"] == "updateRequirements"):
			// dump($_POST);

			$requirements = query("select * from enrollment_requirements where student_id = ?", $_POST["student_id"]);
			foreach($requirements as $row):
				query("update enrollment_requirements set status = ?
				where tblid = ?", $_POST[$row["tblid"]], $row["tblid"]);
			endforeach;


			$res_arr = [
				"result" => "success",
				"title" => "Success",
				"message" => "Success on updating data",
				"link" => "refresh",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();
		endif;

		if($_POST["action"] == "updateGradeSettings"):
			// dump($_POST);
			if($_POST["trigger"] == "disable"):
				query("update student set grade_settings = ? where student_id = ?", "INACTIVE", $_POST["student_id"]);
				$title="Disabled Successfully!";
				$message = "You have successfully disabled the grade viewing! Please click OK to continue.";
			else:
				query("update student set grade_settings = ? where student_id = ?", "ACTIVE", $_POST["student_id"]);
				$title="Enabled Successfully!";
				$message = "You have successfully enabled the grade viewing! Please click OK to continue.";
			endif;
			$res_arr = [
				"result" => "success",
				"title" => $title,
				"message" => $message,
				"link" => "refresh",
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();

		endif;
		
    }


	
	else {

		if(!isset($_GET["action"])):
			render("public/student_system/studentList.php",[
			]);
		else:
			if($_GET["action"] == "specific"):
				render("public/student_system/studentSpecific.php",[
				]);
				elseif($_GET["action"] == "myStudent"):
					render("public/student_system/myStudentsForm.php",[
					]);

				

				elseif($_GET["action"] == "parentsList"):
					render("public/student_system/parentsList.php",[
					]);
					elseif($_GET["action"] == "records"):
						render("public/student_system/studentRecords.php",[
						]);

			endif;
		endif;
	}
?>
