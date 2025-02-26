<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {

		if($_POST["action"] == "addSchedule"):

			$sy = query("select * from school_year where active_status = 'ACTIVE'");
			$sy = $sy[0];
			$existingSchedules = query("select * from schedule where syid = ?", $sy["syid"]);
			// dump($_POST);

			


			$advisory_id = $_POST['advisory_id'];
			$subject_id = $_POST['subject'];
			$teacher_id = $_POST['teacher'];
			$start_time = $_POST['start_time']; // Assuming this is the start time for the schedule
			$end_time = $_POST['end_time']; // Assuming this is the start time for the schedule
			$days = array(
				'monday' => isset($_POST['monday']),
				'tuesday' => isset($_POST['tuesday']),
				'wednesday' => isset($_POST['wednesday']),
				'thursday' => isset($_POST['thursday']),
				'friday' => isset($_POST['friday'])
			);

			if($start_time == $end_time):
				$res_arr = [
					"result" => "failed",
					"title" => "Failed",
					"message" => "Time should be not be same!",
					"link" => "schedule",
					// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
					];
					echo json_encode($res_arr); exit();
			endif;

			$conflict = hasConflict($existingSchedules, $teacher_id, $advisory_id, $start_time, $end_time, $days);
			if ($conflict) {
				$res_arr = [
					"result" => "failed",
					"title" => "Failed",
					"message" => "Schedule already taken",
					"link" => "schedule",
					// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
					];
					echo json_encode($res_arr); exit();
			} else {
				// Insert the schedule
				$scheduleId = create_trackid("SCHED");
					query("insert INTO schedule (schedule_id, syid, advisory_id, subject_id, teacher_id, from_time, to_time, monday, tuesday, wednesday, thursday, friday) 
					VALUES(?,?,?,?,?,?,?,?,?,?,?,?)", 
					$scheduleId,
					$sy["syid"],
					$advisory_id,
					$subject_id,
					$teacher_id,
					$start_time,
					$end_time,
					$days['monday'] ? 1 : 0,
					$days['tuesday'] ? 1 : 0,
					$days['wednesday'] ? 1 : 0,
					$days['thursday'] ? 1 : 0,
					$days['friday'] ? 1 : 0,
				);

					$res_arr = [
						"result" => "success",
						"title" => "Success",
						"message" => "Success on updating data",
						"link" => "schedule",
						// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
						];
						echo json_encode($res_arr); exit();
			}

		elseif($_POST["action"] == "scheduleList"):

			$draw = isset($_POST["draw"]) ? $_POST["draw"] : 1;
            $offset = $_POST["start"];
            $limit = $_POST["length"];
            $search = $_POST["search"]["value"];


			$limitString = " limit " . $limit;
			$offsetString = " offset " . $offset;

			$sy = query("select * from school_year where active_status = 'ACTIVE'");
			$sy = $sy[0];

		

			$where = " where syid = '".$sy["syid"]."'";

			if(isset($_REQUEST["advisory"])):
				if($_REQUEST["advisory"] != ""):
					$where.=' and advisory_id = "'.$_REQUEST["advisory"].'"';
				endif;
			endif;


			if(isset($_REQUEST["teacher"])):
				if($_REQUEST["teacher"] != ""):
					$where.=' and teacher_id = "'.$_REQUEST["teacher"].'"';
				endif;
			endif;



			$baseQuery = "select * from schedule " . $where;

			$teacher = query("select * from teacher");
			$Teacher = [];
			foreach($teacher as $row):
				$Teacher[$row["teacher_id"]] = $row;
			endforeach;

			$section = query("select * from section");
			$Section = [];
			foreach($section as $row):
				$Section[$row["section_id"]] = $row;
			endforeach;

			$subjects = query("select * from subjects");
			$Subjects = [];
			foreach($subjects as $row):
				$Subjects[$row["subject_id"]] = $row;
			endforeach;

			$advisory = query("select * from advisory where school_year = ?", $sy["syid"]);
			$Advisory = [];
			foreach($advisory as $row):
				$Advisory[$row["advisory_id"]] = $row;
			endforeach;

		
			if($search == ""):
                $data = query($baseQuery . " " . $limitString . " " . $offsetString);
                $all_data = query($baseQuery);
            else:
                                // dump($query_string);
                $data = query($baseQuery . " and CONCAT(teacher_firstname, ' ', teacher_lastname) LIKE '%".$search."%'" . " " . $limitString . " " . $offsetString);
                $all_data = query($baseQuery . " and CONCAT(teacher_firstname, ' ', teacher_lastname) LIKE '%".$search."%'");
                // $all_data = $data;
            endif;


			$i = 0;
			foreach($data as $row):
				$data[$i]["action"] = '<div class="btn-group">
				<button type="button" class="btn btn-sm btn-flat btn-warning">Update</button>
				<form class="generic_form_trigger" data-url="schedule" style="display:inline;">
					<input type="hidden" name="action" value="deleteSchedule">
					<input type="hidden" name="schedule_id" value="'.$row["schedule_id"].'">
					<button type="submit" class="btn btn-sm btn-flat btn-danger">Delete</button>
				</form>
			
			  </div>';
			  $days_string = '';
			if ($row["monday"] == 1) {
				$days_string .= 'M,';
			}
			if ($row["tuesday"] == 1) {
				$days_string .= 'T,';
			}
			if ($row["wednesday"] == 1) {
				$days_string .= 'W,';
			}
			if ($row["thursday"] == 1) {
				$days_string .= 'TH,';
			}
			if ($row["friday"] == 1) {
				$days_string .= 'F,';
			}
		
			// Remove the trailing comma
			$days_string = rtrim($days_string, ',');
		
			// Assign the constructed string to the $data array
			// $data[$i]["day"] = $days_string;


				$data[$i]["school_year"] = $sy["syid"];
				$data[$i]["grade_level"] = $Advisory[$row["advisory_id"]]["grade_level"];
				$data[$i]["section"] = $Section[$Advisory[$row["advisory_id"]]["section_id"]]["section"];
				$data[$i]["subject"] = $Subjects[$row["subject_id"]]["subject_code"];
				$data[$i]["teacher"] = $Teacher[$row["teacher_id"]]["teacher_lastname"] . ", " . $Teacher[$row["teacher_id"]]["teacher_firstname"];
				$data[$i]["time_schedule"] = $row["from_time"] . " - " . $row["to_time"] . " | " . $days_string;


				


                $i++;
            endforeach;
            $json_data = array(
                "draw" => $draw + 1,
                "iTotalRecords" => count($all_data),
                "iTotalDisplayRecords" => count($all_data),
                "aaData" => $data
            );
            echo json_encode($json_data);

		elseif($_POST["action"] == "updateGradesModal"):
			
			
			$grading = $_POST["grading"];
			$grades = query("select concat(s.lastname, ', ', s.firstname ) as student,
								g.student_id, $grading, grade_id from student_grades g
								left join student s
								on s.student_id = g.student_id
								where g.schedule_id = ?
								and g.subject_id = ?
								order by s.lastname, s.firstname
								", $_POST["schedule_id"], $_POST["subject_id"]);
								// dump($grades);
			$hint = "";
			$hint.='
			
			<input type="hidden" name="action" value="updateGrades"> 
			<input type="hidden" name="schedule_id" value="'.$_POST["schedule_id"].'"> 
			<input type="hidden" name="subject_id" value="'.$_POST["subject_id"].'"> 
			<input type="hidden" name="grading" value="'.$grading.'">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th colspan="2">'.strtoupper($grading).'</th>
					</tr>
					<th>Student</th>
					<th>Grade</th>
				</thead>
				<tbody>';
				foreach($grades as $row):
					$hint.='<tr>';
						$hint.='<td>'.$row["student"].'</td>';
						$hint.='<td><input placeholder="Enter Grade Here" type="number" min="60" max="100" class="form-control" name="'.$row["grade_id"].'" value="'.$row[$grading].'"></td>';
					$hint.='</tr>';
				endforeach;
			$hint.='</tbody>
			</table>
			';

			echo($hint);

		elseif($_POST["action"] == "deleteSchedule"):
			// dump($_POST);
			$schedule = query("select * from schedule where schedule_id = ?", $_POST["schedule_id"]);
			$students = query("select * from enrollment where advisory_id = ?", $schedule[0]["advisory_id"]);
			if(!empty($students)):
				$res_arr = [
					"result" => "failed",
					"title" => "Failed",
					"message" => "Failed Deleting! Unenroll first students on this Advisory!",
					// "link" => "schedule?action=gradeTeacher&id=".$_POST["schedule_id"],
					// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
					];
					echo json_encode($res_arr); exit();
			else:
				query("delete from schedule where schedule_id = ?", $_POST["schedule_id"]);
				$res_arr = [
					"result" => "success",
					"title" => "Success",
					"message" => "Delete Successfully!",
					"link" => "schedule",
					// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
					];
					echo json_encode($res_arr); exit();
			endif;

		elseif($_POST["action"] == "updateGrades"):
			// dump($_POST);
			$grades = query("select * from student_grades where schedule_id = ? and subject_id = ?", $_POST["schedule_id"], $_POST["subject_id"]);
			$grading = $_POST["grading"];
			foreach($grades as $row):
				query("update student_grades set $grading = ?
							where grade_id = ?", $_POST[$row["grade_id"]], $row["grade_id"]);
			endforeach;
			$res_arr = [
				"result" => "success",
				"title" => "Updated Successfully",
				"message" => "Thank you! The student’s grade is now updated. Press OK to continue.",
				"link" => "schedule?action=gradeTeacher&id=".$_POST["schedule_id"]."&subject_id=".$_POST["subject_id"],
				// "html" => '<a href="#">View or Print '.$transaction_id.'</a>'
				];
				echo json_encode($res_arr); exit();
		endif;
    }
	else {

		if(!isset($_GET["action"])):

			if($_SESSION["sunbeam_app"]["role"] == "admin"):
				render("public/schedule_system/scheduleList.php",[
				]);
			elseif($_SESSION["sunbeam_app"]["role"] == "teacher"):
				render("public/schedule_system/scheduleTeacherList.php",[
				]);
			endif;
			
		else:
			if($_GET["action"] == "specific"):
				render("public/student_system/studentSpecific.php",[
				]);
			elseif($_GET["action"] == "gradeTeacher"):
				render("public/schedule_system/gradeTeacherList.php",[
				]);


			elseif($_GET["action"] == "childSubjects"):
				render("public/schedule_system/scheduleTeacherListSubSubjectsList.php",[
				]);


			endif;
		endif;
	}
?>
